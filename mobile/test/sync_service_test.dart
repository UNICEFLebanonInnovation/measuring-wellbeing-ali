import 'package:flutter_test/flutter_test.dart';
import 'package:measuring_wellbeing/data/api/api_client.dart';
import 'package:measuring_wellbeing/data/local/app_database.dart';
import 'package:measuring_wellbeing/data/models/application_record.dart';
import 'package:measuring_wellbeing/services/sync_service.dart';

import 'helpers/fakes.dart';

void main() {
  late FakeApi api;
  late AppDatabase db;
  late SyncService sync;

  setUp(() {
    api = FakeApi();
    db = testDatabase();
    sync = SyncService(api: api, db: db);
  });

  tearDown(() => db.close());

  ApplicationRecord localDraft(String uuid, {PendingAction pre = PendingAction.submit}) => ApplicationRecord(
    clientUuid: uuid,
    status: 'Pre Test Pending',
    year: 2026,
    language: 'en',
    preTest: TestData(fields: {'form': 'Form 6-11', 'age': '8', 'may_i_start_now': 'yes'}),
    prePending: pre,
  );

  test('new applications are uploaded through /sync and get their server code', () async {
    await db.upsert(localDraft('uuid-1'));
    api.onSync = (items) => [
      SyncItemResult(
        clientUuid: 'uuid-1',
        result: 'created',
        id: 101,
        code: '2026-AKK-C1-7',
        status: 'Post Test',
        stages: {
          'pre_test': {'result': 'updated', 'submitted': true},
        },
      ),
    ];

    final (accepted, rejected) = await sync.push();

    expect(accepted, 1);
    expect(rejected, 0);
    expect(api.syncRequests.single['client_uuid'], 'uuid-1');
    expect(api.syncRequests.single['pre_test']['submit'], 'submit');
    expect(api.syncRequests.single.containsKey('post_test'), isFalse);

    final stored = (await db.application('uuid-1'))!;
    expect(stored.serverId, 101);
    expect(stored.code, '2026-AKK-C1-7');
    expect(stored.status, 'Post Test');
    expect(stored.prePending, PendingAction.none);
    expect(stored.syncError, isNull);
    expect(await db.pendingCount(), 0);
  });

  test('a stage rejected by validation stays pending with the server message', () async {
    await db.upsert(localDraft('uuid-2'));
    api.onSync = (items) => [
      SyncItemResult(
        clientUuid: 'uuid-2',
        result: 'error',
        id: 102,
        code: '2026-AKK-C1-8',
        status: 'Pre Test',
        errors: [
          {
            'age': ['The age field must be between 6 and 11.'],
          },
        ],
        stages: {
          'pre_test': {'result': 'error'},
        },
      ),
    ];

    final (accepted, rejected) = await sync.push();

    expect(accepted, 0);
    expect(rejected, 1);
    final stored = (await db.application('uuid-2'))!;
    expect(stored.serverId, 102, reason: 'the application was created even though the stage failed');
    expect(stored.prePending, PendingAction.submit);
    expect(stored.syncError, contains('age: The age field must be between 6 and 11.'));
  });

  test('a stage skipped because it was already submitted is cleared, not retried forever', () async {
    await db.upsert(localDraft('uuid-3'));
    api.onSync = (items) => [
      SyncItemResult(
        clientUuid: 'uuid-3',
        result: 'skipped',
        id: 103,
        code: 'X',
        status: 'Post Test',
        stages: {
          'pre_test': {'result': 'skipped', 'reason': 'Stage not editable'},
        },
      ),
    ];
    await sync.push();
    expect((await db.application('uuid-3'))!.prePending, PendingAction.none);
  });

  test('applications already on the server use the single PUT endpoints', () async {
    final record = localDraft('uuid-4')
      ..serverId = 104
      ..code = '2026-AKK-C1-9';
    await db.upsert(record);
    api.onPreTest = (id, body) => ApplicationRecord.fromApi(serverApplication(id: id, uuid: 'uuid-4', status: 'Post Test'));

    final (accepted, _) = await sync.push();

    expect(accepted, 1);
    expect(api.preTestPuts.single.$1, 104);
    expect(api.syncRequests, isEmpty);
    final stored = (await db.application('uuid-4'))!;
    expect(stored.status, 'Post Test');
    expect(stored.prePending, PendingAction.none);
    expect(stored.preTest.total, 12);
  });

  test('a business-rule 422 on an existing application drops the stale pending flag', () async {
    final record = localDraft('uuid-5')..serverId = 105;
    await db.upsert(record);
    api.serverApplications = [serverApplication(id: 105, uuid: 'uuid-5', status: 'Post Test')];
    api.onPreTest = (id, body) => throw const ApiException('Values cannot be changed after pre test application submitted.', statusCode: 422);

    final (accepted, rejected) = await sync.push();

    expect(accepted, 0);
    expect(rejected, 1);
    final stored = (await db.application('uuid-5'))!;
    expect(stored.prePending, PendingAction.none);
    expect(stored.status, 'Post Test');
    expect(stored.syncError, contains('cannot be changed'));
  });

  test('network errors abort the push and keep everything pending', () async {
    await db.upsert(localDraft('uuid-6'));
    api.offline = true;
    expect(() => sync.push(), throwsA(isA<ApiException>().having((e) => e.isNetwork, 'isNetwork', true)));
    expect((await db.application('uuid-6'))!.prePending, PendingAction.submit);
  });

  test('pull writes new server records and keeps local pending stages', () async {
    final local = localDraft('uuid-7', pre: PendingAction.none)
      ..serverId = 107
      ..status = 'Post Test'
      ..postTest = TestData(fields: {'comment': 'local post draft'})
      ..postPending = PendingAction.save;
    await db.upsert(local);
    api.serverApplications = [
      serverApplication(id: 107, uuid: 'uuid-7', status: 'Post Test', postTest: {'type': 'post_test', 'comment': 'server'}),
      serverApplication(id: 108, uuid: 'uuid-8', status: 'Done'),
    ];

    final written = await sync.pull();

    expect(written, 2);
    final kept = (await db.application('uuid-7'))!;
    expect(kept.postPending, PendingAction.save);
    expect(kept.postTest['comment'], 'local post draft');
    expect(kept.preTest['form'], 'Form 6-11', reason: 'non-pending stage comes from the server');
    expect(kept.code, '2026-AKK-C1-107');
    final fresh = (await db.application('uuid-8'))!;
    expect(fresh.status, 'Done');
    expect(fresh.hasPendingChanges, isFalse);
    expect(await sync.lastSync(), isNotNull);
  });

  test('reference data is cached and refreshed only when the ETag changes', () async {
    api.etag = 'v1';
    expect(await sync.cachedReference(), isNull);
    final first = await sync.refreshReference();
    expect(first, isNotNull);
    expect((await sync.cachedReference())!.governorates.single.name, 'Akkar');

    final second = await sync.refreshReference();
    expect(second, isNull, reason: '304 Not Modified');

    api.etag = 'v2';
    expect(await sync.refreshReference(), isNotNull);
    expect(await db.meta(SyncService.metaReferenceEtag), 'v2');
  });

  test('run reports pushed, pulled and rejected counts', () async {
    await db.upsert(localDraft('uuid-9'));
    api.onSync = (items) => [
      SyncItemResult(
        clientUuid: 'uuid-9',
        result: 'created',
        id: 109,
        code: 'C',
        status: 'Post Test',
        stages: {
          'pre_test': {'result': 'updated'},
        },
      ),
    ];
    api.serverApplications = [serverApplication(id: 109, uuid: 'uuid-9')];
    final report = await sync.run(fullPull: true);
    expect(report.pushed, 1);
    expect(report.rejected, 0);
    expect(report.pulled, 1);
    expect(report.referenceUpdated, isTrue);
  });
}
