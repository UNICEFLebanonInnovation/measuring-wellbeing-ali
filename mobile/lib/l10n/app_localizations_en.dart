// ignore: unused_import
import 'package:intl/intl.dart' as intl;

import 'app_localizations.dart';

// ignore_for_file: type=lint

/// The translations for English (`en`).
class AppLocalizationsEn extends AppLocalizations {
  AppLocalizationsEn([String locale = 'en']) : super(locale);

  @override
  String get appName => 'Measuring Well-Being';

  @override
  String get signIn => 'Sign in';

  @override
  String get signInSubtitle => 'Collector sign in with email';

  @override
  String get email => 'Email';

  @override
  String get password => 'Password';

  @override
  String get serverUrl => 'Server address';

  @override
  String get serverUrlHelp => 'Only change this if UNICEF gave you a different address.';

  @override
  String get signingIn => 'Signing in…';

  @override
  String get invalidCredentials => 'Email or password is incorrect.';

  @override
  String get accountInactive => 'This account is inactive. Contact your partner focal point.';

  @override
  String get networkError => 'Cannot reach the server. Check the connection and try again.';

  @override
  String unexpectedError(String message) {
    return 'Something went wrong: $message';
  }

  @override
  String get signOut => 'Sign out';

  @override
  String get signOutConfirm => 'Unsynced applications on this device will be kept and sent at the next sign in. Sign out?';

  @override
  String get cancel => 'Cancel';

  @override
  String get ok => 'OK';

  @override
  String get retry => 'Retry';

  @override
  String get save => 'Save';

  @override
  String get saveDraft => 'Save draft';

  @override
  String get submit => 'Submit';

  @override
  String get back => 'Back';

  @override
  String get close => 'Close';

  @override
  String get search => 'Search by code';

  @override
  String get allYears => 'All years';

  @override
  String get year => 'Year';

  @override
  String get tabPreTest => 'Pre-test';

  @override
  String get tabPostTest => 'Post-test';

  @override
  String get tabDone => 'Done';

  @override
  String get tabClosed => 'Closed';

  @override
  String get noApplications => 'No applications in this list.';

  @override
  String get newApplication => 'New application';

  @override
  String get newApplicationHelp => 'A code will be assigned by the server when the device is online. Until then the application is marked as pending.';

  @override
  String get pendingSync => 'Pending sync';

  @override
  String get syncNow => 'Sync now';

  @override
  String get syncing => 'Syncing…';

  @override
  String syncDone(int pushed, int pulled) {
    return 'Sync complete: $pushed sent, $pulled updated';
  }

  @override
  String syncFailed(String message) {
    return 'Sync failed: $message';
  }

  @override
  String get syncErrorsTitle => 'Some applications were not accepted';

  @override
  String get offline => 'Offline';

  @override
  String get online => 'Online';

  @override
  String lastSync(String when) {
    return 'Last sync: $when';
  }

  @override
  String get never => 'never';

  @override
  String get readOnlyAccount => 'This account is read-only. You can view applications but not create or edit them.';

  @override
  String get application => 'Application';

  @override
  String get code => 'Code';

  @override
  String get status => 'Status';

  @override
  String get preTest => 'Pre-test';

  @override
  String get postTest => 'Post-test';

  @override
  String get preTestDate => 'Pre-test date';

  @override
  String get postTestDate => 'Post-test date';

  @override
  String get startPreTest => 'Start pre-test';

  @override
  String get continuePreTest => 'Continue pre-test';

  @override
  String get startPostTest => 'Start post-test';

  @override
  String get continuePostTest => 'Continue post-test';

  @override
  String get viewAnswers => 'View answers';

  @override
  String get scores => 'Scores';

  @override
  String get scaleEmotional => 'Emotional symptoms';

  @override
  String get scaleConduct => 'Conduct problems';

  @override
  String get scaleHyperactivity => 'Hyperactivity / inattention';

  @override
  String get scalePeer => 'Peer relationship problems';

  @override
  String get scaleProsocial => 'Prosocial behaviour';

  @override
  String get scaleTotal => 'Total difficulties';

  @override
  String get naCount => 'NA answers';

  @override
  String get change => 'Change';

  @override
  String get changeIncrease => 'Improved';

  @override
  String get changeDecrease => 'Worsened';

  @override
  String get changeSame => 'Unchanged';

  @override
  String get notSynced => 'Not yet sent to the server';

  @override
  String serverError(String message) {
    return 'Server said: $message';
  }

  @override
  String get deleteDraft => 'Delete draft';

  @override
  String get deleteDraftConfirm => 'Delete this application from the device? Only applications never sent to the server can be deleted.';

  @override
  String get sectionConsent => 'Consent';

  @override
  String get consentScriptTitle => 'Read to the caregiver or adolescent';

  @override
  String get consentQuestion => 'May I start now?';

  @override
  String get consentRefusedHelp => 'If consent is refused the application is closed as \"no permission\".';

  @override
  String get sectionInterview => 'Interview details';

  @override
  String get sectionChild => 'Child';

  @override
  String get sectionLocation => 'Location';

  @override
  String get sectionQuestionnaire => 'Questionnaire';

  @override
  String get sectionProgramme => 'Programme attendance';

  @override
  String get sectionOther => 'Other';

  @override
  String get form => 'Form';

  @override
  String get formHelp => 'Form 6-11 is answered by the caregiver, Form 12-17 by the adolescent.';

  @override
  String get reportingYear => 'Reporting year';

  @override
  String get category => 'Activity category';

  @override
  String get agency => 'Agency';

  @override
  String get donor => 'Donor';

  @override
  String get interviewDate => 'Interview date';

  @override
  String get interviewer => 'Interviewer\'s name';

  @override
  String get childCode => 'Child\'s code';

  @override
  String get age => 'Child\'s age';

  @override
  String ageRange(int min, int max) {
    return 'Age must be between $min and $max for this form.';
  }

  @override
  String get gender => 'Child\'s gender';

  @override
  String get nationality => 'Child\'s nationality';

  @override
  String get otherNationality => 'Other nationality';

  @override
  String get governorate => 'Governorate';

  @override
  String get caza => 'Caza';

  @override
  String get area => 'Area';

  @override
  String get gatewayType => 'Gateway type';

  @override
  String get pCode => 'P-code (if available)';

  @override
  String get gps => 'GPS position';

  @override
  String get captureGps => 'Capture position';

  @override
  String gpsCaptured(String accuracy) {
    return 'Position captured ($accuracy m)';
  }

  @override
  String gpsFailed(String message) {
    return 'Could not get a position: $message';
  }

  @override
  String get latitude => 'Latitude';

  @override
  String get longitude => 'Longitude';

  @override
  String answered(int answered, int total) {
    return '$answered of $total answered';
  }

  @override
  String naWarning(int max) {
    return 'More than $max NA answers will mark this application as not applicable.';
  }

  @override
  String get hoursAttended => 'Hours the child attended';

  @override
  String get hoursTotal => 'Total hours in the programme';

  @override
  String get dropoutReason => 'Dropout reason';

  @override
  String get dropoutJustification => 'Justify the dropout reason';

  @override
  String get services => 'Other child protection services received';

  @override
  String get comment => 'Comments';

  @override
  String get required => 'Required';

  @override
  String get invalidNumber => 'Enter a number';

  @override
  String get fixErrors => 'Please fix the highlighted fields.';

  @override
  String get savedLocally => 'Saved on this device.';

  @override
  String get submittedLocally => 'Submitted. It will be sent to the server at the next sync.';

  @override
  String submitConfirmTitle(String test) {
    return 'Submit $test?';
  }

  @override
  String get submitConfirmBody => 'Answers cannot be changed after submission.';

  @override
  String get settings => 'Settings';

  @override
  String get language => 'Language';

  @override
  String get english => 'English';

  @override
  String get arabic => 'العربية';

  @override
  String version(String version) {
    return 'Version $version';
  }

  @override
  String signedInAs(String name, String partner) {
    return 'Signed in as $name ($partner)';
  }

  @override
  String get referenceUpdated => 'Reference data updated';

  @override
  String get selectOne => 'Select…';
}
