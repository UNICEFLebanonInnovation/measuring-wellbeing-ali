import 'dart:convert';

import 'package:measuring_wellbeing/data/api/api_client.dart';
import 'package:measuring_wellbeing/data/local/app_database.dart';
import 'package:measuring_wellbeing/data/models/application_record.dart';
import 'package:measuring_wellbeing/data/models/reference_data.dart';
import 'package:measuring_wellbeing/data/models/user_profile.dart';
import 'package:sqflite_common_ffi/sqflite_ffi.dart';

/// In-memory, unencrypted database for tests.
AppDatabase testDatabase() {
  sqfliteFfiInit();
  return AppDatabase(
    () => databaseFactoryFfiNoIsolate.openDatabase(
      inMemoryDatabasePath,
      options: OpenDatabaseOptions(version: AppDatabase.schemaVersion, onCreate: (db, _) => AppDatabase.createSchema(db)),
    ),
  );
}

final sampleUser = UserProfile.fromJson({
  'id': 44,
  'name': 'Collector One',
  'email': 'collector1@akkar.akkar',
  'roles': ['collector'],
  'is_readonly': false,
  'locale': 'en',
  'partner': {'name': 'Akkar', 'prefix': 'AKK'},
  'collector': {'prefix': 'C1'},
});

final sampleReference = ReferenceData.fromJson({
  'version': 'v1',
  'statuses': [
    {'id': 2, 'name': 'Pre Test'},
    {'id': 5, 'name': 'Post Test'},
  ],
  'governorates': [
    {
      'id': 1,
      'name': 'Akkar',
      'arabic': 'عكار',
      'cazas': [
        {
          'id': 3,
          'name': 'Akkar',
          'arabic': 'عكار',
          'areas': [
            {'id': 3, 'name': 'Aadouiye', 'arabic': 'عدوي'},
          ],
        },
      ],
    },
  ],
  'options': {
    'forms': ['Form 6-11', 'Form 12-17'],
    'items': <String>[],
  },
  'scoring': {'policy': 'documented', 'max_na_answers': 3},
});

Map<String, dynamic> serverApplication({
  required int id,
  required String uuid,
  String status = 'Post Test',
  Map<String, dynamic>? preTest,
  Map<String, dynamic>? postTest,
}) => {
  'id': id,
  'code': '2026-AKK-C1-$id',
  'client_uuid': uuid,
  'year': 2026,
  'language': 'en',
  'status': status,
  'status_id': 5,
  'pre_test_date': '2026-03-10',
  'post_test_date': null,
  'pre_test':
      preTest ??
      {
        'type': 'pre_test',
        'form': 'Form 6-11',
        'age': '8',
        'answers': {'often_loses_temper': '1'},
        'services': ['Case management'],
        'scores': {'total': 12},
      },
  'post_test': postTest,
  'updated_at': '2026-03-10T10:15:00+03:00',
};

/// Scripted API: each call returns what the test configured and records what it received.
class FakeApi extends ApiClient {
  FakeApi() : super(baseUrl: 'https://example.test');

  bool offline = false;
  String? etag;
  ReferenceData? referenceData = sampleReference;
  List<Map<String, dynamic>> serverApplications = [];
  List<Map<String, dynamic>> syncRequests = [];
  List<(int, Map<String, dynamic>)> preTestPuts = [];
  List<(int, Map<String, dynamic>)> postTestPuts = [];
  List<SyncItemResult> Function(List<Map<String, dynamic>>)? onSync;
  ApplicationRecord Function(int, Map<String, dynamic>)? onPreTest;
  ApplicationRecord Function(int, Map<String, dynamic>)? onPostTest;
  LoginResult Function(String email, String password)? onLogin;

  void _network() {
    if (offline) throw const ApiException('offline', isNetwork: true);
  }

  @override
  Future<LoginResult> login({required String email, required String password, required String deviceName}) async {
    _network();
    if (onLogin != null) return onLogin!(email, password);
    if (password != 'secret') throw const ApiException('Invalid credentials', statusCode: 401);
    return LoginResult(token: 'tok', user: sampleUser);
  }

  @override
  Future<void> logout() async {}

  @override
  Future<UserProfile> me() async {
    _network();
    return sampleUser;
  }

  @override
  Future<ReferenceResponse> reference({String? etag}) async {
    _network();
    if (etag != null && etag == this.etag) return ReferenceResponse(etag: etag, notModified: true);
    return ReferenceResponse(data: referenceData, etag: this.etag ?? referenceData?.version, notModified: false);
  }

  @override
  Future<ApplicationPage> applications({DateTime? updatedSince, int page = 1, int perPage = 100}) async {
    _network();
    final items = serverApplications.map((e) => ApplicationRecord.fromApi(jsonDecode(jsonEncode(e)) as Map<String, dynamic>)).toList();
    return ApplicationPage(items: items, currentPage: 1, lastPage: 1);
  }

  @override
  Future<ApplicationRecord> application(int id) async {
    _network();
    final found = serverApplications.firstWhere((e) => e['id'] == id);
    return ApplicationRecord.fromApi(jsonDecode(jsonEncode(found)) as Map<String, dynamic>);
  }

  @override
  Future<ApplicationRecord> savePreTest(int id, Map<String, dynamic> body) async {
    _network();
    preTestPuts.add((id, body));
    return onPreTest!(id, body);
  }

  @override
  Future<ApplicationRecord> savePostTest(int id, Map<String, dynamic> body) async {
    _network();
    postTestPuts.add((id, body));
    return onPostTest!(id, body);
  }

  @override
  Future<List<SyncItemResult>> sync(List<Map<String, dynamic>> applications) async {
    _network();
    syncRequests.addAll(applications);
    return onSync!(applications);
  }
}
