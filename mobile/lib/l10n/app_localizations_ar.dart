// ignore: unused_import
import 'package:intl/intl.dart' as intl;

import 'app_localizations.dart';

// ignore_for_file: type=lint

/// The translations for Arabic (`ar`).
class AppLocalizationsAr extends AppLocalizations {
  AppLocalizationsAr([String locale = 'ar']) : super(locale);

  @override
  String get appName => 'قياس الرفاه';

  @override
  String get signIn => 'تسجيل الدخول';

  @override
  String get signInSubtitle => 'تسجيل دخول جامع البيانات بالبريد الإلكتروني';

  @override
  String get email => 'البريد الإلكتروني';

  @override
  String get password => 'كلمة المرور';

  @override
  String get serverUrl => 'عنوان الخادم';

  @override
  String get serverUrlHelp => 'لا تغيّر هذا العنوان إلا إذا زودتك اليونيسف بعنوان مختلف.';

  @override
  String get signingIn => 'جارٍ تسجيل الدخول…';

  @override
  String get invalidCredentials => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.';

  @override
  String get accountInactive => 'هذا الحساب غير مفعّل. تواصل مع مسؤول الشريك.';

  @override
  String get networkError => 'تعذر الوصول إلى الخادم. تحقق من الاتصال وحاول مجدداً.';

  @override
  String unexpectedError(String message) {
    return 'حدث خطأ: $message';
  }

  @override
  String get signOut => 'تسجيل الخروج';

  @override
  String get signOutConfirm => 'ستبقى الاستمارات غير المرسلة على هذا الجهاز وتُرسل عند تسجيل الدخول التالي. تسجيل الخروج؟';

  @override
  String get cancel => 'إلغاء';

  @override
  String get ok => 'موافق';

  @override
  String get retry => 'إعادة المحاولة';

  @override
  String get save => 'حفظ';

  @override
  String get saveDraft => 'حفظ كمسودة';

  @override
  String get submit => 'إرسال';

  @override
  String get back => 'رجوع';

  @override
  String get close => 'إغلاق';

  @override
  String get search => 'البحث بالرمز';

  @override
  String get allYears => 'كل السنوات';

  @override
  String get year => 'السنة';

  @override
  String get tabPreTest => 'الاختبار القبلي';

  @override
  String get tabPostTest => 'الاختبار البعدي';

  @override
  String get tabDone => 'مكتمل';

  @override
  String get tabClosed => 'مغلق';

  @override
  String get noApplications => 'لا توجد استمارات في هذه القائمة.';

  @override
  String get newApplication => 'استمارة جديدة';

  @override
  String get newApplicationHelp => 'سيُخصص الرمز من الخادم عند الاتصال بالإنترنت. حتى ذلك الحين تظهر الاستمارة كمعلّقة.';

  @override
  String get pendingSync => 'بانتظار المزامنة';

  @override
  String get syncNow => 'مزامنة الآن';

  @override
  String get syncing => 'جارٍ المزامنة…';

  @override
  String syncDone(int pushed, int pulled) {
    return 'اكتملت المزامنة: $pushed أُرسلت، $pulled حُدّثت';
  }

  @override
  String syncFailed(String message) {
    return 'فشلت المزامنة: $message';
  }

  @override
  String get syncErrorsTitle => 'لم تُقبل بعض الاستمارات';

  @override
  String get offline => 'غير متصل';

  @override
  String get online => 'متصل';

  @override
  String lastSync(String when) {
    return 'آخر مزامنة: $when';
  }

  @override
  String get never => 'لم تتم';

  @override
  String get readOnlyAccount => 'هذا الحساب للقراءة فقط. يمكنك عرض الاستمارات دون إنشائها أو تعديلها.';

  @override
  String get application => 'الاستمارة';

  @override
  String get code => 'الرمز';

  @override
  String get status => 'الحالة';

  @override
  String get preTest => 'الاختبار القبلي';

  @override
  String get postTest => 'الاختبار البعدي';

  @override
  String get preTestDate => 'تاريخ الاختبار القبلي';

  @override
  String get postTestDate => 'تاريخ الاختبار البعدي';

  @override
  String get startPreTest => 'بدء الاختبار القبلي';

  @override
  String get continuePreTest => 'متابعة الاختبار القبلي';

  @override
  String get startPostTest => 'بدء الاختبار البعدي';

  @override
  String get continuePostTest => 'متابعة الاختبار البعدي';

  @override
  String get viewAnswers => 'عرض الإجابات';

  @override
  String get scores => 'النتائج';

  @override
  String get scaleEmotional => 'الأعراض الانفعالية';

  @override
  String get scaleConduct => 'مشاكل السلوك';

  @override
  String get scaleHyperactivity => 'فرط النشاط / قلة الانتباه';

  @override
  String get scalePeer => 'مشاكل العلاقات مع الأقران';

  @override
  String get scaleProsocial => 'السلوك الاجتماعي الإيجابي';

  @override
  String get scaleTotal => 'مجموع الصعوبات';

  @override
  String get naCount => 'إجابات لا تنطبق';

  @override
  String get change => 'التغيير';

  @override
  String get changeIncrease => 'تحسّن';

  @override
  String get changeDecrease => 'تراجع';

  @override
  String get changeSame => 'بدون تغيير';

  @override
  String get notSynced => 'لم تُرسل إلى الخادم بعد';

  @override
  String serverError(String message) {
    return 'رد الخادم: $message';
  }

  @override
  String get deleteDraft => 'حذف المسودة';

  @override
  String get deleteDraftConfirm => 'حذف هذه الاستمارة من الجهاز؟ لا يمكن حذف إلا الاستمارات التي لم تُرسل إلى الخادم.';

  @override
  String get sectionConsent => 'الموافقة';

  @override
  String get consentScriptTitle => 'يُقرأ لمقدّم الرعاية أو المراهق';

  @override
  String get consentQuestion => 'هل يمكن البدء الآن؟';

  @override
  String get consentRefusedHelp => 'في حال رفض الموافقة تُغلق الاستمارة \"بدون إذن\".';

  @override
  String get sectionInterview => 'تفاصيل المقابلة';

  @override
  String get sectionChild => 'الطفل';

  @override
  String get sectionLocation => 'الموقع';

  @override
  String get sectionQuestionnaire => 'الاستبيان';

  @override
  String get sectionProgramme => 'الحضور في البرنامج';

  @override
  String get sectionOther => 'أخرى';

  @override
  String get form => 'الاستمارة';

  @override
  String get formHelp => 'استمارة 6-11 يجيب عنها مقدّم الرعاية، واستمارة 12-17 يجيب عنها المراهق.';

  @override
  String get reportingYear => 'سنة التقرير';

  @override
  String get category => 'فئة النشاط';

  @override
  String get agency => 'الجهة';

  @override
  String get donor => 'الجهة المانحة';

  @override
  String get interviewDate => 'تاريخ المقابلة';

  @override
  String get interviewer => 'اسم المُقابِل';

  @override
  String get childCode => 'رمز الطفل';

  @override
  String get age => 'عمر الطفل';

  @override
  String ageRange(int min, int max) {
    return 'يجب أن يكون العمر بين $min و$max لهذه الاستمارة.';
  }

  @override
  String get gender => 'جنس الطفل';

  @override
  String get nationality => 'جنسية الطفل';

  @override
  String get otherNationality => 'جنسية أخرى';

  @override
  String get governorate => 'المحافظة';

  @override
  String get caza => 'القضاء';

  @override
  String get area => 'المنطقة';

  @override
  String get gatewayType => 'نوع المدخل';

  @override
  String get pCode => 'الرمز الجغرافي (إن وُجد)';

  @override
  String get gps => 'الموقع الجغرافي';

  @override
  String get captureGps => 'التقاط الموقع';

  @override
  String gpsCaptured(String accuracy) {
    return 'تم التقاط الموقع (دقة $accuracy م)';
  }

  @override
  String gpsFailed(String message) {
    return 'تعذر تحديد الموقع: $message';
  }

  @override
  String get latitude => 'خط العرض';

  @override
  String get longitude => 'خط الطول';

  @override
  String answered(int answered, int total) {
    return 'تمت الإجابة عن $answered من $total';
  }

  @override
  String naWarning(int max) {
    return 'أكثر من $max إجابات \"لا ينطبق\" ستجعل الاستمارة غير قابلة للتطبيق.';
  }

  @override
  String get hoursAttended => 'عدد الساعات التي حضرها الطفل';

  @override
  String get hoursTotal => 'مجموع ساعات البرنامج';

  @override
  String get dropoutReason => 'سبب الانسحاب';

  @override
  String get dropoutJustification => 'توضيح سبب الانسحاب';

  @override
  String get services => 'خدمات حماية طفل أخرى يتلقاها';

  @override
  String get comment => 'ملاحظات';

  @override
  String get required => 'إلزامي';

  @override
  String get invalidNumber => 'أدخل رقماً';

  @override
  String get fixErrors => 'يرجى تصحيح الحقول المحددة.';

  @override
  String get savedLocally => 'تم الحفظ على هذا الجهاز.';

  @override
  String get submittedLocally => 'تم الإرسال. ستُرسل إلى الخادم عند المزامنة التالية.';

  @override
  String submitConfirmTitle(String test) {
    return 'إرسال $test؟';
  }

  @override
  String get submitConfirmBody => 'لا يمكن تعديل الإجابات بعد الإرسال.';

  @override
  String get settings => 'الإعدادات';

  @override
  String get language => 'اللغة';

  @override
  String get english => 'English';

  @override
  String get arabic => 'العربية';

  @override
  String version(String version) {
    return 'الإصدار $version';
  }

  @override
  String signedInAs(String name, String partner) {
    return 'تم تسجيل الدخول باسم $name ($partner)';
  }

  @override
  String get referenceUpdated => 'تم تحديث البيانات المرجعية';

  @override
  String get selectOne => 'اختر…';
}
