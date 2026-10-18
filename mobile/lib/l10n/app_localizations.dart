import 'dart:async';

import 'package:flutter/foundation.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:intl/intl.dart' as intl;

import 'app_localizations_ar.dart';
import 'app_localizations_en.dart';

// ignore_for_file: type=lint

/// Callers can lookup localized strings with an instance of AppLocalizations
/// returned by `AppLocalizations.of(context)`.
///
/// Applications need to include `AppLocalizations.delegate()` in their app's
/// `localizationDelegates` list, and the locales they support in the app's
/// `supportedLocales` list. For example:
///
/// ```dart
/// import 'l10n/app_localizations.dart';
///
/// return MaterialApp(
///   localizationsDelegates: AppLocalizations.localizationsDelegates,
///   supportedLocales: AppLocalizations.supportedLocales,
///   home: MyApplicationHome(),
/// );
/// ```
///
/// ## Update pubspec.yaml
///
/// Please make sure to update your pubspec.yaml to include the following
/// packages:
///
/// ```yaml
/// dependencies:
///   # Internationalization support.
///   flutter_localizations:
///     sdk: flutter
///   intl: any # Use the pinned version from flutter_localizations
///
///   # Rest of dependencies
/// ```
///
/// ## iOS Applications
///
/// iOS applications define key application metadata, including supported
/// locales, in an Info.plist file that is built into the application bundle.
/// To configure the locales supported by your app, you’ll need to edit this
/// file.
///
/// First, open your project’s ios/Runner.xcworkspace Xcode workspace file.
/// Then, in the Project Navigator, open the Info.plist file under the Runner
/// project’s Runner folder.
///
/// Next, select the Information Property List item, select Add Item from the
/// Editor menu, then select Localizations from the pop-up menu.
///
/// Select and expand the newly-created Localizations item then, for each
/// locale your application supports, add a new item and select the locale
/// you wish to add from the pop-up menu in the Value field. This list should
/// be consistent with the languages listed in the AppLocalizations.supportedLocales
/// property.
abstract class AppLocalizations {
  AppLocalizations(String locale) : localeName = intl.Intl.canonicalizedLocale(locale.toString());

  final String localeName;

  static AppLocalizations of(BuildContext context) {
    return Localizations.of<AppLocalizations>(context, AppLocalizations)!;
  }

  static const LocalizationsDelegate<AppLocalizations> delegate = _AppLocalizationsDelegate();

  /// A list of this localizations delegate along with the default localizations
  /// delegates.
  ///
  /// Returns a list of localizations delegates containing this delegate along with
  /// GlobalMaterialLocalizations.delegate, GlobalCupertinoLocalizations.delegate,
  /// and GlobalWidgetsLocalizations.delegate.
  ///
  /// Additional delegates can be added by appending to this list in
  /// MaterialApp. This list does not have to be used at all if a custom list
  /// of delegates is preferred or required.
  static const List<LocalizationsDelegate<dynamic>> localizationsDelegates = <LocalizationsDelegate<dynamic>>[
    delegate,
    GlobalMaterialLocalizations.delegate,
    GlobalCupertinoLocalizations.delegate,
    GlobalWidgetsLocalizations.delegate,
  ];

  /// A list of this localizations delegate's supported locales.
  static const List<Locale> supportedLocales = <Locale>[Locale('ar'), Locale('en')];

  /// No description provided for @appName.
  ///
  /// In en, this message translates to:
  /// **'Measuring Well-Being'**
  String get appName;

  /// No description provided for @signIn.
  ///
  /// In en, this message translates to:
  /// **'Sign in'**
  String get signIn;

  /// No description provided for @signInSubtitle.
  ///
  /// In en, this message translates to:
  /// **'Collector sign in with email'**
  String get signInSubtitle;

  /// No description provided for @email.
  ///
  /// In en, this message translates to:
  /// **'Email'**
  String get email;

  /// No description provided for @password.
  ///
  /// In en, this message translates to:
  /// **'Password'**
  String get password;

  /// No description provided for @serverUrl.
  ///
  /// In en, this message translates to:
  /// **'Server address'**
  String get serverUrl;

  /// No description provided for @serverUrlHelp.
  ///
  /// In en, this message translates to:
  /// **'Only change this if UNICEF gave you a different address.'**
  String get serverUrlHelp;

  /// No description provided for @signingIn.
  ///
  /// In en, this message translates to:
  /// **'Signing in…'**
  String get signingIn;

  /// No description provided for @invalidCredentials.
  ///
  /// In en, this message translates to:
  /// **'Email or password is incorrect.'**
  String get invalidCredentials;

  /// No description provided for @accountInactive.
  ///
  /// In en, this message translates to:
  /// **'This account is inactive. Contact your partner focal point.'**
  String get accountInactive;

  /// No description provided for @networkError.
  ///
  /// In en, this message translates to:
  /// **'Cannot reach the server. Check the connection and try again.'**
  String get networkError;

  /// No description provided for @unexpectedError.
  ///
  /// In en, this message translates to:
  /// **'Something went wrong: {message}'**
  String unexpectedError(String message);

  /// No description provided for @signOut.
  ///
  /// In en, this message translates to:
  /// **'Sign out'**
  String get signOut;

  /// No description provided for @signOutConfirm.
  ///
  /// In en, this message translates to:
  /// **'Unsynced applications on this device will be kept and sent at the next sign in. Sign out?'**
  String get signOutConfirm;

  /// No description provided for @cancel.
  ///
  /// In en, this message translates to:
  /// **'Cancel'**
  String get cancel;

  /// No description provided for @ok.
  ///
  /// In en, this message translates to:
  /// **'OK'**
  String get ok;

  /// No description provided for @retry.
  ///
  /// In en, this message translates to:
  /// **'Retry'**
  String get retry;

  /// No description provided for @save.
  ///
  /// In en, this message translates to:
  /// **'Save'**
  String get save;

  /// No description provided for @saveDraft.
  ///
  /// In en, this message translates to:
  /// **'Save draft'**
  String get saveDraft;

  /// No description provided for @submit.
  ///
  /// In en, this message translates to:
  /// **'Submit'**
  String get submit;

  /// No description provided for @back.
  ///
  /// In en, this message translates to:
  /// **'Back'**
  String get back;

  /// No description provided for @close.
  ///
  /// In en, this message translates to:
  /// **'Close'**
  String get close;

  /// No description provided for @search.
  ///
  /// In en, this message translates to:
  /// **'Search by code'**
  String get search;

  /// No description provided for @allYears.
  ///
  /// In en, this message translates to:
  /// **'All years'**
  String get allYears;

  /// No description provided for @year.
  ///
  /// In en, this message translates to:
  /// **'Year'**
  String get year;

  /// No description provided for @tabPreTest.
  ///
  /// In en, this message translates to:
  /// **'Pre-test'**
  String get tabPreTest;

  /// No description provided for @tabPostTest.
  ///
  /// In en, this message translates to:
  /// **'Post-test'**
  String get tabPostTest;

  /// No description provided for @tabDone.
  ///
  /// In en, this message translates to:
  /// **'Done'**
  String get tabDone;

  /// No description provided for @tabClosed.
  ///
  /// In en, this message translates to:
  /// **'Closed'**
  String get tabClosed;

  /// No description provided for @noApplications.
  ///
  /// In en, this message translates to:
  /// **'No applications in this list.'**
  String get noApplications;

  /// No description provided for @newApplication.
  ///
  /// In en, this message translates to:
  /// **'New application'**
  String get newApplication;

  /// No description provided for @newApplicationHelp.
  ///
  /// In en, this message translates to:
  /// **'A code will be assigned by the server when the device is online. Until then the application is marked as pending.'**
  String get newApplicationHelp;

  /// No description provided for @pendingSync.
  ///
  /// In en, this message translates to:
  /// **'Pending sync'**
  String get pendingSync;

  /// No description provided for @syncNow.
  ///
  /// In en, this message translates to:
  /// **'Sync now'**
  String get syncNow;

  /// No description provided for @syncing.
  ///
  /// In en, this message translates to:
  /// **'Syncing…'**
  String get syncing;

  /// No description provided for @syncDone.
  ///
  /// In en, this message translates to:
  /// **'Sync complete: {pushed} sent, {pulled} updated'**
  String syncDone(int pushed, int pulled);

  /// No description provided for @syncFailed.
  ///
  /// In en, this message translates to:
  /// **'Sync failed: {message}'**
  String syncFailed(String message);

  /// No description provided for @syncErrorsTitle.
  ///
  /// In en, this message translates to:
  /// **'Some applications were not accepted'**
  String get syncErrorsTitle;

  /// No description provided for @offline.
  ///
  /// In en, this message translates to:
  /// **'Offline'**
  String get offline;

  /// No description provided for @online.
  ///
  /// In en, this message translates to:
  /// **'Online'**
  String get online;

  /// No description provided for @lastSync.
  ///
  /// In en, this message translates to:
  /// **'Last sync: {when}'**
  String lastSync(String when);

  /// No description provided for @never.
  ///
  /// In en, this message translates to:
  /// **'never'**
  String get never;

  /// No description provided for @readOnlyAccount.
  ///
  /// In en, this message translates to:
  /// **'This account is read-only. You can view applications but not create or edit them.'**
  String get readOnlyAccount;

  /// No description provided for @application.
  ///
  /// In en, this message translates to:
  /// **'Application'**
  String get application;

  /// No description provided for @code.
  ///
  /// In en, this message translates to:
  /// **'Code'**
  String get code;

  /// No description provided for @status.
  ///
  /// In en, this message translates to:
  /// **'Status'**
  String get status;

  /// No description provided for @preTest.
  ///
  /// In en, this message translates to:
  /// **'Pre-test'**
  String get preTest;

  /// No description provided for @postTest.
  ///
  /// In en, this message translates to:
  /// **'Post-test'**
  String get postTest;

  /// No description provided for @preTestDate.
  ///
  /// In en, this message translates to:
  /// **'Pre-test date'**
  String get preTestDate;

  /// No description provided for @postTestDate.
  ///
  /// In en, this message translates to:
  /// **'Post-test date'**
  String get postTestDate;

  /// No description provided for @startPreTest.
  ///
  /// In en, this message translates to:
  /// **'Start pre-test'**
  String get startPreTest;

  /// No description provided for @continuePreTest.
  ///
  /// In en, this message translates to:
  /// **'Continue pre-test'**
  String get continuePreTest;

  /// No description provided for @startPostTest.
  ///
  /// In en, this message translates to:
  /// **'Start post-test'**
  String get startPostTest;

  /// No description provided for @continuePostTest.
  ///
  /// In en, this message translates to:
  /// **'Continue post-test'**
  String get continuePostTest;

  /// No description provided for @viewAnswers.
  ///
  /// In en, this message translates to:
  /// **'View answers'**
  String get viewAnswers;

  /// No description provided for @scores.
  ///
  /// In en, this message translates to:
  /// **'Scores'**
  String get scores;

  /// No description provided for @scaleEmotional.
  ///
  /// In en, this message translates to:
  /// **'Emotional symptoms'**
  String get scaleEmotional;

  /// No description provided for @scaleConduct.
  ///
  /// In en, this message translates to:
  /// **'Conduct problems'**
  String get scaleConduct;

  /// No description provided for @scaleHyperactivity.
  ///
  /// In en, this message translates to:
  /// **'Hyperactivity / inattention'**
  String get scaleHyperactivity;

  /// No description provided for @scalePeer.
  ///
  /// In en, this message translates to:
  /// **'Peer relationship problems'**
  String get scalePeer;

  /// No description provided for @scaleProsocial.
  ///
  /// In en, this message translates to:
  /// **'Prosocial behaviour'**
  String get scaleProsocial;

  /// No description provided for @scaleTotal.
  ///
  /// In en, this message translates to:
  /// **'Total difficulties'**
  String get scaleTotal;

  /// No description provided for @naCount.
  ///
  /// In en, this message translates to:
  /// **'NA answers'**
  String get naCount;

  /// No description provided for @change.
  ///
  /// In en, this message translates to:
  /// **'Change'**
  String get change;

  /// No description provided for @changeIncrease.
  ///
  /// In en, this message translates to:
  /// **'Improved'**
  String get changeIncrease;

  /// No description provided for @changeDecrease.
  ///
  /// In en, this message translates to:
  /// **'Worsened'**
  String get changeDecrease;

  /// No description provided for @changeSame.
  ///
  /// In en, this message translates to:
  /// **'Unchanged'**
  String get changeSame;

  /// No description provided for @notSynced.
  ///
  /// In en, this message translates to:
  /// **'Not yet sent to the server'**
  String get notSynced;

  /// No description provided for @serverError.
  ///
  /// In en, this message translates to:
  /// **'Server said: {message}'**
  String serverError(String message);

  /// No description provided for @deleteDraft.
  ///
  /// In en, this message translates to:
  /// **'Delete draft'**
  String get deleteDraft;

  /// No description provided for @deleteDraftConfirm.
  ///
  /// In en, this message translates to:
  /// **'Delete this application from the device? Only applications never sent to the server can be deleted.'**
  String get deleteDraftConfirm;

  /// No description provided for @sectionConsent.
  ///
  /// In en, this message translates to:
  /// **'Consent'**
  String get sectionConsent;

  /// No description provided for @consentScriptTitle.
  ///
  /// In en, this message translates to:
  /// **'Read to the caregiver or adolescent'**
  String get consentScriptTitle;

  /// No description provided for @consentQuestion.
  ///
  /// In en, this message translates to:
  /// **'May I start now?'**
  String get consentQuestion;

  /// No description provided for @consentRefusedHelp.
  ///
  /// In en, this message translates to:
  /// **'If consent is refused the application is closed as \"no permission\".'**
  String get consentRefusedHelp;

  /// No description provided for @sectionInterview.
  ///
  /// In en, this message translates to:
  /// **'Interview details'**
  String get sectionInterview;

  /// No description provided for @sectionChild.
  ///
  /// In en, this message translates to:
  /// **'Child'**
  String get sectionChild;

  /// No description provided for @sectionLocation.
  ///
  /// In en, this message translates to:
  /// **'Location'**
  String get sectionLocation;

  /// No description provided for @sectionQuestionnaire.
  ///
  /// In en, this message translates to:
  /// **'Questionnaire'**
  String get sectionQuestionnaire;

  /// No description provided for @sectionProgramme.
  ///
  /// In en, this message translates to:
  /// **'Programme attendance'**
  String get sectionProgramme;

  /// No description provided for @sectionOther.
  ///
  /// In en, this message translates to:
  /// **'Other'**
  String get sectionOther;

  /// No description provided for @form.
  ///
  /// In en, this message translates to:
  /// **'Form'**
  String get form;

  /// No description provided for @formHelp.
  ///
  /// In en, this message translates to:
  /// **'Form 6-11 is answered by the caregiver, Form 12-17 by the adolescent.'**
  String get formHelp;

  /// No description provided for @reportingYear.
  ///
  /// In en, this message translates to:
  /// **'Reporting year'**
  String get reportingYear;

  /// No description provided for @category.
  ///
  /// In en, this message translates to:
  /// **'Activity category'**
  String get category;

  /// No description provided for @agency.
  ///
  /// In en, this message translates to:
  /// **'Agency'**
  String get agency;

  /// No description provided for @donor.
  ///
  /// In en, this message translates to:
  /// **'Donor'**
  String get donor;

  /// No description provided for @interviewDate.
  ///
  /// In en, this message translates to:
  /// **'Interview date'**
  String get interviewDate;

  /// No description provided for @interviewer.
  ///
  /// In en, this message translates to:
  /// **'Interviewer\'s name'**
  String get interviewer;

  /// No description provided for @childCode.
  ///
  /// In en, this message translates to:
  /// **'Child\'s code'**
  String get childCode;

  /// No description provided for @age.
  ///
  /// In en, this message translates to:
  /// **'Child\'s age'**
  String get age;

  /// No description provided for @ageRange.
  ///
  /// In en, this message translates to:
  /// **'Age must be between {min} and {max} for this form.'**
  String ageRange(int min, int max);

  /// No description provided for @gender.
  ///
  /// In en, this message translates to:
  /// **'Child\'s gender'**
  String get gender;

  /// No description provided for @nationality.
  ///
  /// In en, this message translates to:
  /// **'Child\'s nationality'**
  String get nationality;

  /// No description provided for @otherNationality.
  ///
  /// In en, this message translates to:
  /// **'Other nationality'**
  String get otherNationality;

  /// No description provided for @governorate.
  ///
  /// In en, this message translates to:
  /// **'Governorate'**
  String get governorate;

  /// No description provided for @caza.
  ///
  /// In en, this message translates to:
  /// **'Caza'**
  String get caza;

  /// No description provided for @area.
  ///
  /// In en, this message translates to:
  /// **'Area'**
  String get area;

  /// No description provided for @gatewayType.
  ///
  /// In en, this message translates to:
  /// **'Gateway type'**
  String get gatewayType;

  /// No description provided for @pCode.
  ///
  /// In en, this message translates to:
  /// **'P-code (if available)'**
  String get pCode;

  /// No description provided for @gps.
  ///
  /// In en, this message translates to:
  /// **'GPS position'**
  String get gps;

  /// No description provided for @captureGps.
  ///
  /// In en, this message translates to:
  /// **'Capture position'**
  String get captureGps;

  /// No description provided for @gpsCaptured.
  ///
  /// In en, this message translates to:
  /// **'Position captured ({accuracy} m)'**
  String gpsCaptured(String accuracy);

  /// No description provided for @gpsFailed.
  ///
  /// In en, this message translates to:
  /// **'Could not get a position: {message}'**
  String gpsFailed(String message);

  /// No description provided for @latitude.
  ///
  /// In en, this message translates to:
  /// **'Latitude'**
  String get latitude;

  /// No description provided for @longitude.
  ///
  /// In en, this message translates to:
  /// **'Longitude'**
  String get longitude;

  /// No description provided for @answered.
  ///
  /// In en, this message translates to:
  /// **'{answered} of {total} answered'**
  String answered(int answered, int total);

  /// No description provided for @naWarning.
  ///
  /// In en, this message translates to:
  /// **'More than {max} NA answers will mark this application as not applicable.'**
  String naWarning(int max);

  /// No description provided for @hoursAttended.
  ///
  /// In en, this message translates to:
  /// **'Hours the child attended'**
  String get hoursAttended;

  /// No description provided for @hoursTotal.
  ///
  /// In en, this message translates to:
  /// **'Total hours in the programme'**
  String get hoursTotal;

  /// No description provided for @dropoutReason.
  ///
  /// In en, this message translates to:
  /// **'Dropout reason'**
  String get dropoutReason;

  /// No description provided for @dropoutJustification.
  ///
  /// In en, this message translates to:
  /// **'Justify the dropout reason'**
  String get dropoutJustification;

  /// No description provided for @services.
  ///
  /// In en, this message translates to:
  /// **'Other child protection services received'**
  String get services;

  /// No description provided for @comment.
  ///
  /// In en, this message translates to:
  /// **'Comments'**
  String get comment;

  /// No description provided for @required.
  ///
  /// In en, this message translates to:
  /// **'Required'**
  String get required;

  /// No description provided for @invalidNumber.
  ///
  /// In en, this message translates to:
  /// **'Enter a number'**
  String get invalidNumber;

  /// No description provided for @fixErrors.
  ///
  /// In en, this message translates to:
  /// **'Please fix the highlighted fields.'**
  String get fixErrors;

  /// No description provided for @savedLocally.
  ///
  /// In en, this message translates to:
  /// **'Saved on this device.'**
  String get savedLocally;

  /// No description provided for @submittedLocally.
  ///
  /// In en, this message translates to:
  /// **'Submitted. It will be sent to the server at the next sync.'**
  String get submittedLocally;

  /// No description provided for @submitConfirmTitle.
  ///
  /// In en, this message translates to:
  /// **'Submit {test}?'**
  String submitConfirmTitle(String test);

  /// No description provided for @submitConfirmBody.
  ///
  /// In en, this message translates to:
  /// **'Answers cannot be changed after submission.'**
  String get submitConfirmBody;

  /// No description provided for @settings.
  ///
  /// In en, this message translates to:
  /// **'Settings'**
  String get settings;

  /// No description provided for @language.
  ///
  /// In en, this message translates to:
  /// **'Language'**
  String get language;

  /// No description provided for @english.
  ///
  /// In en, this message translates to:
  /// **'English'**
  String get english;

  /// No description provided for @arabic.
  ///
  /// In en, this message translates to:
  /// **'العربية'**
  String get arabic;

  /// No description provided for @version.
  ///
  /// In en, this message translates to:
  /// **'Version {version}'**
  String version(String version);

  /// No description provided for @signedInAs.
  ///
  /// In en, this message translates to:
  /// **'Signed in as {name} ({partner})'**
  String signedInAs(String name, String partner);

  /// No description provided for @referenceUpdated.
  ///
  /// In en, this message translates to:
  /// **'Reference data updated'**
  String get referenceUpdated;

  /// No description provided for @selectOne.
  ///
  /// In en, this message translates to:
  /// **'Select…'**
  String get selectOne;
}

class _AppLocalizationsDelegate extends LocalizationsDelegate<AppLocalizations> {
  const _AppLocalizationsDelegate();

  @override
  Future<AppLocalizations> load(Locale locale) {
    return SynchronousFuture<AppLocalizations>(lookupAppLocalizations(locale));
  }

  @override
  bool isSupported(Locale locale) => <String>['ar', 'en'].contains(locale.languageCode);

  @override
  bool shouldReload(_AppLocalizationsDelegate old) => false;
}

AppLocalizations lookupAppLocalizations(Locale locale) {
  // Lookup logic when only language code is specified.
  switch (locale.languageCode) {
    case 'ar':
      return AppLocalizationsAr();
    case 'en':
      return AppLocalizationsEn();
  }

  throw FlutterError(
    'AppLocalizations.delegate failed to load unsupported locale "$locale". This is likely '
    'an issue with the localizations generation tool. Please file an issue '
    'on GitHub with a reproducible sample app and the gen-l10n configuration '
    'that was used.',
  );
}
