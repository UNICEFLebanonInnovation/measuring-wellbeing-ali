import 'dart:async';
import 'dart:io';

import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:uuid/uuid.dart';

import '../data/api/api_client.dart';
import '../data/models/application_record.dart';
import '../data/models/reference_data.dart';
import '../data/models/user_profile.dart';
import '../domain/application_status.dart';
import '../services/sync_service.dart';
import 'services.dart';

/// Overridden in `main` with the bootstrapped services.
final servicesProvider = Provider<AppServices>((ref) => throw UnimplementedError('servicesProvider must be overridden'));

// ---- Locale ---------------------------------------------------------------

class LocaleController extends Notifier<Locale?> {
  @override
  Locale? build() {
    final code = ref.read(servicesProvider).preferences.locale;
    return code == null ? null : Locale(code);
  }

  Future<void> set(Locale? locale) async {
    state = locale;
    await ref.read(servicesProvider).preferences.setLocale(locale?.languageCode);
  }
}

final localeProvider = NotifierProvider<LocaleController, Locale?>(LocaleController.new);

// ---- Auth -----------------------------------------------------------------

class AuthState {
  const AuthState({this.user, this.baseUrl, this.restored = false});
  final UserProfile? user;
  final String? baseUrl;

  /// True once the stored session has been read at start-up.
  final bool restored;

  bool get signedIn => user != null;

  /// Partners and read-only users can look but not collect.
  bool get canEdit => user != null && user!.isCollector && !user!.isReadOnly;

  AuthState copyWith({UserProfile? user, bool clearUser = false, String? baseUrl, bool? restored}) =>
      AuthState(user: clearUser ? null : (user ?? this.user), baseUrl: baseUrl ?? this.baseUrl, restored: restored ?? this.restored);
}

class AuthController extends Notifier<AuthState> {
  @override
  AuthState build() => const AuthState();

  AppServices get _s => ref.read(servicesProvider);

  Future<void> restore() async {
    final user = await _s.session.user();
    final token = await _s.session.token();
    state = AuthState(user: token == null ? null : user, baseUrl: _s.api.baseUrl, restored: true);
  }

  Future<void> signIn({required String email, required String password, required String baseUrl}) async {
    _s.api.baseUrl = baseUrl;
    await _s.session.saveBaseUrl(_s.api.baseUrl);
    final result = await _s.api.login(email: email, password: password, deviceName: _deviceName());
    final previous = await _s.session.user();
    if (previous != null && previous.id != result.user.id) {
      // A different person on the same tablet must not see the other's records.
      await _s.db.clearAll();
    }
    _s.api.token = result.token;
    await _s.session.saveToken(result.token);
    await _s.session.saveUser(result.user);
    state = AuthState(user: result.user, baseUrl: _s.api.baseUrl, restored: true);
    ref.invalidate(applicationsProvider);
    ref.invalidate(referenceProvider);
  }

  /// Refresh the profile silently; a 401 means the token was revoked.
  Future<void> refreshProfile() async {
    if (!state.signedIn) return;
    try {
      final user = await _s.api.me();
      await _s.session.saveUser(user);
      state = state.copyWith(user: user);
    } on ApiException catch (e) {
      if (e.isUnauthorized) await forceSignOut();
    }
  }

  Future<void> signOut() async {
    try {
      await _s.api.logout();
    } on ApiException {
      // Offline: the token stays valid server-side until the next sign in; local data is kept.
    }
    await forceSignOut();
  }

  Future<void> forceSignOut() async {
    _s.api.token = null;
    await _s.session.clearSession();
    state = AuthState(baseUrl: _s.api.baseUrl, restored: true);
  }

  String _deviceName() {
    try {
      return '${Platform.operatingSystem} ${Platform.operatingSystemVersion}'.trim();
    } catch (_) {
      return 'android';
    }
  }
}

final authProvider = NotifierProvider<AuthController, AuthState>(AuthController.new);

// ---- Connectivity -----------------------------------------------------------

final onlineProvider = StreamProvider<bool>((ref) async* {
  final connectivity = Connectivity();
  bool isOnline(List<ConnectivityResult> results) => results.any((r) => r != ConnectivityResult.none);
  yield isOnline(await connectivity.checkConnectivity());
  yield* connectivity.onConnectivityChanged.map(isOnline);
});

// ---- Reference data ---------------------------------------------------------

final referenceProvider = FutureProvider<ReferenceData?>((ref) async {
  final s = ref.watch(servicesProvider);
  return s.sync.cachedReference();
});

// ---- Applications -----------------------------------------------------------

class ApplicationsController extends AsyncNotifier<List<ApplicationRecord>> {
  AppServices get _s => ref.read(servicesProvider);

  @override
  Future<List<ApplicationRecord>> build() => _s.db.allApplications();

  Future<void> reload() async {
    state = AsyncData(await _s.db.allApplications());
  }

  Future<ApplicationRecord?> find(String clientUuid) => _s.db.application(clientUuid);

  /// Creates a new local application; the server assigns the code at the next sync.
  Future<ApplicationRecord> create({required String language}) async {
    final record = ApplicationRecord(clientUuid: const Uuid().v4(), status: ApplicationStatus.preTest, year: DateTime.now().year, language: language);
    await _s.db.upsert(record);
    await reload();
    return record;
  }

  Future<void> save(ApplicationRecord record) async {
    await _s.db.upsert(record);
    await reload();
  }

  Future<void> delete(ApplicationRecord record) async {
    if (record.existsOnServer) return;
    await _s.db.delete(record.clientUuid);
    await reload();
  }
}

final applicationsProvider = AsyncNotifierProvider<ApplicationsController, List<ApplicationRecord>>(ApplicationsController.new);

final applicationProvider = FutureProvider.family<ApplicationRecord?, String>((ref, uuid) async {
  ref.watch(applicationsProvider); // re-run when the list changes
  return ref.read(servicesProvider).db.application(uuid);
});

// ---- Sync -------------------------------------------------------------------

class SyncState {
  const SyncState({this.running = false, this.lastReport, this.error, this.lastSync, this.pendingCount = 0});
  final bool running;
  final SyncReport? lastReport;
  final String? error;
  final DateTime? lastSync;
  final int pendingCount;

  SyncState copyWith({bool? running, SyncReport? lastReport, String? error, bool clearError = false, DateTime? lastSync, int? pendingCount}) => SyncState(
    running: running ?? this.running,
    lastReport: lastReport ?? this.lastReport,
    error: clearError ? null : (error ?? this.error),
    lastSync: lastSync ?? this.lastSync,
    pendingCount: pendingCount ?? this.pendingCount,
  );
}

class SyncController extends Notifier<SyncState> {
  AppServices get _s => ref.read(servicesProvider);

  @override
  SyncState build() {
    ref.listen(applicationsProvider, (_, _) => refreshCounters());
    Future.microtask(refreshCounters);
    return const SyncState();
  }

  Future<void> refreshCounters() async {
    state = state.copyWith(pendingCount: await _s.db.pendingCount(), lastSync: await _s.sync.lastSync());
  }

  /// Runs a full cycle. Returns the report, or null when it failed (error is in state).
  Future<SyncReport?> run({bool fullPull = false}) async {
    if (state.running) return null;
    state = state.copyWith(running: true, clearError: true);
    try {
      final report = await _s.sync.run(fullPull: fullPull);
      state = state.copyWith(running: false, lastReport: report);
      ref.invalidate(referenceProvider);
      await ref.read(applicationsProvider.notifier).reload();
      await refreshCounters();
      return report;
    } on ApiException catch (e) {
      if (e.isUnauthorized) {
        await ref.read(authProvider.notifier).forceSignOut();
      }
      state = state.copyWith(running: false, error: e.message);
      await ref.read(applicationsProvider.notifier).reload();
      await refreshCounters();
      return null;
    } catch (e) {
      state = state.copyWith(running: false, error: e.toString());
      await refreshCounters();
      return null;
    }
  }
}

final syncProvider = NotifierProvider<SyncController, SyncState>(SyncController.new);
