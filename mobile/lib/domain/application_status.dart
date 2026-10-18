/// Workflow states as named by the server, grouped for the dashboard tabs.
class ApplicationStatus {
  const ApplicationStatus._();

  static const preTest = 'Pre Test';
  static const preTestPending = 'Pre Test Pending';
  static const preTestCompleted = 'Pre Test Completed';
  static const postTest = 'Post Test';
  static const postTestPending = 'Post Test Pending';
  static const postTestCompleted = 'Post Test Completed';
  static const done = 'Done';
  static const dropout = 'Dropout';
  static const preTestNoPermission = 'Pre Test No Permission';
  static const postTestNoPermission = 'Post Test No Permission';
  static const notApplicable = 'NA';

  static const preTestStage = {preTest, preTestPending};
  static const postTestStage = {postTest, postTestPending, preTestCompleted};
  static const doneStage = {done};
  static const closedStage = {dropout, preTestNoPermission, postTestNoPermission, notApplicable, postTestCompleted};

  static bool allowsPreTestEdit(String status) => preTestStage.contains(status);

  static bool allowsPostTestEdit(String status) => postTestStage.contains(status);

  static DashboardTab tabOf(String status) {
    if (preTestStage.contains(status)) return DashboardTab.preTest;
    if (postTestStage.contains(status)) return DashboardTab.postTest;
    if (doneStage.contains(status)) return DashboardTab.done;
    return DashboardTab.closed;
  }
}

enum DashboardTab { preTest, postTest, done, closed }
