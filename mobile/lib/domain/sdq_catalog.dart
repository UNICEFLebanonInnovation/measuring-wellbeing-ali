// GENERATED from the resources of the previous Android application (sdq-12.apk).
// Server values are the English strings; Arabic strings are labels only.
// ignore_for_file: lines_longer_than_80_chars

/// One of the 25 SDQ items with both wordings in both languages.
class SdqItem {
  const SdqItem({required this.key, required this.scale, required this.en, required this.enSelf, required this.ar, required this.arSelf});

  /// Column name used by the API (legacy spelling kept on purpose).
  final String key;

  /// emotional | conduct | hyperactivity | peer | prosocial
  final String scale;
  final String en;
  final String enSelf;
  final String ar;
  final String arSelf;

  /// Wording to display: caregiver wording for Form 6-11, self-report for Form 12-17.
  String label({required bool arabic, required bool selfReport}) => arabic ? (selfReport ? arSelf : ar) : (selfReport ? enSelf : en);
}

/// An option whose [value] is sent to the server and whose labels are shown to the user.
class Option {
  const Option(this.value, this.ar);
  final String value;
  final String ar;
  String label(bool arabic) => arabic && ar.isNotEmpty ? ar : value;
}

const List<SdqItem> sdqItems = [
  SdqItem(
    key: 'considerate_of_other_peoples_feelings',
    scale: 'prosocial',
    en: 'Considerate of other people\'s feelings',
    enSelf: 'I try to be nice to other people. I care about their feelings',
    ar: 'يهتم بمشاعر الاخرين',
    arSelf: 'أحاول أن أكون لطيفا مع الآخرين. أهتم بمشاعرهم',
  ),
  SdqItem(
    key: 'restless_overactive_cannot_stay_still_for_long',
    scale: 'hyperactivity',
    en: 'Restless, overactive, cannot stay still for long',
    enSelf: 'I am restless, I cannot stay still for long',
    ar: 'لا يستطيع البقاء او الاستقرار فى مكان واحد. كثير الحركة',
    arSelf: 'لا أستطيع أن أبقى ساكنا لفترة طويلة في مكان واحد. غير مستقر. كثير الحركة',
  ),
  SdqItem(
    key: 'often_complains_of_headaches_stomach_aches_or_sickness',
    scale: 'emotional',
    en: 'Often complains of headaches, stomach-aches or sickness',
    enSelf: 'I get a lot of headaches, stomach-aches or sickness',
    ar: 'كثيرا ما يشكو من صداع او آلام فى البطن او الشعور بالغثيان',
    arSelf: 'كثيرا ما تصيبني آلام في الرأس أو آلام في البطن أو الشعور بالغثيان',
  ),
  SdqItem(
    key: 'shares_readily_with_other_children_for_example_toys',
    scale: 'prosocial',
    en: 'Shares readily with other children, for example toys, treats, pencils',
    enSelf: 'I usually share with others, for example CD\'s, games, food',
    ar: 'يُشرك الآخرين بسهولة فيما يخصه (لعب، أقلام، ألعاب، حلويات، الخ…)',
    arSelf: 'أُشرك الآخرين فيما يخصني من أشياء (أكل، أقلام، ألعاب، إلخ…)',
  ),
  SdqItem(
    key: 'often_loses_temper',
    scale: 'conduct',
    en: 'Often loses temper',
    enSelf: 'I get very angry and often lose my temper',
    ar: 'كثيراً ما تنتابه نوبات من الغضب الشديد أو سريع الغضب',
    arSelf: 'ينتابني غضب شديد. وكثيرا ما أفقد أعصابي',
  ),
  SdqItem(
    key: 'rather_solitary_prefers_to_play_alone',
    scale: 'peer',
    en: 'Rather solitary, prefers to play alone',
    enSelf: 'I would rather be alone than with people of my age',
    ar: 'يحب العزلة. يميل الى اللعب لوحده',
    arSelf: 'في العادة أحب العزلة. ألعب لوحدي. أبقى مع نفسي معظم الوقت',
  ),
  SdqItem(
    key: 'generally_well_behaved_usually_does_what_adults_request',
    scale: 'conduct',
    en: 'Generally well behaved, usually does what adults request',
    enSelf: 'I usually do as I am told',
    ar: 'مطيع على وجه العموم. عادة يفعل ما يطلبه منه الكبار',
    arSelf: 'أنا عادة أفعل ما يطلبه مني الكبار',
  ),
  SdqItem(
    key: 'many_worries_or_often_seems_worried',
    scale: 'emotional',
    en: 'Many worries or often seems worried',
    enSelf: 'I worry a lot',
    ar: 'يقلق من اشياء كثيرة. كثيرا ما يبدو عليه القلق',
    arSelf: 'أقلق كثير',
  ),
  SdqItem(
    key: 'helpful_if_someone_is_hurt_upset_or_feeling_ill',
    scale: 'prosocial',
    en: 'Helpful if someone is hurt, upset or feeling ill',
    enSelf: 'I am helpful if someone is hurt, upset or feeling ill',
    ar: 'يساعد الاخرين اذا ما حدث لأحدهم مكروه',
    arSelf: 'أساعد الآخرين إذا ما حدث لأحدهم مكروه',
  ),
  SdqItem(
    key: 'constantly_fidgeting_or_squirming',
    scale: 'hyperactivity',
    en: 'Constantly fidgeting or squirming',
    enSelf: 'I am constantly fidgeting or squirming',
    ar: 'يتململ أو يتلوى باستمرار (جسمه فى حركة مستمرة اثناء جلوسه)',
    arSelf: 'أتململ وأتلوى (أتقلقل وجسدي يتحرك) باستمرار أثناء جلوسي',
  ),
  SdqItem(
    key: 'has_at_least_one_good_friend',
    scale: 'peer',
    en: 'Has at least one good friend',
    enSelf: 'I have one good friend or more',
    ar: 'لديه على الاقل صديق واحد جيد',
    arSelf: 'لدي صديق عزيز واحد أو أكثر',
  ),
  SdqItem(
    key: 'often_fights_with_other_hildren_or_bullies_them',
    scale: 'conduct',
    en: 'Often fights with other children or bullies them',
    enSelf: 'I fight a lot. I can make other people do what I want',
    ar: 'كثيرا ما يتعارك مع الاخرين من نفس سنه او يستأسد عليهم',
    arSelf: 'أتعارك كثيرا. أتسلط على الآخرين وأجعلهم ينفذون ما أريد',
  ),
  SdqItem(
    key: 'often_unhappy_depressed_or_tearful',
    scale: 'emotional',
    en: 'Often unhappy, depressed or tearful',
    enSelf: 'I am often unhappy, depressed or tearful',
    ar: 'كثيراً ما يكون غير سعيد، حزين، أو يبكي بسهولة',
    arSelf: 'كثيرا ما أكون غير سعيد، حزين، أو سريع البكاء',
  ),
  SdqItem(
    key: 'generally_liked_by_other_children',
    scale: 'peer',
    en: 'Generally liked by other children',
    enSelf: 'Other people my age generally like me',
    ar: 'في الغالب محبوب ممن هم فى سنه',
    arSelf: 'بشكل عام من هم في سني يحبونني',
  ),
  SdqItem(
    key: 'easily_distracted_concentration_wanders',
    scale: 'hyperactivity',
    en: 'Easily distracted, concentration wanders',
    enSelf: 'I am easily distracted, I find it difficult to concentrate',
    ar: 'يتشتت انتباهه بسرعة وقليل التركيز',
    arSelf: 'يتشتت انتباهي بسرعة. أجد صعوبة في التركيز',
  ),
  SdqItem(
    key: 'nervous_or_clingy_in_new_situations_easily_loses_confidence',
    scale: 'emotional',
    en: 'Nervous or clingy in new situations, easily loses confidence',
    enSelf: 'I am nervous in new situations. I easily lose confidence',
    ar: 'عصبي أو متشبث (متعلق) بالآخرين في المواقف الجديدة. من السهل أن يفقد ثقته بنفسه',
    arSelf: 'أنا عصبي في المواقف الجديدة (غير المعتادة). بسهولة أفقد ثقتي بنفسي',
  ),
  SdqItem(
    key: 'kind_to_younger_children',
    scale: 'prosocial',
    en: 'Kind to younger children',
    enSelf: 'I am kind to younger children',
    ar: 'لطيف مع من هم أصغر منه',
    arSelf: 'أنا لطيف مع من هم أصغر مني سنا',
  ),
  SdqItem(
    key: 'often_lies_or_cheats',
    scale: 'conduct',
    en: 'Often lies or cheats',
    enSelf: 'I am often accused of lying or cheating',
    ar: 'كثيراً ما يكذب، يخدع، أو يغش',
    arSelf: 'كثيرا ما يتهمني الآخرون بالكذب أو الخداع',
  ),
  SdqItem(
    key: 'picked_on_or_bullied_by_other_children',
    scale: 'peer',
    en: 'Picked on or bullied by other children',
    enSelf: 'Other children or young people pick on me or bully me',
    ar: 'يستهزاْ منه او يستاسد عليه من هم فى سنه',
    arSelf: 'الأطفال الآخرون يسخرون مني أو يتنمرون علي',
  ),
  SdqItem(
    key: 'often_offers_to_help_others',
    scale: 'prosocial',
    en: 'Often offers to help others (parents, teachers, other children)',
    enSelf: 'I often offer to help others (parents, teachers, children)',
    ar: 'كثيراً ما يتطوع لمساعدة الآخرين (الوالدين، المدرسين، الأطفال الآخرين)',
    arSelf: 'كثيرا ما أتطوع لمساعدة الآخرين (الوالدين، المدرسين، الأطفال الآخرين)',
  ),
  SdqItem(
    key: 'thinks_things_out_before_acting',
    scale: 'hyperactivity',
    en: 'Thinks things out before acting',
    enSelf: 'I think before I do things',
    ar: 'يفكر قبل ان يتصرف',
    arSelf: 'أفكر قبل أن أتصرف',
  ),
  SdqItem(
    key: 'steals_from_home_school_or_elsewhere',
    scale: 'conduct',
    en: 'Steals from home, school or elsewhere',
    enSelf: 'I take things that are not mine from home, school or elsewhere',
    ar: 'يسرق من البيت او المدرسة او من اْماكن اخرى',
    arSelf: 'آخذ أشياء ليست ملكي من البيت أو المدرسة أو من أماكن أخرى',
  ),
  SdqItem(
    key: 'gets_along_better_with_adults_than_with_other_children',
    scale: 'peer',
    en: 'Gets along better with adults than with other children',
    enSelf: 'I get along better with adults than with people my own age',
    ar: 'ينسجم بشكل اْفضل مع الكبار عنه مع الاطفال فى نفس سنه',
    arSelf: 'أنسجم بشكل أفضل مع الكبار عنه مع من هم في نفس سني',
  ),
  SdqItem(
    key: 'many_fears_easily_scared',
    scale: 'emotional',
    en: 'Many fears, easily scared',
    enSelf: 'I have many fears, I am easily scared',
    ar: 'يخاف من اشياء كثيرة. من السهل تخويفه',
    arSelf: 'لدي مخاوف كثيرة . من السهل تخويفي',
  ),
  SdqItem(
    key: 'good_attention_span_sees_chores_or_homework_through_to_the_end',
    scale: 'hyperactivity',
    en: 'Good attention span, sees chores or homework through to the end',
    enSelf: 'I finish the work I\'m doing. My attention is good',
    ar: 'يتابع اداء الواجبات حتى النهاية. لديه انتباه جيد',
    arSelf: 'أكمل العمل الذي أقوم به حتى النهاية . انتباهي جيد',
  ),
];

const List<Option> categoryOptions = [
  Option('Child Labour Activity', 'نشاط عمالة الاطفال'),
  Option('Child Marriage Activity', 'نشاط زواج الأطفال'),
  Option('Violent Discipline Activity', 'نشاط الانضباط العنيف'),
  Option('Other', 'نشاطات اخرى'),
];

const List<Option> nationalityOptions = [
  Option('Lebanese', 'لبناني (ة)'),
  Option('Syrian', 'سوري (ة)'),
  Option('Palestinian', 'فلسطيني (ة)'),
  Option('Other Nationality', 'غير ذلك'),
];

const List<Option> genderOptions = [Option('male', 'ذكر'), Option('female', 'أنثى')];

const List<Option> donorOptions = [
  Option('UNICEF', 'UNICEF'),
  Option('UNHCR', 'UNHCR'),
  Option('ERF', 'ERF'),
  Option('BPRM', 'BPRM'),
  Option('SiDA', 'SiDA'),
  Option('UNRWA', 'UNRWA'),
  Option('UNFPA', 'UNFPA'),
  Option('DFID', 'DFID'),
  Option('ECHO', 'ECHO'),
  Option('UNDP', 'UNDP'),
  Option('DFATD - Canada', 'DFATD - Canada'),
  Option('EC - DEVCO', 'EC - DEVCO'),
  Option('Other', 'Other'),
];

const List<Option> gatewayOptions = [
  Option('Informal Settlement', 'مستوطنة غير رسمية'),
  Option('Social Development Center', 'مركز التنمية الإجتماعية'),
  Option('School', 'مدرسة'),
  Option('Primary Health Center', 'مركز الرعاية الصحية الأولية'),
  Option('Secondary Health Center', 'مركز الرعاية الصحية الثانوية'),
  Option('Municipality', 'بلدية'),
  Option('Community center', 'مركز إجتماعي'),
  Option('Palestinian camp', 'مخيم للفلسطينيين'),
  Option('Palestinian gathering', 'تجمع للفلسطينيين'),
  Option('UNHCR registration center', 'مركز تسجيل لمفوضية الأمم المتحدة'),
  Option('Border crossing', 'معبر حدود'),
  Option('Remotely', 'عن بعد'),
  Option('Other', 'غير ذلك'),
];

const List<Option> dropoutOptions = [
  Option('Did Not Drop Out', 'لم ينسحب'),
  Option('Child was no longer allowed to access activity', 'لم يسمح له بالمشاركة'),
  Option('Child said he did not want to participate in activity any longer', 'لم يعد يرغب حضور النشاط'),
  Option('Relocation within Lebanon', 'نقل إلى مكان آخر في لبنان'),
  Option('Returned to Syria', 'عاد إلى سوريا'),
  Option('Left for third country', 'غادر إلى بلد ثالث'),
  Option('Other reason', 'سبب أخر'),
];

const List<Option> serviceOptions = [
  Option('Case management', 'إدارة حالة'),
  Option('Community based Child protection activities', 'أنشطة حماية الطفل المجتمعية'),
  Option('Formal Education', 'التعليم النظامي'),
  Option('Non-formal education (VET programs…)', 'التعليم غير الرسمي (برامج التعليم والتدريب المهني ، ...)'),
];

const List<Option> consentOptions = [Option('yes', 'نعم، تم منح الإذن'), Option('no', 'لا، لم يتم منح الإذن')];

/// Labels of the consent options in English (values are yes/no).
const Map<String, String> consentEnglish = {'yes': 'Yes, permission is given', 'no': 'No, permission is not given'};

const List<Option> answerOptions = [Option('0', 'غير صحيح'), Option('1', 'صحيح نوعاً ما'), Option('2', 'صحيح بالتأكيد'), Option('na', 'لا إجابة')];

const Map<String, String> answerEnglish = {'0': 'Not true', '1': 'Somewhat true', '2': 'Certainly true', 'na': 'No answer'};

const List<Option> agencyOptions = [
  Option('ABAAD', 'ABAAD'),
  Option('AMEL', 'AMEL'),
  Option('AND', 'AND'),
  Option('ARC', 'ARC'),
  Option('ASMAE', 'ASMAE'),
  Option('CARE International', 'CARE International'),
  Option('Caritas Lebanon', 'Caritas Lebanon'),
  Option('CONECRN', 'CONECRN'),
  Option('Dorcas', 'Dorcas'),
  Option('Danish Refugee Council', 'Danish Refugee Council'),
  Option('Himaya', 'Himaya'),
  Option('ICRC', 'ICRC'),
  Option('Intersos', 'Intersos'),
  Option('IOCC', 'IOCC'),
  Option('IRC', 'IRC'),
  Option('KAFA', 'KAFA'),
  Option('Makhzoumi Foundation', 'Makhzoumi Foundation'),
  Option('Mercy Corps', 'Mercy Corps'),
  Option('Mouvement Social', 'Mouvement Social'),
  Option('MSF', 'MSF'),
  Option('Nabad', 'Nabad'),
  Option('NRC', 'NRC'),
  Option('RAHMA', 'RAHMA'),
  Option('RESTART', 'RESTART'),
  Option('Renee Mouawad Foundation', 'Renee Mouawad Foundation'),
  Option('RtP', 'RtP'),
  Option('Sanabel Al Janoub', 'Sanabel Al Janoub'),
  Option('SAWA', 'SAWA'),
  Option('SCI', 'SCI'),
  Option('SIF', 'SIF'),
  Option('TDH-Italy', 'TDH-Italy'),
  Option('TDH-Lausanne', 'TDH-Lausanne'),
  Option('WCH', 'WCH'),
  Option('WVI', 'WVI'),
  Option('YNCA', 'YNCA'),
  Option('MAP-UK', 'MAP-UK'),
  Option('Other', 'Other'),
];

const List<Option> formOptions = [Option('Form 6-11', 'Form 6-11'), Option('Form 12-17', 'Form 12-17')];

const String didNotDropOut = 'Did Not Drop Out';

/// Consent script read to the caregiver or adolescent before the questionnaire.
String consentScript({required bool arabic, required bool postTest}) {
  if (postTest) {
    return arabic
        ? 'صباح الخير, اسمي _. أنا من +. كجزء من برنامج الدعم النفسي الاجتماعي المركز ، نحن نجري استبيان باستخدام أداة عالميّه (مواطن القوة والصعوبه ) وتتألف من 25 سؤالا. لذلك، لا يمكننا تغيير طريقة طرح الأسئله . يهدف االأستبيان إلى تقييم برامجنا وعما إذا كانت برامجنا تساهم في تحسين الوضع النفسي الأجتماعي للأطفال بعد حضورهم هذه الأنشطة. سوف يحتاج الاستبيان في المعدل المتوسط من 20 إلى 30 دقيقة لأتمامه. تم اختيار طفلك بشكل عشوائي لهذا الغرض. والمشاركه في هذا الأستبيان من دون مقابل أو مخاطر . سيتم استخدام مشاركتكم لمساعدتنا على تحسين أنشطتنا لنتمكن من تحسين دعم الأطفال. ستبقى مشاركتكم سريّه ومجهوله في جميع مراحل جمع البيانات حيث سيتم حفظها بشكل مرمّز دون استعمال الأسماء. إذا اخترت المشاركة في هذا الأستبيان، يرجى الإجابة على جميع الأسئلة بصدق قدر المستطاع و لا توجد إجابة صحيحة أو خاطئة، و كلما كنت أكثر صدقا كلما كانت برامجنا افضل للأطفال. انّ المشاركة طوعية ويمكنك التوقف في أية لحظة عن المشاركة .   هل أنت موافق على البدء؟ شكرا جزيل'
        : 'Good morning, my name is _ and I\'am from +. As part of our focused psychosocial support program, we are conducting an assessment using an international tool comprised of 25 questions. Therefore, the way questions are asked remains the same and cannot be changed. The assessment aims to evaluate our programmes and whether they are contributing towards improving how children feel after attending these activities. The questionnaire would need an average of 20 to 30 minutes to be answered. You/your child have been randomly selected for this purpose. There is no compensation for responding nor is there any known risk. Your response will be used to help us improve our activities so we can better support children. You responses will remain confidential and anonymous at all stages as data will be compiled with a code. If you choose to participate in this project, please answer all questions as honestly as possible there is no right or wrong answer, and the more honest you are the better we can make our programs for children. Participation is voluntary and you can stop us at any moment. Are you ok to start? Thank you very much.';
  }
  return arabic
      ? 'صباح الخير, اسمي _. أنا من +. كجزء من برنامج الدعم النفسي الاجتماعي المركز ، نحن نجري استبيان باستخدام أداة عالميّه (مواطن القوة والصعوبه ) وتتألف من 25 سؤالا. لذلك، لا يمكننا تغيير طريقة طرح الأسئله . يهدف االأستبيان إلى تقييم برامجنا وعما إذا كانت برامجنا تساهم في تحسين الوضع النفسي الأجتماعي للأطفال بعد حضورهم هذه الأنشطة. سوف يحتاج الاستبيان في المعدل المتوسط من 20 إلى 30 دقيقة لأتمامه. تم اختيار طفلك بشكل عشوائي لهذا الغرض. والمشاركه في هذا الأستبيان من دون مقابل أو مخاطر . سيتم استخدام مشاركتكم لمساعدتنا على تحسين أنشطتنا لنتمكن من تحسين دعم الأطفال. ستبقى مشاركتكم سريّه ومجهوله في جميع مراحل جمع البيانات حيث سيتم حفظها بشكل مرمّز دون استعمال الأسماء. إذا اخترت المشاركة في هذا الأستبيان، يرجى الإجابة على جميع الأسئلة بصدق قدر المستطاع و لا توجد إجابة صحيحة أو خاطئة، و كلما كنت أكثر صدقا كلما كانت برامجنا افضل للأطفال. انّ المشاركة طوعية ويمكنك التوقف في أية لحظة عن المشاركة .  سوف يتكرر نفس الاستبيان في نهاية مشاركة طفلك في البرنامج. هل أنت موافق على البدء؟ شكرا جزيل'
      : 'Good morning, my name is _ and I\'am from +. As part of our focused psychosocial support program, we are conducting an assessment using an international tool comprised of 25 questions. Therefore, the way questions are asked remains the same and cannot be changed. The assessment aims to evaluate our programmes and whether they are contributing towards improving how children feel after attending these activities. The questionnaire would need an average of 20 to 30 minutes to be answered. You/your child have been randomly selected for this purpose. There is no compensation for responding nor is there any known risk. Your response will be used to help us improve our activities so we can better support children. You responses will remain confidential and anonymous at all stages as data will be compiled with a code. If you choose to participate in this project, please answer all questions as honestly as possible there is no right or wrong answer, and the more honest you are the better we can make our programs for children. Participation is voluntary and you can stop us at any moment. The same questionnaire will be repeated at the end of your/your child participation in the programme. Are you ok to start? Thank you very much.';
}
