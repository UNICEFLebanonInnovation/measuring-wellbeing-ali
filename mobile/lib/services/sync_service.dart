import 'dart:convert';

import '../core/config.dart';
import '../data/api/api_client.dart';
import '../data/local/app_database.dart';
import '../data/models/application_record.dart';
import '../data/models/reference_data.dart';

/// Summary of one sync run, shown in the snackbar.
class SyncReport {
  const SyncReport({required this.pushed, required this.pulled, required this.rejected, this.referenceUpdated = false});
  final int pushed;
  final int pulled;
  final int rejected;
  final bool referenceUpdated;
}

/// Moves data between the device and the server.
///
/// Push: every record with a pending stage. Records that do not exist on the
/// server yet go through `POST /sync` in batches (the server creates them and
/// assigns the code); records that already have a server id use the single
/// `PUT` endpoints so a validation failure is reported precisely.
///
/// Pull: `GET /applications?updated_since=` upserts server state without
/// overwriting a stage that still has local changes.
class SyncService {
  SyncService({required this.api, required this.db});

  final ApiClient api;
  final AppDatabase db;

  static const metaLastSync = 'last_sync_at';
  static const metaReferenceJson = 'reference_json';
  static const metaReferenceEtag = 'reference_etag';

  Future<SyncReport> run({bool fullPull = false}) async {
    final pushed = await push();
    final pulled = await pull(full: fullPull);
    final reference = await refreshReference();
    return SyncReport(pushed: pushed.$1, rejected: pushed.$2, pulled: pulled, referenceUpdated: reference != null);
  }

  /// Returns (accepted, rejected).
  Future<(int, int)> push() async {
    final pending = await db.pendingApplications();
    var accepted = 0;
    var rejected = 0;

    final newOnes = pending.where((r) => !r.existsOnServer).toList();
    final existing = pending.where((r) => r.existsOnServer).toList();
    for (var i = 0; i < newOnes.length; i += AppConfig.syncBatchSize) {
      final batch = newOnes.sublist(i, (i + AppConfig.syncBatchSize).clamp(0, newOnes.length));
      final results = await api.sync(batch.map(_syncItem).toList());
      final byUuid = {for (final r in results) r.clientUuid: r};
      for (final record in batch) {
        final result = byUuid[record.clientUuid];
        if (result == null) {
          record.syncError = 'No result returned by the server';
          rejected++;
        } else if (_applySyncResult(record, result)) {
          accepted++;
        } else {
          rejected++;
        }
        await db.upsert(record);
      }
    }

    for (final record in existing) {
      if (await _pushExisting(record)) {
        accepted++;
      } else {
        rejected++;
      }
      await db.upsert(record);
    }

    return (accepted, rejected);
  }

  Map<String, dynamic> _syncItem(ApplicationRecord r) => {
    'client_uuid': r.clientUuid,
    if (r.language != null) 'language': r.language,
    if (r.prePending != PendingAction.none) 'pre_test': r.preTest.toApi(action: r.prePending),
    if (r.postPending != PendingAction.none) 'post_test': r.postTest.toApi(action: r.postPending),
  };

  /// Applies the server's answer to a batch item. Returns true when nothing was rejected.
  bool _applySyncResult(ApplicationRecord record, SyncItemResult result) {
    record.serverId = result.id ?? record.serverId;
    record.code = result.code ?? record.code;
    if (result.status != null) record.status = result.status!;

    var ok = true;
    final stages = {'pre_test': PendingAction.none, 'post_test': PendingAction.none};
    for (final stage in stages.keys) {
      final pending = stage == 'pre_test' ? record.prePending : record.postPending;
      if (pending == PendingAction.none) continue;
      final outcome = result.stageResult(stage);
      if (outcome == 'error') {
        ok = false;
        continue; // keep pending so the collector can fix and resend
      }
      // updated, or skipped because the server already holds a submitted copy
      if (stage == 'pre_test') {
        record.prePending = PendingAction.none;
      } else {
        record.postPending = PendingAction.none;
      }
    }
    record.syncError = ok ? null : result.errorSummary();
    if (result.isError && result.id == null) {
      // Could not even create the application (quota, forbidden...).
      record.syncError = result.errorSummary();
      ok = false;
    }
    return ok;
  }

  Future<bool> _pushExisting(ApplicationRecord record) async {
    var ok = true;
    final id = record.serverId!;
    try {
      if (record.prePending != PendingAction.none) {
        final updated = await api.savePreTest(id, record.preTest.toApi(action: record.prePending));
        _absorb(record, updated, keepPostPending: true);
        record.prePending = PendingAction.none;
      }
      if (record.postPending != PendingAction.none) {
        final updated = await api.savePostTest(id, record.postTest.toApi(action: record.postPending));
        _absorb(record, updated, keepPostPending: false);
        record.postPending = PendingAction.none;
      }
      record.syncError = null;
    } on ApiException catch (e) {
      if (e.isNetwork) rethrow;
      ok = false;
      if (e.statusCode == 422 && e.errors.isEmpty) {
        // Business rule: stage already submitted on the server. Local copy is stale; drop the pending flag.
        record.syncError = e.message;
        if (record.prePending != PendingAction.none) record.prePending = PendingAction.none;
        record.postPending = PendingAction.none;
        try {
          _absorb(record, await api.application(id), keepPostPending: false);
        } on ApiException {
          // keep whatever we have
        }
      } else {
        record.syncError = e.errors.isEmpty ? e.message : e.errors.entries.map((en) => '${en.key}: ${en.value.join(' ')}').join('\n');
      }
    }
    return ok;
  }

  /// Copies server fields into [record], keeping stages that still have local edits.
  void _absorb(ApplicationRecord record, ApplicationRecord server, {required bool keepPostPending}) {
    record.serverId = server.serverId ?? record.serverId;
    record.code = server.code ?? record.code;
    record.status = server.status;
    record.statusId = server.statusId ?? record.statusId;
    record.year = server.year ?? record.year;
    record.language = server.language ?? record.language;
    record.preTestDate = server.preTestDate;
    record.postTestDate = server.postTestDate;
    record.serverUpdatedAt = server.serverUpdatedAt;
    record.preTest = server.preTest;
    if (!(keepPostPending && record.postPending != PendingAction.none)) {
      record.postTest = server.postTest;
    }
  }

  /// Downloads changed applications. Returns the number of records written.
  Future<int> pull({bool full = false}) async {
    final lastRaw = full ? null : await db.meta(metaLastSync);
    final since = lastRaw == null ? null : DateTime.tryParse(lastRaw)?.subtract(const Duration(minutes: 5));
    final startedAt = DateTime.now().toUtc();

    var page = 1;
    var written = 0;
    while (true) {
      final result = await api.applications(updatedSince: since, page: page, perPage: 100);
      for (final server in result.items) {
        final local = await db.application(server.clientUuid) ?? (server.serverId == null ? null : await db.applicationByServerId(server.serverId!));
        if (local == null) {
          await db.upsert(server);
          written++;
          continue;
        }
        if (local.hasPendingChanges) {
          // Keep local edits; still take ids/codes/dates from the server.
          local.serverId = server.serverId ?? local.serverId;
          local.code = server.code ?? local.code;
          local.year = server.year ?? local.year;
          if (local.prePending == PendingAction.none) local.preTest = server.preTest;
          if (local.postPending == PendingAction.none) local.postTest = server.postTest;
          local.serverUpdatedAt = server.serverUpdatedAt;
          await db.upsert(local);
        } else {
          server.syncError = null;
          await db.upsert(server);
        }
        written++;
      }
      if (!result.hasMore) break;
      page++;
    }
    await db.setMeta(metaLastSync, startedAt.toIso8601String());
    return written;
  }

  /// Fetches reference data when the server's ETag changed. Returns the new data, or null.
  Future<ReferenceData?> refreshReference() async {
    final etag = await db.meta(metaReferenceEtag);
    final response = await api.reference(etag: etag);
    if (response.notModified || response.data == null) return null;
    await db.setMeta(metaReferenceJson, jsonEncode(response.data!.raw));
    await db.setMeta(metaReferenceEtag, response.etag);
    return response.data;
  }

  Future<ReferenceData?> cachedReference() async {
    final raw = await db.meta(metaReferenceJson);
    if (raw == null) return null;
    return ReferenceData.fromJson(jsonDecode(raw) as Map<String, dynamic>);
  }

  Future<DateTime?> lastSync() async {
    final raw = await db.meta(metaLastSync);
    return raw == null ? null : DateTime.tryParse(raw)?.toLocal();
  }
}
