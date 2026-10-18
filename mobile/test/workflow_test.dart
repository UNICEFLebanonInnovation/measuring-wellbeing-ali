import 'package:flutter_test/flutter_test.dart';
import 'package:measuring_wellbeing/data/models/application_record.dart';
import 'package:measuring_wellbeing/domain/application_status.dart';
import 'package:measuring_wellbeing/domain/sdq_catalog.dart';
import 'package:measuring_wellbeing/domain/workflow.dart';

void main() {
  TestData answered({int na = 0, String? dropout}) {
    final data = TestData(fields: {'may_i_start_now': 'yes', 'dropout_reason': ?dropout});
    var i = 0;
    for (final item in sdqItems) {
      data.fields[item.key] = i++ < na ? 'na' : '1';
    }
    return data;
  }

  test('pre-test transitions mirror the server', () {
    expect(statusAfter(isPostTest: false, submit: false, data: answered()), ApplicationStatus.preTestPending);
    expect(statusAfter(isPostTest: false, submit: true, data: answered()), ApplicationStatus.postTest);
    expect(statusAfter(isPostTest: false, submit: true, data: answered(na: 4)), ApplicationStatus.notApplicable);
    expect(statusAfter(isPostTest: false, submit: true, data: TestData(fields: {'may_i_start_now': 'no'})), ApplicationStatus.preTestNoPermission);
  });

  test('post-test transitions mirror the server', () {
    expect(statusAfter(isPostTest: true, submit: false, data: answered()), ApplicationStatus.postTestPending);
    expect(statusAfter(isPostTest: true, submit: true, data: answered(dropout: didNotDropOut)), ApplicationStatus.done);
    expect(statusAfter(isPostTest: true, submit: true, data: answered(dropout: 'Returned to Syria')), ApplicationStatus.dropout);
    expect(statusAfter(isPostTest: true, submit: true, data: TestData(fields: {'may_i_start_now': 'no'})), ApplicationStatus.postTestNoPermission);
  });

  test('post-test inherits the child details from the pre-test', () {
    final pre = TestData(fields: {'form': 'Form 12-17', 'age': '14', 'gouvarnate': '1', 'comment': 'pre comment', 'often_loses_temper': '2'});
    final post = startPostTestFrom(pre);
    expect(post['form'], 'Form 12-17');
    expect(post['age'], '14');
    expect(post['comment'], isNull);
    expect(post['often_loses_temper'], isNull);
    expect(post['dropout_reason'], didNotDropOut);
  });

  test('statuses map to dashboard tabs', () {
    expect(ApplicationStatus.tabOf('Pre Test Pending'), DashboardTab.preTest);
    expect(ApplicationStatus.tabOf('Post Test'), DashboardTab.postTest);
    expect(ApplicationStatus.tabOf('Done'), DashboardTab.done);
    expect(ApplicationStatus.tabOf('Dropout'), DashboardTab.closed);
    expect(ApplicationStatus.tabOf('NA'), DashboardTab.closed);
  });
}
