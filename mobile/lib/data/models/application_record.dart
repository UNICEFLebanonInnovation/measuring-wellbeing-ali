import 'dart:convert';

import '../../domain/sdq_catalog.dart';

/// Pending local change for one stage of an application.
enum PendingAction { none, save, submit }

PendingAction pendingFromString(String? value) => switch (value) {
  'save' => PendingAction.save,
  'submit' => PendingAction.submit,
  _ => PendingAction.none,
};

String? pendingToString(PendingAction action) => switch (action) {
  PendingAction.none => null,
  PendingAction.save => 'save',
  PendingAction.submit => 'submit',
};

/// The answers and details of one questionnaire (pre-test or post-test).
///
/// [fields] holds every API field by its server name, including the 25
/// items, exactly as it will be sent. [scores] is only ever filled from the
/// server.
class TestData {
  TestData({Map<String, dynamic>? fields, Map<String, dynamic>? scores})
    : fields = Map<String, dynamic>.from(fields ?? const {}),
      scores = scores == null ? null : Map<String, dynamic>.from(scores);

  final Map<String, dynamic> fields;
  Map<String, dynamic>? scores;

  String? operator [](String key) => fields[key]?.toString();

  String? answer(String item) => this[item];

  int get answeredCount => sdqItems.where((i) => (fields[i.key] ?? '').toString().isNotEmpty).length;

  int get naCount => sdqItems.where((i) => (fields[i.key] ?? '').toString().toLowerCase() == 'na').length;

  bool get consentGiven => (fields['may_i_start_now'] ?? 'yes').toString().toLowerCase() == 'yes';

  double? get total => scores == null ? null : (scores!['total'] as num?)?.toDouble();

  /// Build from the `pre_test` / `post_test` object of the v1 API.
  factory TestData.fromApi(Map<String, dynamic> json) {
    final fields = <String, dynamic>{};
    json.forEach((key, value) {
      if (key == 'answers' || key == 'scores' || key == 'id' || key == 'type' || key == 'updated_at') return;
      if (key == 'services') {
        fields['do_the_child_receive_any_other_child_protection_services'] = (value as List?)?.map((e) => e.toString()).toList() ?? <String>[];
        return;
      }
      fields[key] = value;
    });
    final answers = (json['answers'] as Map<String, dynamic>?) ?? const {};
    answers.forEach((key, value) => fields[key] = value);
    return TestData(fields: fields, scores: json['scores'] as Map<String, dynamic>?);
  }

  /// Body for `PUT .../pre-test`, `PUT .../post-test` or the sync batch.
  Map<String, dynamic> toApi({required PendingAction action}) {
    final body = <String, dynamic>{};
    fields.forEach((key, value) {
      if (value == null) return;
      if (value is String && value.isEmpty) return;
      body[key] = value;
    });
    body['submit'] = action == PendingAction.submit ? 'submit' : 'save';
    return body;
  }

  String toJsonString() => jsonEncode({'fields': fields, 'scores': scores});

  factory TestData.fromJsonString(String? raw) {
    if (raw == null || raw.isEmpty) return TestData();
    final decoded = jsonDecode(raw) as Map<String, dynamic>;
    return TestData(fields: decoded['fields'] as Map<String, dynamic>?, scores: decoded['scores'] as Map<String, dynamic>?);
  }

  TestData copy() => TestData(fields: fields, scores: scores);
}

/// One child's application as stored on the device.
class ApplicationRecord {
  ApplicationRecord({
    required this.clientUuid,
    this.serverId,
    this.code,
    required this.status,
    this.statusId,
    this.year,
    this.language,
    TestData? preTest,
    TestData? postTest,
    this.prePending = PendingAction.none,
    this.postPending = PendingAction.none,
    this.syncError,
    this.preTestDate,
    this.postTestDate,
    this.serverUpdatedAt,
    DateTime? updatedAt,
    DateTime? createdAt,
  }) : preTest = preTest ?? TestData(),
       postTest = postTest ?? TestData(),
       updatedAt = updatedAt ?? DateTime.now(),
       createdAt = createdAt ?? DateTime.now();

  final String clientUuid;
  int? serverId;
  String? code;

  /// Status name as used by the server (`Pre Test`, `Post Test Pending`, `Done`, ...).
  String status;
  int? statusId;
  int? year;
  String? language;
  TestData preTest;
  TestData postTest;
  PendingAction prePending;
  PendingAction postPending;
  String? syncError;
  String? preTestDate;
  String? postTestDate;
  String? serverUpdatedAt;
  DateTime updatedAt;
  DateTime createdAt;

  bool get hasPendingChanges => prePending != PendingAction.none || postPending != PendingAction.none;

  bool get existsOnServer => serverId != null;

  /// Display code: the server code, or a placeholder until the first sync.
  String get displayCode => code ?? '— pending —';

  factory ApplicationRecord.fromApi(Map<String, dynamic> json) {
    return ApplicationRecord(
      clientUuid: (json['client_uuid'] as String?) ?? 'server-${json['id']}',
      serverId: (json['id'] as num?)?.toInt(),
      code: json['code'] as String?,
      status: (json['status'] ?? 'Pre Test') as String,
      statusId: (json['status_id'] as num?)?.toInt(),
      year: (json['year'] as num?)?.toInt(),
      language: json['language'] as String?,
      preTest: json['pre_test'] is Map<String, dynamic> ? TestData.fromApi(json['pre_test'] as Map<String, dynamic>) : null,
      postTest: json['post_test'] is Map<String, dynamic> ? TestData.fromApi(json['post_test'] as Map<String, dynamic>) : null,
      preTestDate: json['pre_test_date'] as String?,
      postTestDate: json['post_test_date'] as String?,
      serverUpdatedAt: json['updated_at'] as String?,
    );
  }

  Map<String, Object?> toRow() => {
    'client_uuid': clientUuid,
    'server_id': serverId,
    'code': code,
    'status': status,
    'status_id': statusId,
    'year': year,
    'language': language,
    'pre_json': preTest.toJsonString(),
    'post_json': postTest.toJsonString(),
    'pre_pending': pendingToString(prePending),
    'post_pending': pendingToString(postPending),
    'sync_error': syncError,
    'pre_test_date': preTestDate,
    'post_test_date': postTestDate,
    'server_updated_at': serverUpdatedAt,
    'updated_at': updatedAt.toIso8601String(),
    'created_at': createdAt.toIso8601String(),
  };

  factory ApplicationRecord.fromRow(Map<String, Object?> row) => ApplicationRecord(
    clientUuid: row['client_uuid'] as String,
    serverId: row['server_id'] as int?,
    code: row['code'] as String?,
    status: (row['status'] as String?) ?? 'Pre Test',
    statusId: row['status_id'] as int?,
    year: row['year'] as int?,
    language: row['language'] as String?,
    preTest: TestData.fromJsonString(row['pre_json'] as String?),
    postTest: TestData.fromJsonString(row['post_json'] as String?),
    prePending: pendingFromString(row['pre_pending'] as String?),
    postPending: pendingFromString(row['post_pending'] as String?),
    syncError: row['sync_error'] as String?,
    preTestDate: row['pre_test_date'] as String?,
    postTestDate: row['post_test_date'] as String?,
    serverUpdatedAt: row['server_updated_at'] as String?,
    updatedAt: DateTime.tryParse((row['updated_at'] as String?) ?? '') ?? DateTime.now(),
    createdAt: DateTime.tryParse((row['created_at'] as String?) ?? '') ?? DateTime.now(),
  );
}
