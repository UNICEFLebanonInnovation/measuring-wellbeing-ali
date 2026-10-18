import '../core/config.dart';
import '../data/models/application_record.dart';
import 'application_status.dart';
import 'sdq_catalog.dart';

/// Local mirror of the server's status transitions (`App\Sdq\ApplicationService`)
/// so the dashboard shows the right tab before the next sync. The server's
/// answer always wins once the record is synced.
String statusAfter({required bool isPostTest, required bool submit, required TestData data, int maxNa = AppConfig.maxNaAnswers}) {
  if (!data.consentGiven) {
    return isPostTest ? ApplicationStatus.postTestNoPermission : ApplicationStatus.preTestNoPermission;
  }
  if (!submit) {
    return isPostTest ? ApplicationStatus.postTestPending : ApplicationStatus.preTestPending;
  }
  if (data.naCount > maxNa) return ApplicationStatus.notApplicable;
  if (!isPostTest) return ApplicationStatus.postTest;
  final reason = data['dropout_reason'] ?? didNotDropOut;
  return reason != didNotDropOut ? ApplicationStatus.dropout : ApplicationStatus.done;
}

/// Fields the post-test inherits from the pre-test when it is started.
const List<String> inheritedFields = [
  'form',
  'category',
  'agency_name',
  'donor_name',
  'interviewers_name',
  'child_code',
  'age',
  'gender',
  'nationality',
  'other_nationality',
  'gouvarnate',
  'caza',
  'area',
  'gateway_type',
  'p_code',
];

/// Returns a post-test prefilled from the pre-test for the fields that describe the child.
TestData startPostTestFrom(TestData preTest) {
  final data = TestData();
  for (final key in inheritedFields) {
    final v = preTest.fields[key];
    if (v != null && v.toString().isNotEmpty) data.fields[key] = v;
  }
  data.fields['dropout_reason'] = didNotDropOut;
  return data;
}
