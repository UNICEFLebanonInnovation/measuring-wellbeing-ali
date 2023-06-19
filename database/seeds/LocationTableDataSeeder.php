<?php

use Illuminate\Database\Seeder;
use App\Gouvernate;
use App\Caza;
use App\Area;

class LocationTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$Gouvernate = [
    		[
        		'name' => 'Baalbek-El Hermel',
        		'arabic' => "بعلبك - الهرمل"
        	],
        	[
        		'name' => 'Beirut',
        		'arabic' => "بيروت"
        	],
        	[
        		'name' => 'Bekaa',
        		'arabic' => "البقاع"
        	],
        	[
        		'name' => 'El Nabatieh',
        		'arabic' => "النبطية"
        	],
        	[
        		'name' => 'Mount Lebanon',
        		'arabic' => "جبل لبنان"
        	],
        	[
        		'name' => 'North',
        		'arabic' => "الشمال"
        	],
        	[
        		'name' => 'South',
        		'arabic' => "الجنوب"
        	]
    	];

    	Gouvernate::insert($Gouvernate);

        $Caza = [
        	[
        		'name' => 'Akkar',
        		'gouvernate_id' => 1,
        		'arabic' => "عكار"
        	],
        	[
        		'name' => 'Aley',
        		'gouvernate_id' => 9,
        		'arabic' => "عاليه"
        	],
        	[
        		'name' => 'Baabda',
        		'gouvernate_id' => 9,
        		'arabic' => "بعبدا"
        	],
        	[
        		'name' => 'Baalbek',
        		'gouvernate_id' => 5,
        		'arabic' => "بعلبك"
        	],
        	[
        		'name' => 'Bcharre',
        		'gouvernate_id' => 10,
        		'arabic' => "بشري"
        	],
        	[
        		'name' => 'Beirut',
        		'gouvernate_id' => 6,
        		'arabic' => "بيروت"
        	],
        	[
        		'name' => 'Bent Jbeil',
        		'gouvernate_id' => 8,
        		'arabic' => "بنت جبيل"
        	],
        	[
        		'name' => 'Chouf',
        		'gouvernate_id' => 9,
        		'arabic' => "الشوف"
        	],
        	[
        		'name' => 'El Batroun',
        		'gouvernate_id' => 10,
        		'arabic' => "البترون"
        	],
        	[
        		'name' => 'El Hermel',
        		'gouvernate_id' => 5,
        		'arabic' => "الهرمل"
        	],
        	[
        		'name' => 'El Koura',
        		'gouvernate_id' => 10,
        		'arabic' => "الكورة"
        	],
        	[
        		'name' => 'El Meten',
        		'gouvernate_id' => 9,
        		'arabic' => "المتن"
        	],
        	[
        		'name' => 'El Minieh-Dennie',
        		'gouvernate_id' => 10,
        		'arabic' => "المنية الضنية"
        	],
        	[
        		'name' => 'El Nabatieh',
        		'gouvernate_id' => 8,
        		'arabic' => "النبطية"
        	],
        	[
        		'name' => 'Hasbaya',
        		'gouvernate_id' => 8,
        		'arabic' => "حاصبيا"
        	],
        	[
        		'name' => 'Jbeil',
        		'gouvernate_id' => 9,
        		'arabic' => "جبيل"
        	],
        	[
        		'name' => 'Jezzine',
        		'gouvernate_id' => 10,
        		'arabic' => "جزين"
        	],
        	[
        		'name' => 'Kesrwane',
        		'gouvernate_id' => 9,
        		'arabic' => "كسروان"
        	],
        	[
        		'name' => 'Marjaayoun',
        		'gouvernate_id' => 8,
        		'arabic' => "مرجعيون"
        	],
        	[
        		'name' => 'Rachaya',
        		'gouvernate_id' => 7,
        		'arabic' => "راشيا"
        	],
        	[
        		'name' => 'Saida',
        		'gouvernate_id' => 11,
        		'arabic' => "صيدا"
        	],
        	[
        		'name' => 'Sour',
        		'gouvernate_id' => 11,
        		'arabic' => "صور"
        	],
        	[
        		'name' => 'Tripoli',
        		'gouvernate_id' => 10,
        		'arabic' => "طرابلس"
        	],
        	[
        		'name' => 'West Bekaa',
        		'gouvernate_id' => 7,
        		'arabic' => "البقاع الغربي"
        	],
        	[
        		'name' => 'Zahle',
        		'gouvernate_id' => 7,
        		'arabic' => "زحلة"
        	],
        	[
        		'name' => 'Zgharta',
        		'gouvernate_id' => 10,
        		'arabic' => "زغرتا"
        	]
        ];

        /*Caza::insert($Caza);*/

        $Akkar = array (
              0 => 'Aadouiye',
              1 => 'Aaidamoun',
              2 => 'Aaiyat',
              3 => 'Aakkar El Attiqa',
              4 => 'Aamara',
              5 => 'Aaouinat',
              6 => 'Aarab Jourmnaya',
              7 => 'Aarida',
              8 => 'Aarmeh',
              9 => 'Aarqa',
              10 => 'Aayoun',
              11 => 'Aayoun El Ghezlane',
              12 => 'Abde',
              13 => 'Ain er Rsas',
              14 => 'Ain ez Zeit',
              15 => 'Ain Faouar',
              16 => 'Ain Tinta',
              17 => 'Ain Yaaqoub',
              18 => 'Akroum',
              19 => 'Al-Massoudieh',
              20 => 'Amaret el Baykat',
              21 => 'Amayer',
              22 => 'Andqat',
              23 => 'Ard es Soud',
              24 => 'Awade',
              25 => 'Baaliye',
              26 => 'Baddouaa',
              27 => 'Bajaa',
              28 => 'Balde',
              29 => 'Bani Sakher',
              30 => 'Barcha',
              31 => 'Bebnine',
              32 => 'Beino',
              33 => 'Beit Ali Adraa',
              34 => 'Beit Ayoub',
              35 => 'Beit Daoud',
              36 => 'Beit el Haj',
              37 => 'Beit el Haouch',
              38 => 'Beit Ghattas',
              39 => 'Beit Khlaiyel',
              40 => 'Beit Mellat',
              41 => 'Beit Younes',
              42 => 'Bellanet el Hissa',
              43 => 'Berbara',
              44 => 'Berqayel',
              45 => 'Bezbina',
              46 => 'Bire Akkar',
              47 => 'Borj el Arab',
              48 => 'Boustane El Herch',
              49 => 'Bqayaa',
              50 => 'Bqerzala',
              51 => 'Bzaita',
              52 => 'Bzal',
              53 => 'Chadra',
              54 => 'Chane',
              55 => 'Chaqdouf',
              56 => 'Charbila',
              57 => 'Chattaha',
              58 => 'Cheik Mohammad',
              59 => 'Cheikh Aayash',
              60 => 'Cheikh Hmairine',
              61 => 'Cheikh Taba',
              62 => 'Cheikh Taba es Sahl',
              63 => 'Cheikh Zennad Talbibe',
              64 => 'Cheikhlar',
              65 => 'Chir Hmairine',
              66 => 'Dabadeb',
              67 => 'Daghle',
              68 => 'Dahr Aayas',
              69 => 'Dahr El Ballane',
              70 => 'Dahr el Houssain',
              71 => 'Dahr Laissineh',
              72 => 'Danke et El Amriyeh',
              73 => 'Daousse Baghdadi',
              74 => 'Darine',
              75 => 'Dayret Nahr el Kabir',
              76 => 'Deir Dalloum',
              77 => 'Deir Janine',
              78 => 'Deir Mar Jeryos',
              79 => 'Denke',
              80 => 'Dibbabiye',
              81 => 'Dinbou Ain al zahab',
              82 => 'Doueir Aadouiye',
              83 => 'Ech Cheikh Maarouf',
              84 => 'Ed Daoura',
              85 => 'Ed Daousse',
              86 => 'Ed Debbabiye el Charqiye',
              87 => 'Ed Debbabiye el Gharbiye',
              88 => 'El Aabboudiye',
              89 => 'El Aamriye',
              90 => 'El Aaouaichat',
              91 => 'El Aarida',
              92 => 'El Aayoun',
              93 => 'El Barde',
              94 => 'El Borj Akkar',
              95 => 'El Fraidis',
              96 => 'El Ghawaya',
              97 => 'El Haissa',
              98 => 'El Hichi',
              99 => 'El Houaich',
              100 => 'El Kharnoubeh',
              101 => 'El Khirbe',
              102 => 'El Khirbe Msalla',
              103 => 'EL Khirbe Qleiaat',
              104 => 'El Khoder',
              105 => 'El Kneisse',
              106 => 'El Kouraniye',
              107 => 'El Krahne',
              108 => 'El Kroum',
              109 => 'El Majdal',
              110 => 'El Majdel',
              111 => 'El Mbar kiye',
              112 => 'El Melkiye',
              113 => 'El Mqaiteaa',
              114 => 'El Qantara',
              115 => 'El Qatlabe',
              116 => 'El Qlaiaat',
              117 => 'El Qorne',
              118 => 'El Qsair',
              119 => 'El Rama',
              120 => 'En Nabi Khaled',
              121 => 'Er Ransiye',
              122 => 'Er Rouaime',
              123 => 'Es Sayeh',
              124 => 'Es Souaisse',
              125 => 'Ez Zouq',
              126 => 'Fard',
              127 => 'Fnaideq',
              128 => 'Fsiqine et Ain Echma',
              129 => 'Ghzaile',
              130 => 'Habchit',
              131 => 'Haider',
              132 => 'Haitla',
              133 => 'Haizouq',
              134 => 'Halba',
              135 => 'Haouch',
              136 => 'Haouchab',
              137 => 'Haret Beit Kessab',
              138 => 'Haret ej Jdide',
              139 => 'Haret ej Jdide Mqaiteaa',
              140 => 'Hedd',
              141 => 'Hikr Janine',
              142 => 'Hissa',
              143 => 'Hmaireh Aakkar',
              144 => 'Hmais',
              145 => 'Hnaider',
              146 => 'Hokr ech Cheikh Taba',
              147 => 'Hokr ed Dahri',
              148 => 'Hokr el Kousse',
              149 => 'Hokr El Mahmoudiye',
              150 => 'Hokr Etti',
              151 => 'Hokr Jouret Srar',
              152 => 'Hrar',
              153 => 'Idbil',
              154 => 'Ilat',
              155 => 'Janine',
              156 => 'Jdaidet Ej Joumeh',
              157 => 'Jdeide',
              158 => 'Jdeidet El Qaitaa',
              159 => 'Jebrayel',
              160 => 'Jichet Aali Houssein',
              161 => 'Jouret Srar',
              162 => 'Kafr El Ftouh',
              163 => 'Kafroun',
              164 => 'Kalkha',
              165 => 'Karm el Aasfour',
              166 => 'Karm Zebdine',
              167 => 'Kawashra',
              168 => 'Kfar Harra',
              169 => 'Kfar Melki',
              170 => 'Kfar Noun',
              171 => 'Kfartoun',
              172 => 'Khalsa',
              173 => 'Khane Hayat',
              174 => 'Khat Petrol',
              175 => 'Khirbet Char',
              176 => 'Khirbet Daoud',
              177 => 'Khirbet er Roummane',
              178 => 'Khirbit Ej Jord',
              179 => 'Khorab el Haiyat',
              180 => 'Khraibe Akkar',
              181 => 'Khreibet ej Jindi',
              182 => 'Knaisse Hnaider',
              183 => 'Knisseh',
              184 => 'Kouikhat',
              185 => 'Kousha',
              186 => 'Kroum el Arab',
              187 => 'Machha',
              188 => 'Machta Hammoud',
              189 => 'Machta Hassan',
              190 => 'Mahmoudiye',
              191 => 'Majdla',
              192 => 'Mar Lia Hdare',
              193 => 'Mar Sahllita',
              194 => 'Mar Touma',
              195 => 'Marlayet Haddara',
              196 => 'Marlayet Melhem',
              197 => 'Martmoura',
              198 => 'Mazraat Al Balde',
              199 => 'Mechaeilha Hakour',
              200 => 'Mechmech',
              201 => 'Meghraq',
              202 => 'Meghraqa',
              203 => 'Memnaa',
              204 => 'Mhamra',
              205 => 'Mhatat Siket el Hadid',
              206 => 'Minyara',
              207 => 'Mouanse',
              208 => 'Mounjez',
              209 => 'Mqaible',
              210 => 'Mqaitaa',
              211 => 'Mrah Aakkar',
              212 => 'Mrah Al Khawkh',
              213 => 'Mrah el Aainouni',
              214 => 'Mrah el Bsatine',
              215 => 'Mrah Qamar ed Dine',
              216 => 'Msalla',
              217 => 'Mzeihmeh',
              218 => 'Nabaa el Ghzaile',
              219 => 'Nahr El Bared',
              220 => 'Nahriye',
              221 => 'Nassriye',
              222 => 'Nfaisseh',
              223 => 'Noura',
              224 => 'Noura el Faouqa et el Tahta',
              225 => 'Noura el Tahta',
              226 => 'Ouadi Ej jamous',
              227 => 'Qaabrine',
              228 => 'Qabaait',
              229 => 'Qanbar',
              230 => 'Qarha Akkar',
              231 => 'Qarqaf',
              232 => 'Qbaiyat el Gharbiye',
              233 => 'Qbaiyat ez Zouq',
              234 => 'Qboula',
              235 => 'Qbour El Bid',
              236 => 'Qinye',
              237 => 'Qloud El-Baqieh',
              238 => 'Qochloq',
              239 => 'Qoubaiyat',
              240 => 'Qoubbet Chamra',
              241 => 'Qraiyat',
              242 => 'Rahbe',
              243 => 'Rajm Hssein',
              244 => 'Rajm Issa',
              245 => 'Rajm Khalaf',
              246 => 'Rihaniye',
              247 => 'Rmah En Nahriyeh',
              248 => 'Rmoul',
              249 => 'Saadine',
              250 => 'Sadaqa',
              251 => 'Sahle',
              252 => 'Saidnaya',
              253 => 'Saissouq',
              254 => 'Sammouniye',
              255 => 'Saoualha',
              256 => 'Sbagha',
              257 => 'Semmaqiye',
              258 => 'Semmaqli',
              259 => 'Sfaynet El-Qaitaa',
              260 => 'Sfinet ed Dreib',
              261 => 'Shaqdouf Aakkar',
              262 => 'Sindianet Zeidane',
              263 => 'Srar',
              264 => 'Takrit',
              265 => 'Tal Meaayan',
              266 => 'Tall Aabbas Ech-Charqi',
              267 => 'Tall Aabbas el Gharbi',
              268 => 'Tall Bire',
              269 => 'Tall Hmayra',
              270 => 'Tallet el Mjabber',
              271 => 'Tallet ez Zefir',
              272 => 'Tashea',
              273 => 'Tell Bibi',
              274 => 'Tell Hayat',
              275 => 'Tell Kindi',
              276 => 'Tell Kiri',
              277 => 'Tell Sebael',
              278 => 'Tleil',
              279 => 'Wadi Al Hoor',
              280 => 'Wadi Khaled',
              281 => 'Zouaitini Akkar',
              282 => 'Zouarib',
              283 => 'Zouk Haddara',
              284 => 'Zouq el Hassineh',
              285 => 'Zouq El Mqachrine',
              286 => 'Zouq El-Hbalsa',
            );
        $Akkar1 = array (
          0 => 'عدوي',
          1 => 'عيدمون',
          2 => 'عيات',
          3 => 'عكار العتيقة',
          4 => 'عماره',
          5 => 'العوينات',
          6 => 'جرمنايا',
          7 => 'عريضا',
          8 => 'عرمه',
          9 => 'عرقا',
          10 => 'عيون',
          11 => 'عيون الغزلان',
          12 => 'العبده',
          13 => 'عين الراس',
          14 => 'عين الزيت',
          15 => 'عين الفوار',
          16 => 'عين تنتا',
          17 => 'عين يعقوب',
          18 => 'اكروم',
          19 => 'المسعودية',
          20 => 'عمار البيكات',
          21 => 'العماير',
          22 => 'عندقت',
          23 => 'ارض السود',
          24 => 'العواده',
          25 => 'بعليا',
          26 => 'بدويا',
          27 => 'بجعة',
          28 => 'بلدي',
          29 => 'بني صخر',
          30 => 'برشا',
          31 => 'ببنين',
          32 => 'بينو',
          33 => 'بيت علي عدرة',
          34 => 'بيت ايوب',
          35 => 'بيت داوود',
          36 => 'بيت الحاج',
          37 => 'بيت الحوش',
          38 => 'بيت غطاس',
          39 => 'بيت خلايل',
          40 => 'بيت ملات',
          41 => 'بيت يونس',
          42 => 'بلانة الحيصة',
          43 => 'برباره',
          44 => 'برقايل',
          45 => 'بزبينا',
          46 => 'البيره عكار',
          47 => 'برج العرب',
          48 => 'بستان الحرش',
          49 => 'البقيعه',
          50 => 'بقرزلا',
          51 => 'بزيتا',
          52 => 'بزال',
          53 => 'شدره',
          54 => 'شان',
          55 => 'الشقدوف',
          56 => 'شربيلا',
          57 => 'شطاحة',
          58 => 'الشيخ محمد',
          59 => 'الشيخ عياش',
          60 => 'شيخ حمارين',
          61 => 'الشيخ طابا',
          62 => 'الشيخ طابا السهل',
          63 => 'الشيخ زناد',
          64 => 'شيخلار',
          65 => 'شير حمارين',
          66 => 'داباديب',
          67 => 'الدغلة',
          68 => 'ضهر عياس',
          69 => 'ضهر البلانه',
          70 => 'ضهر الحسين',
          71 => 'ضهر ليسينه',
          72 => 'دنكة و العامرية',
          73 => 'دوسة بغدادي',
          74 => 'دارين',
          75 => 'دائرة النهر الكبير',
          76 => 'دير دلوم',
          77 => 'دير جنين',
          78 => 'دير مار جريس',
          79 => 'دنكي',
          80 => 'دبابية',
          81 => 'دنبو عين الذهب',
          82 => 'دوير عدويه',
          83 => 'الشيخ معروف',
          84 => 'الدوره',
          85 => 'الدوسة',
          86 => 'الدبابية الشرقية',
          87 => 'الدبابية الغربية',
          88 => 'العبودية',
          89 => 'العمارية',
          90 => 'العويشات',
          91 => 'العريضة',
          92 => 'العيون',
          93 => 'بردي',
          94 => 'البرج عكار',
          95 => 'فريديس',
          96 => 'القبيات غوايا',
          97 => 'الحيصة',
          98 => 'الهيشه',
          99 => 'الحويش',
          100 => 'الخرنوبه',
          101 => 'الخربة',
          102 => 'الخربة مصلا',
          103 => 'الخربة قليعات',
          104 => 'الخضر اكروم',
          105 => 'الكنيسة',
          106 => 'الكورانية',
          107 => 'الكراهنة',
          108 => 'الكروم',
          109 => 'المجدل العماير',
          110 => 'المجدل عكار',
          111 => 'المباركية',
          112 => 'الملكي',
          113 => 'المقيطع',
          114 => 'القنطرة',
          115 => 'القبيات القطلبه',
          116 => 'القليعات',
          117 => 'القرنة',
          118 => 'القصير',
          119 => 'الرامه',
          120 => 'النبي خالد',
          121 => 'الرانسية',
          122 => 'الرويمة',
          123 => 'السايح',
          124 => 'السويسة',
          125 => 'الذوق',
          126 => 'الفرض',
          127 => 'فنيدق',
          128 => 'فسقين و عين اشما',
          129 => 'الغزيله',
          130 => 'حبشيت',
          131 => 'حيدر',
          132 => 'هيتلا',
          133 => 'حيزوق',
          134 => 'حلبا',
          135 => 'حوش',
          136 => 'هوشب',
          137 => 'حارة بيت كساب',
          138 => 'حارة الجديدة',
          139 => 'حارة الجديدة المقيطع',
          140 => 'الهد',
          141 => 'حكر جنين',
          142 => 'الحيصا',
          143 => 'الحميرة',
          144 => 'حميص',
          145 => 'حنيدر',
          146 => 'حكر الشيخ طابا',
          147 => 'حكر الضاهري',
          148 => 'حكر الكوسا',
          149 => 'حكر المحمودية',
          150 => 'حكر قتة',
          151 => 'حكر جورة سرار',
          152 => 'حرار',
          153 => 'عدبل',
          154 => 'ايلات',
          155 => 'جنين',
          156 => 'جديدة الجومه',
          157 => 'جديدة',
          158 => 'جديدة القيطع',
          159 => 'جبرائيل',
          160 => 'جيشة علي حسين',
          161 => 'جورة سرار',
          162 => 'كفر الفتوح',
          163 => 'كفرون',
          164 => 'كلخا',
          165 => 'كرم عصفور',
          166 => 'كرم زبدين',
          167 => 'الكواشرة',
          168 => 'كفرحره',
          169 => 'كفرملكي',
          170 => 'كفرنون',
          171 => 'كفرتون',
          172 => 'خالصة',
          173 => 'خان الحيات',
          174 => 'خط البترول',
          175 => 'خربة شار',
          176 => 'خربة داوود',
          177 => 'خربة الرمان',
          178 => 'خربة الجرد',
          179 => 'خرب الحيات',
          180 => 'الخريبة',
          181 => 'خريبة الجندي',
          182 => 'كنيسة هنيدر',
          183 => 'كنيسة',
          184 => 'الكويخات',
          185 => 'كوشا',
          186 => 'كروم العرب',
          187 => 'مشحة',
          188 => 'مشتى حمود',
          189 => 'مشتى حسن',
          190 => 'المحمودية',
          191 => 'مجدلا',
          192 => 'مار ليا حدار',
          193 => 'مار شليطا',
          194 => 'مار توما',
          195 => 'مارليات حدارا',
          196 => 'مار ليا ملحم',
          197 => 'القبيات مرتموره',
          198 => 'مزرعة بلدة',
          199 => 'مشيلحة الحاكور',
          200 => 'مشمش',
          201 => 'المغراق',
          202 => 'مغراقا',
          203 => 'ممنع',
          204 => 'المحمرة',
          205 => 'محطة سكة الحديد',
          206 => 'منيارة',
          207 => 'المونسه',
          208 => 'منجز',
          209 => 'المقيبلة',
          210 => 'مقيطع السماكلي',
          211 => 'مراه عكار',
          212 => 'مراح الخوخ',
          213 => 'مراه العينوني',
          214 => 'مراح البساتين',
          215 => 'مراح قمر الدين',
          216 => 'مصلا',
          217 => 'مزيحمة',
          218 => 'نبع الغزيلة',
          219 => 'نهر البارد',
          220 => 'النهريه',
          221 => 'ناصرية',
          222 => 'النفيسة',
          223 => 'النوره',
          224 => 'نورا الفوقا و التحتى',
          225 => 'نورا التحتا',
          226 => 'وادي الجاموس',
          227 => 'قعبرين',
          228 => 'قبعيت',
          229 => 'القنبر',
          230 => 'قرحه عكار',
          231 => 'القرقف',
          232 => 'القبيات الغربية',
          233 => 'القبيات الذوق',
          234 => 'قبولا',
          235 => 'قبور البيد',
          236 => 'قنية',
          237 => 'قلود الباقية',
          238 => 'قشلق',
          239 => 'القبيات',
          240 => 'قبة شمرا',
          241 => 'القريات',
          242 => 'رحبة',
          243 => 'رجم حسين',
          244 => 'رجم عيسى',
          245 => 'رجم خلف',
          246 => 'الريحانية',
          247 => 'رماح النهريه',
          248 => 'رمول',
          249 => 'سعدين',
          250 => 'صدقة',
          251 => 'السهله',
          252 => 'السنديانة',
          253 => 'سيسوق',
          254 => 'السمونيه',
          255 => 'ساولها',
          256 => 'صباغا',
          257 => 'السماقية',
          258 => 'سمقالي',
          259 => 'سفينة القيطع',
          260 => 'سفينة الدريب',
          261 => 'شقدوف عكار',
          262 => 'سنديانة زيدان',
          263 => 'سرار',
          264 => 'تكريت',
          265 => 'تلمعيان',
          266 => 'تل عباس الشرقي',
          267 => 'تلعباس غربي',
          268 => 'تلبيرة',
          269 => 'تلحميرة',
          270 => 'تلة المجابر',
          271 => 'تلة الزفير',
          272 => 'تاشع',
          273 => 'تلبيبة',
          274 => 'تل الحيات',
          275 => 'تل كندي',
          276 => 'تل كيري',
          277 => 'تل سبعل',
          278 => 'التليل',
          279 => 'وادي الحور',
          280 => 'وادي خالد',
          281 => 'الزويتينة عكار',
          282 => 'الزواريب',
          283 => 'ذوق حدارة',
          284 => 'ذوق الحصينة',
          285 => 'ذوق المقشرين',
          286 => 'ذوق الحبالصة"',
        );

        /*for ($i=0; $i <= count($Akkar) ; $i++) {
            Area::insert([
                'caza_id' => 3,
                'name' => $Akkar[$i],
                'arabic' => $Akkar1[$i]
            ]);
        }*/

        $Baalbek = array (
          0 => 'Aadous',
          1 => 'Aallaq',
          2 => 'Aamchki',
          3 => 'Aarsal',
          4 => 'Aayoun Orghoush',
          5 => 'Ain Bourday',
          6 => 'Ain Ej Jaouze',
          7 => 'Ain El Bnaiye',
          8 => 'Ain es Saouda',
          9 => 'Ainata',
          10 => 'Al Ansar Baalbek',
          11 => 'Baalbek',
          12 => 'Baayoun',
          13 => 'Barqa',
          14 => 'Bechouat',
          15 => 'Bednayel',
          16 => 'Beit Chama',
          17 => 'Beit es Satiti',
          18 => 'Beit Habchi',
          19 => 'Beit Mchik',
          20 => 'Bejjaje',
          21 => 'Betdaai',
          22 => 'Blaiqa',
          23 => 'Boudai',
          24 => 'Britel',
          25 => 'Bsayleh al Fawka',
          26 => 'Bsayleh al Tahta',
          27 => 'Chaat',
          28 => 'Chlifa',
          29 => 'Chmistar',
          30 => 'Daouret en Naml',
          31 => 'Dar el Ouassaa',
          32 => 'Deir El Ahmar',
          33 => 'Deir Mar Maroun Baalbek',
          34 => 'Douris',
          35 => 'El Aaiara',
          36 => 'El Ain',
          37 => 'El Barake',
          38 => 'El Faqrat',
          39 => 'El Laouze',
          40 => 'El Maalqa',
          41 => 'El Marmagha',
          42 => 'El Qaa',
          43 => 'El Qerrami',
          44 => 'En Nouqra',
          45 => 'Fakehe',
          46 => 'Flaoui',
          47 => 'Freij',
          48 => 'Hadet Hermel',
          49 => 'Hai el Mathane',
          50 => 'Halbata',
          51 => 'Ham',
          52 => 'Haouch Barada',
          53 => 'Haouch Ed Dahab',
          54 => 'Haouch En Nabi',
          55 => 'Haouch Snaid',
          56 => 'Haouch Tall Safiye',
          57 => 'Haouerte',
          58 => 'Haour Taala',
          59 => 'Harabta',
          60 => 'Harfouch',
          61 => 'Hfayer',
          62 => 'Hizzine',
          63 => 'Hosn ech Chadoura',
          64 => 'Houch Er Rafqa',
          65 => 'Iaat',
          66 => 'Jabaa',
          67 => 'Jabal Ech Chaaibe',
          68 => 'Jabboule',
          69 => 'Janta',
          70 => 'Jdaide Fekehe',
          71 => 'Joubaniyeh',
          72 => 'Kfar Dabach',
          73 => 'Kfar Dane',
          74 => 'Kharayeb',
          75 => 'Khermateh',
          76 => 'Khirbet Daoud Baalbek',
          77 => 'Khirbet et Tine',
          78 => 'Khirbet Haouerte',
          79 => 'Khirbet Younine',
          80 => 'Khodor',
          81 => 'Khraibe',
          82 => 'Knaisse',
          83 => 'Laboue',
          84 => 'Maarboun',
          85 => 'Mahatta',
          86 => 'Majdaloun',
          87 => 'Maql el Bouadte',
          88 => 'Maqne',
          89 => 'Masnaa',
          90 => 'Masnaa es Zohr',
          91 => 'Mathanet Mousrayeh',
          92 => 'Mazraat al Ramassy',
          93 => 'Mazraat Al Souaydane',
          94 => 'Mazraat al Takch',
          95 => 'Mazraat Beit el Ghoussain',
          96 => 'Mazraat Beit Slaibi',
          97 => 'Mazraat Ed Dallil',
          98 => 'Mazraat ed Dhour',
          99 => 'Mazraat Es Saiyed',
          100 => 'Mazraat Matar',
          101 => 'Mazraat Oumm Aali',
          102 => 'Mchaitiye',
          103 => 'Mehairfe',
          104 => 'Mhattat Ras Baalbeck',
          105 => 'Mkaybel Al Kala',
          106 => 'Moqraq',
          107 => 'Mrah Beit Aassaf',
          108 => 'Mrah Beit el Qazah',
          109 => 'Mrah Beit Slim',
          110 => 'Mrah Bou Brahim',
          111 => 'Mrah Bou Chahine',
          112 => 'Mrah ech Chmis',
          113 => 'Mrah ech Choaab',
          114 => 'Mrah ej Jamal',
          115 => 'Mrah ej Jeddaoui',
          116 => 'Mrah El Aabed',
          117 => 'Mrah El Aaouja',
          118 => 'Mrah El Aassi',
          119 => 'Mrah el Ahmar',
          120 => 'Mrah el Blata',
          121 => 'Mrah EL Harfouch',
          122 => 'Mrah es Sirghane',
          123 => 'Mrah Haissoun',
          124 => 'Mrah Kloude',
          125 => 'Mrah Najib',
          126 => 'Mrah Rafi',
          127 => 'Mrah Semaan',
          128 => 'Mrah Soukkar',
          129 => 'Nabha',
          130 => 'Nabha Al Mohfara',
          131 => 'Nabi Chit',
          132 => 'Nabi Osmane',
          133 => 'Nabi Rachade',
          134 => 'Nabi Sbat',
          135 => 'Nahle',
          136 => 'Qaa Jouar Maqiyeh',
          137 => 'Qaa Ouadi el Khanzir',
          138 => 'Qalaat Bakdach',
          139 => 'Qalb es Sabaa',
          140 => 'Qarha',
          141 => 'Qiddam',
          142 => 'Qlaile',
          143 => 'Qsarnaba',
          144 => 'Ram',
          145 => 'Ras al Assy',
          146 => 'Ras Baalbek',
          147 => 'Ras Baalbek ech Charqi',
          148 => 'Ras Baalbek es Sahel',
          149 => 'Rasm El Hadet',
          150 => 'Riha',
          151 => 'Saaide',
          152 => 'Safra',
          153 => 'Saidet ed Dalil',
          154 => 'Saraain el Faouqa',
          155 => 'Saraain et Tahta',
          156 => 'Sbouba',
          157 => 'Sifri',
          158 => 'Siret Hanna',
          159 => 'Slouqi',
          160 => 'Taibe Baalbek',
          161 => 'Talia',
          162 => 'Tall Sougha',
          163 => 'Tallet ed Deir',
          164 => 'Tammine et Tahta',
          165 => 'Tamnine El Faouqa',
          166 => 'Taraiya',
          167 => 'Tfail',
          168 => 'Toufiqiye',
          169 => 'Wadi el Assouad',
          170 => 'Wadi el Oss',
          171 => 'Yahfoufa',
          172 => 'Yammoune',
          173 => 'Younine',
          174 => 'Zabboud',
          175 => 'Zarayeb',
          176 => 'Zarayeb Choukr',
          177 => 'Zeribet es Sabha',
          178 => 'Zrazir',
        );

        $Baalbek1 = array (
              0 => 'عدّوس',
              1 => 'علاق',
              2 => 'عمشكي',
              3 => 'عرسال',
              4 => 'عيون ارغش',
              5 => 'عين بورداي',
              6 => 'عين الجوزة',
              7 => 'عين البنية',
              8 => 'عين السودا',
              9 => 'عيناتا',
              10 => 'الأنصار بعلبك',
              11 => 'بعلبك',
              12 => 'قاع بعيون',
              13 => 'برقا',
              14 => 'بشوات',
              15 => 'بدنايل',
              16 => 'بيت شاما',
              17 => 'بيت الستيته',
              18 => 'بيت حبشي',
              19 => 'مزرعة بيت مشيك',
              20 => 'بجاجة',
              21 => 'بتدعي',
              22 => 'بليقة',
              23 => 'بوداي',
              24 => 'بريتال',
              25 => 'بصيلة الفوقا',
              26 => 'بصيلة التحتا',
              27 => 'شعت',
              28 => 'شليفا',
              29 => 'شمسطار',
              30 => 'دورة النمل',
              31 => 'دار الواسعة',
              32 => 'دير الاحمر',
              33 => 'دير مار مارون بعلبك',
              34 => 'دوريس',
              35 => 'عيارة',
              36 => 'العين',
              37 => 'البركة',
              38 => 'فقرات',
              39 => 'اللوزة',
              40 => 'معلقة الجديدة',
              41 => 'مرماغا',
              42 => 'القاع',
              43 => 'قرامي',
              44 => 'نقرة',
              45 => 'فاكهة',
              46 => 'فلاوي',
              47 => 'فريج',
              48 => 'حدت الهرمل',
              49 => 'حي المطحنة',
              50 => 'حلباتا',
              51 => 'حام',
              52 => 'حوش بردى',
              53 => 'حوش الدهب',
              54 => 'حوش النبي',
              55 => 'حوش سنيد',
              56 => 'حوش تل صفية',
              57 => 'حوارته',
              58 => 'حور تعلا',
              59 => 'حربتا',
              60 => 'حرفوش',
              61 => 'حفاير',
              62 => 'حزين',
              63 => 'حصن الشادورا',
              64 => 'حوش الرافقة',
              65 => 'ايعات',
              66 => 'جبعا',
              67 => 'جبل الشعيبة',
              68 => 'جبولة',
              69 => 'جنتا',
              70 => 'جديدة الفاكهة',
              71 => 'جوبانية',
              72 => 'كفر دبش',
              73 => 'كفر دان',
              74 => 'الخرائب',
              75 => 'خورماتا',
              76 => 'خربة داوود بعلبك',
              77 => 'خربة التينه',
              78 => 'خربة حوارته',
              79 => 'خربة يونين',
              80 => 'خضر',
              81 => 'خريبة',
              82 => 'كنيسة',
              83 => 'لبوة',
              84 => 'معربون',
              85 => 'المحطة',
              86 => 'مجدلون',
              87 => 'مقل البوادتي',
              88 => 'مقنة',
              89 => 'المصنع',
              90 => 'مصنع الزهر',
              91 => 'مطحنة مصراية',
              92 => 'مزرعة الرماسا',
              93 => 'مزرعة آل سويدان',
              94 => 'مزرعة بيت طقش',
              95 => 'مزرعة بيت الغصين',
              96 => 'مزرعة بيت صليبي',
              97 => 'مزرعة الضليل',
              98 => 'مزرعة الضهور',
              99 => 'مزرعة السيد',
              100 => 'مزرعة مطر',
              101 => 'مزرعة ام علي',
              102 => 'مشيتية',
              103 => 'محيرفة',
              104 => 'المحطة راس بعلبك',
              105 => 'مقيال القلعة',
              106 => 'المقرق',
              107 => 'مراح بيت عساف',
              108 => 'مراح بيت القزح',
              109 => 'مراح بيت سليم',
              110 => 'مراح بو براهيم',
              111 => 'مراح بو شاهين',
              112 => 'مراح الشميس',
              113 => 'مراح الشعاب',
              114 => 'مراح',
              115 => 'مراح الجداوي',
              116 => 'مراه العبد',
              117 => 'مراح العوجا',
              118 => 'مراح العاصي',
              119 => 'مراح الاحمر',
              120 => 'مراح البلاطة',
              121 => 'مراح الحرفوش',
              122 => 'مراح السرغانه',
              123 => 'مراح حيصون',
              124 => 'مراح القلود',
              125 => 'مراح نجيب',
              126 => 'مراح رافي',
              127 => 'مراح سمعان',
              128 => 'مراح سكر',
              129 => 'نبحا',
              130 => 'نبحا المحفارة',
              131 => 'نبي شيت',
              132 => 'نبي عثمان',
              133 => 'نبي رشاده',
              134 => 'النبي سباط',
              135 => 'نحله',
              136 => 'قاع جوار مكية',
              137 => 'قاع وادي الخنزير',
              138 => 'قلعة بكداش',
              139 => 'مزرعة قلد السبع',
              140 => 'قرحا',
              141 => 'القدام',
              142 => 'قليلة',
              143 => 'قصرنابا',
              144 => 'الرام',
              145 => 'راس العاصي',
              146 => 'راس بعلبك',
              147 => 'راس بعلبك الشرقي',
              148 => 'راس بعلبك السهل',
              149 => 'رسم الحدث',
              150 => 'ريحا',
              151 => 'سعيدة',
              152 => 'صفرا',
              153 => 'سيدة الضليل',
              154 => 'سرعين الفوقا',
              155 => 'سرعين التحتا',
              156 => 'صبوبا',
              157 => 'سفري',
              158 => 'سيرة هنا',
              159 => 'سلوقي',
              160 => 'طيبة بعلبك',
              161 => 'طليا',
              162 => 'تل سغى',
              163 => 'تلة الدير',
              164 => 'تمنين التحتا',
              165 => 'تمنين الفوقا',
              166 => 'طاريا',
              167 => 'طفيل',
              168 => 'التوفيقية',
              169 => 'وادي الاسود',
              170 => 'وادي القصص',
              171 => 'يحفوفا',
              172 => 'يمونة',
              173 => 'يونين',
              174 => 'زبود',
              175 => 'زرايب',
              176 => 'زرايب شكر',
              177 => 'زريبة الصبحا',
              178 => 'زرازير',
            );
        /*for ($i=0; $i < count($Baalbek) ; $i++) {
            Area::insert([
                'caza_id' => 6,
                'name' => $Baalbek[$i],
                'arabic' => $Baalbek1[$i]
            ]);
        }*/

        $El_Hermal = array (
              0 => 'Aaqabe',
              1 => 'Ain al Jadideh',
              2 => 'Ain el bayda',
              3 => 'Bdita',
              4 => 'Beit Aallam',
              5 => 'Beit Aallaou',
              6 => 'Beit es Semmaqa',
              7 => 'Beit Hira',
              8 => 'Berghoch',
              9 => 'Biyout Aawad',
              10 => 'Biyout el Ain',
              11 => 'Biyout el Hajj Hassan',
              12 => 'Biyout er Rouais',
              13 => 'Biyout es Souh',
              14 => 'Bou Sawaya',
              15 => 'Bouaida',
              16 => 'Boustane',
              17 => 'Breij',
              18 => 'Brissa',
              19 => 'Charbine',
              20 => 'Chouaghir',
              21 => 'Ed Daoura el hermel',
              22 => 'El Baaoul',
              23 => 'El Mdawesh',
              24 => 'El Ouaqf',
              25 => 'El Qraita',
              26 => 'Es Souaidiye',
              27 => 'Faara',
              28 => 'Fissane',
              29 => 'Haouch Es Saiyad Aali',
              30 => 'Haouchariye',
              31 => 'Haret El Maasser',
              32 => 'Hariqa el hermel',
              33 => 'Hawch Beit Ismail',
              34 => 'Hermel',
              35 => 'Hermel Jbab',
              36 => 'Hmaire',
              37 => 'Jawz',
              38 => 'Jisr el Aassi',
              39 => 'Jouar El Hachich',
              40 => 'Jouret el Mzar',
              41 => 'Kouakh',
              42 => 'Maaisr',
              43 => 'Mansoureh',
              44 => 'Marj Hine',
              45 => 'Mazraat Beit el Fqih',
              46 => 'Mazraat Beit Et Tachm',
              47 => 'Mazraat Et Talle',
              48 => 'Mnaira',
              49 => 'Mrah Aabbas',
              50 => 'Mrah Beit Aalaoui',
              51 => 'Mrah Bou Kamar al Dine',
              52 => 'Mrah Ech Chaab',
              53 => 'Mrah ech Charqi',
              54 => 'Mrah ech Chnain',
              55 => 'Mrah el Aaqabe',
              56 => 'Mrah El Ain',
              57 => 'Mrah el Arab',
              58 => 'Mrah El Dalil',
              59 => 'Mrah el Gharbi',
              60 => 'Mrah el Mahlise',
              61 => 'Mrah El Mouchref',
              62 => 'Mrah El Mougher',
              63 => 'Mrah el Qorne',
              64 => 'Mrah el Qraita',
              65 => 'Mrah es Siyaid',
              66 => 'Mrah esh Shmis',
              67 => 'Mrah Ez Zakbe',
              68 => 'Mrah Houssain Taane',
              69 => 'Mrah Naaouas',
              70 => 'Mrah Sejoud',
              71 => 'Mrah Yassine',
              72 => 'Nasriye',
              73 => 'Ouadi en Nayra',
              74 => 'Ouadi Er Ratle',
              75 => 'Ouadi et Tourkmane',
              76 => 'Qanafez',
              77 => 'Qasr',
              78 => 'Quadi el Karm',
              79 => 'Ras Baalbek el Gharbi',
              80 => 'Ras Baalbek Ouadi Faara',
              81 => 'Salhat El Ma',
              82 => 'Sharbine el Faouqa',
              83 => 'Souaisse',
              84 => 'Tall El far',
              85 => 'Wadi Bnit',
              86 => 'Wadi Faara',
              87 => 'Zighrine',
              88 => 'Zighrine Et Tahta',
              89 => 'Zouaitini Zighrine',
            );

        $El_Hermal1 = array (
          0 => 'عقبة',
          1 => 'عين الجديدة الهرمل',
          2 => 'عين البيضاء',
          3 => 'بديتا',
          4 => 'بيت علام',
          5 => 'بيت علاّو',
          6 => 'بيت السماقة',
          7 => 'بيت حيرا',
          8 => 'برغش',
          9 => 'بيوت عواد',
          10 => 'بيوت العين',
          11 => 'بيوت الحاج حسن',
          12 => 'بيوت الرويس',
          13 => 'بيوت السوح',
          14 => 'بو صوايا',
          15 => 'بويضة',
          16 => 'بستان',
          17 => 'البريج',
          18 => 'بريصا',
          19 => 'شربين',
          20 => 'شواغير',
          21 => 'الدورة الهرمل',
          22 => 'البعول',
          23 => 'مداوش',
          24 => 'الوقف',
          25 => 'قريتي',
          26 => 'سويدية',
          27 => 'فعرا',
          28 => 'فيسان',
          29 => 'حوش السيد علي',
          30 => 'هوشرية',
          31 => 'حارة المعاصر',
          32 => 'حريقة الهرمل',
          33 => 'حوش بيت اسماعيل',
          34 => 'هرمل',
          35 => 'هرمل جباب',
          36 => 'حميرة',
          37 => 'جوز',
          38 => 'جسر العاصي',
          39 => 'جوار الحشيش',
          40 => 'جورة المزار',
          41 => 'كواخ',
          42 => 'معيصرة',
          43 => 'منصورة',
          44 => 'مرجحين',
          45 => 'مزرعة بيت الفقيه',
          46 => 'مزرعة بيت الطشم',
          47 => 'مراح التلة',
          48 => 'منيرة',
          49 => 'مراح عباس',
          50 => 'مراح بيت علاو',
          51 => 'مراح بو قمر الدين',
          52 => 'مراح الشعاب الهرمل',
          53 => 'مراح الشرقي',
          54 => 'مراح شنين',
          55 => 'مراح العقبة',
          56 => 'مراح العين',
          57 => 'مراح العرب',
          58 => 'مراح الدليل',
          59 => 'مراح الغربي',
          60 => 'مراح المحليسة',
          61 => 'مراح المشرف',
          62 => 'مراح المغر',
          63 => 'مراح القرنة',
          64 => 'مراح القريتا',
          65 => 'مراح السياد',
          66 => 'مراح الشميس الهرمل',
          67 => 'مراح الزكبة',
          68 => 'مراح حسين طعان',
          69 => 'مراح النواس',
          70 => 'مراح سجد',
          71 => 'مراح ياسين',
          72 => 'ناصرية الهرمل',
          73 => 'وادي النيرة',
          74 => 'وادي الرطل',
          75 => 'وادي التركمان',
          76 => 'قنافذ',
          77 => 'القصر',
          78 => 'وادي الكرم',
          79 => 'راس بعلبك الغربي',
          80 => 'راس بعلبك وادي فعرا',
          81 => 'سهلات المي',
          82 => 'شربين الفوقا',
          83 => 'السويسة',
          84 => 'تل الفار',
          85 => 'وادي بنيت',
          86 => 'وادي فعرا',
          87 => 'زغرين',
          88 => 'زغرين التحتى',
          89 => 'الزويتينه زغرين',
        );

        /*for ($i=0; $i < count($El_Hermal) ; $i++) {
            if(isset($El_Hermal[$i])){
                Area::insert([
                    'caza_id' => 12,
                    'name' => $El_Hermal[$i],
                    'arabic' => $El_Hermal1[$i]
                ]);
            }
        }*/

        $Beirut = array (
              0 => 'Aadlyeh',
              1 => 'Achrafiye',
              2 => 'Ain El Tine',
              3 => 'Ain Mreisse',
              4 => 'Al Hikmat',
              5 => 'Bab Idriss',
              6 => 'Bachoura',
              7 => 'Basta Faouka',
              8 => 'Basta Tahta',
              9 => 'Beirut',
              10 => 'Beirut Central District',
              11 => 'Bourj Abi Haidar',
              12 => 'Champ de courses',
              13 => 'Corniche El Naher',
              14 => 'Dar Al Fatwa',
              15 => 'Ej Jeitaoui',
              16 => 'El Aamliye',
              17 => 'El Ghabe',
              18 => 'El Hamra',
              19 => 'El Horge',
              20 => 'El Majidiye Beirut',
              21 => 'El Manara',
              22 => 'El Wata',
              23 => 'El Zarif',
              24 => 'Fourn el Hayek',
              25 => 'Gemmayze',
              26 => 'Grand Serail',
              27 => 'Hotel Dieu',
              28 => 'Jamia',
              29 => 'Jisr',
              30 => 'Jounblat',
              31 => 'Khodr',
              32 => 'La Sagesse',
              33 => 'Malaab',
              34 => 'Manara',
              35 => 'Mar Elias',
              36 => 'Mar Maroun',
              37 => 'Mar Mitr',
              38 => 'Mar Mkhayel',
              39 => 'Mar Nqoula',
              40 => 'Marfaa',
              41 => 'Mazraa',
              42 => 'Medouar',
              43 => 'Minet el Hosn',
              44 => 'Moussaitbe',
              45 => 'Moustachfa er Roum',
              46 => 'Najmeh',
              47 => 'Nasra',
              48 => 'Palais De Justice',
              49 => 'Parc',
              50 => 'Patriarcat',
              51 => "Place de l'Etoile",
              52 => 'Qantari',
              53 => 'Qobaiyat',
              54 => 'Qoraitem',
              55 => 'Ramlet el Bayda',
              56 => 'Raoucheh',
              57 => 'Ras Beirut',
              58 => 'Ras El Nabaa',
              59 => 'Remeil',
              60 => 'Saife',
              61 => 'Sanayeh',
              62 => 'Sioufi',
              63 => 'Snoubra',
              64 => 'Tallet Druze',
              65 => 'Tallet el Khayat',
              66 => 'Tariq El Jdide',
              67 => 'Unesco',
              68 => 'Universite Americaine',
              69 => 'Universite St Joseph',
              70 => 'Zoqaq el Blat',
            );

        $Beirut1 = array (
              0 => 'العدلية',
              1 => 'الاشرفية',
              2 => 'عين التينة',
              3 => 'عين المريسه',
              4 => 'حكمة',
              5 => 'باب إدريس',
              6 => 'باشورة',
              7 => 'بسطا الفوقا',
              8 => 'بسطا التحتا',
              9 => 'بيروت',
              10 => 'وسط بيروت',
              11 => 'برج أبو حيدر',
              12 => 'ميدان سباق الخيل',
              13 => 'كورنيش النهر',
              14 => 'دارالفتوى',
              15 => 'جعيتاوي',
              16 => 'عاملية',
              17 => 'غابي',
              18 => 'حمرا',
              19 => 'حرش',
              20 => 'مجيدية (بيروت)',
              21 => 'منارة',
              22 => 'الوطى',
              23 => 'ظريف',
              24 => 'فرن الحايك',
              25 => 'جميزة',
              26 => 'سراي الكبير',
              27 => 'اوتيل ديو',
              28 => 'الجامعة',
              29 => 'جسر',
              30 => 'جنبلاط',
              31 => 'الخضر',
              32 => 'الحكمة',
              33 => 'ملعب',
              34 => 'المنارة',
              35 => 'مار الياس',
              36 => 'مار مارون',
              37 => 'مار متر',
              38 => 'مار مخايل',
              39 => 'مار نقولا',
              40 => 'مرفأ',
              41 => 'المزرعة',
              42 => 'مدور',
              43 => 'مينا الحصن',
              44 => 'مصيطبة',
              45 => 'مستشفى الروم',
              46 => 'النجمة',
              47 => 'الناصرة',
              48 => 'قصر العدل',
              49 => 'سباق الخيل',
              50 => 'بطركية',
              51 => 'ساحة النجمة',
              52 => 'قنطاري',
              53 => 'قبيات',
              54 => 'قريطم',
              55 => 'الرملة البيضا',
              56 => 'روشه',
              57 => 'راس بيروت',
              58 => 'راس النبع',
              59 => 'رميل',
              60 => 'صيفي',
              61 => 'الصنائع',
              62 => 'السيوفي',
              63 => 'صنوبره',
              64 => 'تلة الدروز',
              65 => 'تلة الخياط',
              66 => 'طريق الجديدة',
              67 => 'الاونسكو',
              68 => 'الجامعة الاميركية',
              69 => 'جامعة القديس يوسف',
              70 => 'زقاق البلاط',
            );

        /*for ($i=0; $i < count($Beirut) ; $i++) {
            if(isset($Beirut[$i])){
                Area::insert([
                    'caza_id' => 8,
                    'name' => $Beirut[$i],
                    'arabic' => $Beirut1[$i]
                ]);
            }
        }*/

        $Rachaya = array (
              0 => 'Aaiha',
              1 => 'Aaqbe',
              2 => 'Aaz el Aarab',
              3 => 'Ain Aarab',
              4 => 'Ain Aata',
              5 => 'Ain Hircha',
              6 => 'Aita el Foukhar',
              7 => 'Bakka',
              8 => 'Bakkifa',
              9 => 'Bayader el Aadas',
              10 => 'Beit Lahia',
              11 => 'Bire rachaya',
              12 => 'Dahr el Ahmar',
              13 => 'Deir el Aachayer',
              14 => 'El Faqaa',
              15 => 'En Nabi Safa',
              16 => 'Haloua',
              17 => 'Haouch El Qinnabeh',
              18 => 'Haret el Kaouasbe',
              19 => 'Jebb Farah',
              20 => 'Kaoukaba',
              21 => 'Kfar Danis',
              22 => 'Kfar Mechki',
              23 => 'Kfar Qouq',
              24 => 'Khirbet Rouha',
              25 => 'Majdal Balhis',
              26 => 'Marj es Simah',
              27 => 'Mazraat Aazzi',
              28 => 'Mazraat Ain Qeniye',
              29 => 'Mazraat Deir el Aachaiyer',
              30 => 'Mazraat el Qalioun',
              31 => 'Mazraat Jaafar',
              32 => 'Mazret Al Chmis',
              33 => 'Mdoukha',
              34 => 'Mhaidse',
              35 => 'Qnaabe',
              36 => 'Rachaiya',
              37 => 'Rafid',
              38 => 'Selsata Mazraat Dier el Aachayer',
              39 => 'Tannoura',
              40 => 'Yanta',
            );
        $Rachaya1 = array (
              0 => 'عيحا',
              1 => 'عقبة راشيّا',
              2 => 'عز العرب',
              3 => 'عين عرب',
              4 => 'عين عطا',
              5 => 'عين حرشة',
              6 => 'عيتا الفخار',
              7 => 'بكا',
              8 => 'بكيفا راشيا',
              9 => 'بيادر العدس',
              10 => 'بيت لهيا',
              11 => 'بيرة راشّيا',
              12 => 'ضهر الاحمر',
              13 => 'دير العشاير',
              14 => 'الفقعة',
              15 => 'نبي صفا',
              16 => 'حلوة',
              17 => 'حوش القنعبة',
              18 => 'حارة الكواسبة',
              19 => 'جب فرح',
              20 => 'كوكبا',
              21 => 'كفر دنيس',
              22 => 'كفر مشكي',
              23 => 'كفرقوق',
              24 => 'خربة روحا',
              25 => 'مجدل بلهيص',
              26 => 'مرج السماح',
              27 => 'مزرعة عزِي',
              28 => 'مزرعة عين قنية',
              29 => 'مزرعة دير العشاير',
              30 => 'مزرعة القليون',
              31 => 'مزرعة جعفر',
              32 => 'مزرعة الشميسة',
              33 => 'مدوخا',
              34 => 'محيدثه',
              35 => 'قنعبة',
              36 => 'راشيّا الوادي',
              37 => 'الرافد راشيا',
              38 => 'مزرعة سلساتا',
              39 => 'تنورة',
              40 => 'ينطا',
            );

        /*for ($i=0; $i < count($Rachaya) ; $i++) {
            if(isset($Rachaya[$i])){
                Area::insert([
                    'caza_id' => 22,
                    'name' => $Rachaya[$i],
                    'arabic' => $Rachaya1[$i]
                ]);
            }
        }*/

        $West_Bekka = array (
              0 => 'Aammiq',
              1 => 'Aana',
              2 => 'Ain et Tine West Bekaa',
              3 => 'Ain Zebde',
              4 => 'Aitanit',
              5 => 'Al-Wakf',
              6 => 'Baaloul',
              7 => 'Bab Maraa',
              8 => 'Chebreqiyet Aammiq',
              9 => 'Dakoue',
              10 => 'Deir Ain ej Jaouze',
              11 => 'Deir Tahnich',
              12 => 'El Jezire',
              13 => 'El Marj',
              14 => 'Ghazze',
              15 => 'Hammara',
              16 => 'Harime es Soughra',
              17 => 'Houch Aammiq',
              18 => 'Houch el Harime',
              19 => 'Houch es Saalouk',
              20 => 'Joub Jannine',
              21 => 'Kafraiya West Bekaa',
              22 => 'Kamed el Laouz',
              23 => 'Khiara',
              24 => 'Khiara el Aatiqa',
              25 => 'Khirbet Qanafar',
              26 => 'Lala',
              27 => 'Libbaya',
              28 => 'Loussia',
              29 => 'Machgara',
              30 => 'Mansoura',
              31 => 'Meidoun',
              32 => 'Nabaa el Khraizat',
              33 => 'Qaraoun',
              34 => 'Qillaya',
              35 => 'Raouda Istabl',
              36 => 'Saghbine',
              37 => 'Sohmor',
              38 => 'Souairi',
              39 => 'Soultan Yaaqoub Aradi',
              40 => 'Soultane Yaaqoub el Faouqa',
              41 => 'Soultane Yaaqoub el Tahta',
              42 => 'Tall ez Zaazeaa',
              43 => 'Tall Znoub',
              44 => 'Tall Znoub ej Jdide',
              45 => 'Yohmor West Bekaa',
              46 => 'Zellaya',
            );

        $West_Bekka1 = array (
              0 => 'عميق',
              1 => 'عانا',
              2 => 'عين التينة بقاع الغربي',
              3 => 'عين زبدة',
              4 => 'عيتنيت',
              5 => 'الوقف بقاع الغربي',
              6 => 'بعلول',
              7 => 'باب مارع',
              8 => ' شبرقية عميق',
              9 => 'دكوة',
              10 => 'دير عين الجوزة',
              11 => 'دير طحنيش',
              12 => 'الجزيرة',
              13 => 'المرج',
              14 => 'غزة',
              15 => 'حمارة',
              16 => 'حريمة الصغرى',
              17 => 'حوش عميق',
              18 => 'حوش الحريمة',
              19 => 'حوش السعلوك',
              20 => 'جب جنين',
              21 => 'كفريا بقاع الغربي',
              22 => 'كامد اللوز',
              23 => 'الخيارة',
              24 => 'خيارة العتيقة',
              25 => 'خربة قنافار',
              26 => 'لالا',
              27 => 'لبايا',
              28 => 'لوسيا',
              29 => 'مشغرة',
              30 => 'المنصورة',
              31 => 'ميدون',
              32 => 'نبع الخريزات',
              33 => 'القرعون',
              34 => 'قلايا',
              35 => 'روضة إسطبل',
              36 => 'صغبين',
              37 => 'سحمر',
              38 => 'صويري',
              39 => 'سلطان يعقوب أراضي',
              40 => 'سلطان يعقوب الفوقا',
              41 => 'سلطان يعقوب التحتا',
              42 => 'تل الزعزع',
              43 => 'تل زنوب',
              44 => 'تل زنوب جديدة',
              45 => 'يحمر بقاع الغربي',
              46 => 'زلايا',
            );

        /*for ($i=0; $i < count($West_Bekka) ; $i++) {
            if(isset($West_Bekka[$i])){
                Area::insert([
                    'caza_id' => 26,
                    'name' => $West_Bekka[$i],
                    'arabic' => $West_Bekka1[$i]
                ]);
            }
        }*/

        $Zahle = array (
              0 => 'Aali en Nahri',
              1 => 'Ablah',
              2 => 'Ain el Ghmiqa',
              3 => 'Ain Kfar Zabad',
              4 => 'Al Faour',
              5 => 'Anjar',
              6 => 'Bar Elias',
              7 => 'Bayyadat',
              8 => 'Berbara zahle',
              9 => 'Bouarej',
              10 => 'Chamssine',
              11 => 'Chebrqiyet Tabet',
              12 => 'Chtaura',
              13 => 'Dahr al Harf',
              14 => 'Dahr Blait',
              15 => 'Dahr es Souane',
              16 => 'Dalhamiye',
              17 => 'Deir el Ghazal',
              18 => 'Deir Zenoun',
              19 => 'Er Ramtaniye',
              20 => 'Es Sraij',
              21 => 'Fourzol',
              22 => 'Hakl Hammana',
              23 => 'Haouch ed Dibs',
              24 => 'Haouch el Mendara',
              25 => 'Haouch el Oumara Aradi',
              26 => 'Haouch el Sayade',
              27 => 'Haouch Moussa Anjar',
              28 => 'Haret el Fikani',
              29 => 'Hazerta',
              30 => 'Hechmech',
              31 => 'Houch El-Ghanam',
              32 => 'Houch ez Zaraane',
              33 => 'Houch Hala',
              34 => 'Jdita',
              35 => 'Jlala',
              36 => 'Karak Nouh',
              37 => 'Kfar Zabad',
              38 => 'Koussaya',
              39 => 'Ksara',
              40 => "MADINAT AL SINA'IYAT",
              41 => 'Majdel Anjar',
              42 => 'Mar Elias Zahle',
              43 => 'Masnaa Zahle',
              44 => 'Massa',
              45 => 'Mazraat el Mehqane',
              46 => 'Mazraat Zahle',
              47 => 'Meksi',
              48 => 'Mreijat',
              49 => 'Naassate',
              50 => 'Nabi Aila',
              51 => 'Nasriyet Rizq',
              52 => 'Nasriyet Zahle',
              53 => 'Niha zahle',
              54 => 'Ouadi ed Deloum',
              55 => 'Ouadi el Aarayech',
              56 => 'Qaa er Rim',
              57 => 'Qabb Elias',
              58 => 'Qarqoud',
              59 => 'Qeisser',
              60 => 'Qommol',
              61 => 'Raait',
              62 => 'Ras el Ain Zahle',
              63 => 'Rassiyeh',
              64 => 'Rayak',
              65 => 'Saadnayel',
              66 => 'Sahret el Qach',
              67 => 'Taalabaya',
              68 => 'Taanayel',
              69 => 'Tall el Akhdar',
              70 => 'Tcheflik Eddeh Haouch',
              71 => 'Tcheflik Qiqano',
              72 => 'Tell Chiha',
              73 => 'Tell el Aamara',
              74 => 'Terbol',
              75 => 'Touaite',
              76 => 'Zahle',
              77 => 'Zahle Mar Antonios',
              78 => 'Zahle Mar Gerges',
              79 => 'Zahle Saydet En Najat',
              80 => 'Zahle Aradi',
              81 => 'Zahle Maalaqa Aradi',
              82 => 'Zebdol',
            );

        $Zahle1 = array (
              0 => 'علي النهري',
              1 => 'ابلح',
              2 => 'عين الغميقة',
              3 => 'عين كفر زبد',
              4 => 'الفاعور',
              5 => 'عنجر',
              6 => 'بر الياس',
              7 => 'البياضة',
              8 => 'بربارة زحلة',
              9 => 'بوارج',
              10 => 'شمسين',
              11 => 'شبرقية تابت',
              12 => 'شتورا',
              13 => 'ضهر الحرف',
              14 => 'ضهر البلايط',
              15 => 'ضهر الصوان',
              16 => 'دلهميه',
              17 => 'دير الغزال',
              18 => 'دير زنون',
              19 => 'الرمطانية',
              20 => 'سريج',
              21 => 'فرزل',
              22 => 'حقل حمانا',
              23 => 'حوش الدبس',
              24 => 'حوش مندره',
              25 => 'زحلة حوش الامراء أراضي',
              26 => 'حوش الصيادي',
              27 => 'حوش موسى عنجر',
              28 => 'حارة الفيكاني',
              29 => 'حزرتا',
              30 => 'حشمش',
              31 => 'حوش الغنم',
              32 => 'حوش الزراعنة',
              33 => 'حوش حالا',
              34 => 'جديتا',
              35 => 'جلالا',
              36 => 'كرك نوح',
              37 => 'كفر زبد',
              38 => 'قوسايا',
              39 => 'كسارة',
              40 => 'مدينة الصناعية',
              41 => 'مجدل عنجر',
              42 => 'مار الياس زحلة',
              43 => 'المصنع زحلة',
              44 => 'مسا',
              45 => 'مزرعة المحقان',
              46 => 'مزرعة زحلة',
              47 => 'مكسة',
              48 => 'مريجات',
              49 => 'نعصات',
              50 => 'نبي ايلا',
              51 => 'ناصرية رزق',
              52 => 'ناصرية زحلة',
              53 => 'نيحا زحلة',
              54 => 'وادي الدلم',
              55 => 'وادي العرايش',
              56 => 'قاع الريم',
              57 => 'قب الياس',
              58 => 'قرقود',
              59 => 'قيصر',
              60 => 'قمّل',
              61 => 'رعيت',
              62 => 'راس العين زحلة',
              63 => 'الراسية',
              64 => 'رياق',
              65 => 'سعدنايل',
              66 => 'صحرة القش',
              67 => 'تعلبايا',
              68 => 'تعنايل',
              69 => 'تل الاخضر',
              70 => 'تشفلك اده حوش',
              71 => 'تشفلك قيقانو',
              72 => 'تل شيحا',
              73 => 'تل العمارة',
              74 => 'تربل',
              75 => 'تويتي',
              76 => 'زحلة',
              77 => 'زحلة مار أنطونيوس',
              78 => 'زحلة مار جرجس',
              79 => 'زحلة سيدة النجاة',
              80 => 'زحلة أراضي',
              81 => 'زحلة معلقة أراضي',
              82 => 'زبدل',
            );
        /*for ($i=0; $i < count($Zahle) ; $i++) {
            if(isset($Zahle[$i])){
                Area::insert([
                    'caza_id' => 27,
                    'name' => $Zahle[$i],
                    'arabic' => $Zahle1[$i]
                ]);
            }
        }*/


        $Bent_Jbeil = array (
          0 => 'Aainata',
          1 => 'Aaitaroun',
          2 => 'Aayta ej Jabal Zott',
          3 => 'Ain Ebel',
          4 => 'Aita Ech Chaab',
          5 => 'Beit Lif',
          6 => 'Beit Yahnoun',
          7 => 'Bent Jubail',
          8 => 'Bir es Sanassel',
          9 => 'Borj Qalaouiye',
          10 => 'Braachit',
          11 => 'Chaqra',
          12 => 'Debl Oummiya',
          13 => 'Deir Ntar',
          14 => 'Doubiye',
          15 => 'El Birke',
          16 => 'El Biyad',
          17 => 'Froun',
          18 => 'Ghandouriye Bent Jbeil',
          19 => 'Haddatha',
          20 => 'Hanine',
          21 => 'Hariss',
          22 => 'Hay el Jameaa',
          23 => 'Jmaijime',
          24 => 'Kafra Bent Jbeil',
          25 => 'Kfar Dounine',
          26 => 'Khirbit Silim',
          27 => 'Kounine',
          28 => 'Maroun er Ras',
          29 => 'Mazraat Aazze',
          30 => 'Qalaouiye',
          31 => 'Qaouzah',
          32 => 'Qatmoun',
          33 => 'Rachaf',
          34 => 'Ramiye',
          35 => 'Rmaich',
          36 => 'Safad el Battikh',
          37 => 'Salhani',
          38 => 'Soultaniye',
          39 => 'Sribbine',
          40 => 'Taire',
          41 => 'Tebnine',
          42 => 'Yaroun',
          43 => 'Yater',
        );

        $Bent_Jbeil1 = array (
          0 => 'عيناتا بنت جبيل',
          1 => 'عيترون',
          2 => 'عيتا الجبل الزط',
          3 => 'عين ابل',
          4 => 'عيتا الشعب',
          5 => 'بيت ليف',
          6 => 'بيت ياحون',
          7 => 'بنت جبيل',
          8 => 'بير السناسل',
          9 => 'برج قلويه',
          10 => 'برعشيت',
          11 => 'شقرا',
          12 => 'دبل امية',
          13 => 'دير نطار',
          14 => 'دوبية',
          15 => 'البركه بنت جبيل',
          16 => 'البياد',
          17 => 'فرون',
          18 => 'غندورية بنت جبيل',
          19 => 'حداثا',
          20 => 'حنين',
          21 => 'حاريص',
          22 => 'الجامع بنت جبيل',
          23 => 'جميجمة',
          24 => 'كفرا بنت جبيل',
          25 => 'كفر دونين',
          26 => 'خربة سلم',
          27 => 'كونين',
          28 => 'مارون الراس',
          29 => 'مزرعة عزه',
          30 => 'قلويه',
          31 => 'قوزح',
          32 => 'قطموم',
          33 => 'رشاف',
          34 => 'رامية بنت جبيل',
          35 => 'رميش',
          36 => 'صفد البطيخ',
          37 => 'الصلحاني',
          38 => 'سلطانية',
          39 => 'صربين',
          40 => 'طيري',
          41 => 'تبنين',
          42 => 'يارون',
          43 => 'ياطر',
        );

        /*for ($i=0; $i < count($Bent_Jbeil) ; $i++) {
            if(isset($Bent_Jbeil[$i])){
                Area::insert([
                    'caza_id' => 9,
                    'name' => $Bent_Jbeil[$i],
                    'arabic' => $Bent_Jbeil1[$i]
                ]);
            }
        }*/

        $El_Nabatieh = array (
              0 => 'Aabba',
              1 => 'Aadchit ech Chqif',
              2 => 'Aali et Taher',
              3 => 'Aarnoun',
              4 => 'Aazze',
              5 => 'Ain Qana',
              6 => 'Arab Salim',
              7 => 'Braiqaa',
              8 => 'Charqiye',
              9 => 'Choukine',
              10 => 'Deir ez Zahrani',
              11 => 'Doueir El Nabatieh',
              12 => 'El Aaqide',
              13 => 'El Bayad',
              14 => 'El Midane',
              15 => 'Es Serail',
              16 => 'Habbouch',
              17 => 'Hamra En-Nabattiyeh',
              18 => 'Harouf',
              19 => 'Hima Aarnoun',
              20 => 'Hmaile',
              21 => 'Houmine el Faouqa',
              22 => 'Houmine et Tahta',
              23 => 'Insar',
              24 => 'Jaouhariye',
              25 => 'Jarjouaa',
              26 => 'Jbaa El Nabatieh',
              27 => 'Jibchit',
              28 => 'Kafra',
              29 => 'Kfar Dajjal',
              30 => 'Kfar Fila',
              31 => 'Kfar Roummane',
              32 => 'Kfar Sir',
              33 => 'Kfar Tebnit',
              34 => 'Kfaroue',
              35 => 'Kfour El Nabatieh',
              36 => 'Maifadoun',
              37 => 'Manzleh',
              38 => 'Mazraat Ain Bou Souar',
              39 => 'Mazraat Bsafour',
              40 => 'Mazraat Chelbael',
              41 => 'Mazraat Dmoul',
              42 => 'Mazraat el Baiyad',
              43 => 'Mazraat el Khraibe',
              44 => 'Mazraat Kfar ej Jouz',
              45 => 'Mazraat Maqsam Aali et Taher',
              46 => 'Mazraat Qalaat Meis',
              47 => 'Nabatiye el Faouqa',
              48 => 'Nabatiye el Tahta',
              49 => 'Nmairiye',
              50 => 'Qaaqaait ej Jisr',
              51 => 'Qsaibe El Nabatieh',
              52 => 'Roumine',
              53 => 'Sarba El Nabatieh',
              54 => 'Sir el Gharbiye',
              55 => 'Toul',
              56 => 'Yohmor',
              57 => 'Zaoutar ech Charqiye',
              58 => 'Zaoutar el Gharbiye',
              59 => 'Zebdine El Nabatieh',
              60 => 'Zefta',
            );

        $El_Nabatieh1 = array (
              0 => 'عبا',
              1 => 'عدشيت الشقيف',
              2 => 'علي الطاهر',
              3 => 'أرنون',
              4 => 'عزه',
              5 => 'عين قانا',
              6 => 'عرب صاليم',
              7 => 'بريقع',
              8 => 'شرقية',
              9 => 'شوكين',
              10 => 'دير الزهراني',
              11 => 'الدوير النبطية',
              12 => 'عقيدة',
              13 => 'نبطية البياض',
              14 => 'الميدان',
              15 => 'السراي',
              16 => 'حبوش',
              17 => 'الحمرا النبطية',
              18 => 'حروف',
              19 => 'حمى أرنون',
              20 => 'حميلة',
              21 => 'حومين الفوقا',
              22 => 'حومين التحتا',
              23 => 'إنصار',
              24 => 'جوهرية',
              25 => 'جرجوع',
              26 => 'جباع النبطية',
              27 => 'جبشيت',
              28 => 'كفرا',
              29 => 'كفردجال',
              30 => 'كفرفيلا',
              31 => 'كفر رمان',
              32 => 'كفرصير',
              33 => 'كفر تبنيت',
              34 => 'كفروة أو بفروة',
              35 => 'الكفور النبطية',
              36 => 'ميفدون',
              37 => 'المنزلة',
              38 => 'مزرعة عين بوسوار',
              39 => 'مزرعة بصفُور',
              40 => 'مزرعة شلبعل',
              41 => 'مزرعة دمول',
              42 => 'مزرعة البياض',
              43 => 'مزرعة الخريبة',
              44 => 'مزرعة كفر جوز',
              45 => 'مزرعة علي الطاهر',
              46 => 'مزرعة قلعة ميس',
              47 => 'نبطية الفوقا',
              48 => 'نبطية التحتا',
              49 => 'نميرية',
              50 => 'قعقعية الجسر',
              51 => 'قصيبة النبطية',
              52 => 'رومين',
              53 => 'صربا النبطية',
              54 => 'صير الغربية',
              55 => 'تول',
              56 => 'يحمر',
              57 => 'زوطر الشرقية',
              58 => 'زوطر الغربية',
              59 => 'زبدين النبطية',
              60 => 'زفتا',
            );

        /*for ($i=0; $i < count($El_Nabatieh) ; $i++) {
            if(isset($El_Nabatieh[$i])){
                Area::insert([
                    'caza_id' => 16,
                    'name' => $El_Nabatieh[$i],
                    'arabic' => $El_Nabatieh1[$i]
                ]);
            }
        }*/

        $Hasbaya = array (
          0 => 'Abou Qamha',
          1 => 'Ain Jerfa',
          2 => 'Ain Qenya',
          3 => 'Ain Tanta',
          4 => 'Ayn et Tine',
          5 => 'Bathaniye',
          6 => 'Berghoz',
          7 => 'Chebaa',
          8 => 'Chouaia',
          9 => 'Dehayrjate',
          10 => 'Dellafi',
          11 => 'El Majidiye',
          12 => 'Fardis',
          13 => 'Fashkoul',
          14 => 'Halta Hasbaya',
          15 => 'Hasbaiya',
          16 => 'Hebbariye',
          17 => 'Kaoukaba Hasbaya',
          18 => 'Kfair',
          19 => 'Kfar Chouba',
          20 => 'Kfar Hamam',
          21 => 'Khallet el Ghazale',
          22 => 'Khalouat el Biyada',
          23 => 'Khalouat Hasbaya',
          24 => 'Khirbet ed Dwayr',
          25 => 'Khraibe Hasbaya',
          26 => 'Mari',
          27 => 'Marj Ez Zouhour Dnaibe',
          28 => 'Mazraat Qafoua',
          29 => 'Mazraat Ras el Baidar',
          30 => 'Mimes',
          31 => 'Ouazzani',
          32 => 'Rachaiya el Foukhar',
          33 => 'Slaiyeb',
          34 => 'Tallet el Qaaqour',
          35 => 'Zaghla',
        );

        $Hasbaya1 = array (
          0 => 'أبو قمحة',
          1 => 'عين جرفا',
          2 => 'عين قنيا',
          3 => 'عين تنتا حاصبيا',
          4 => 'عين التينة حاصبيا',
          5 => 'بيتسنيا',
          6 => 'برغز',
          7 => 'شبعا',
          8 => 'شويّا',
          9 => 'الدحيرجات',
          10 => 'دلافة',
          11 => 'مجيدية حاصبيا',
          12 => 'الفرديس',
          13 => 'فشكول',
          14 => 'حلتا حاصبيّا',
          15 => 'حاصبيّا',
          16 => 'هبّارية',
          17 => 'كوكبا حاصبيّا',
          18 => 'كفير الزيت',
          19 => 'كفر شوبا',
          20 => 'كفرحمام',
          21 => 'خلة الغزالة',
          22 => 'خلوات البياضة',
          23 => 'خلوات حاصبيّا',
          24 => 'خربة الدوير',
          25 => 'خريبة حاصبيّا',
          26 => 'ماري',
          27 => 'مرج الزهور الدنيبة',
          28 => 'مزرعة قفوى',
          29 => 'مزرعة راس البيدر',
          30 => 'ميمس',
          31 => 'وزاني',
          32 => 'راشيّا الفخار',
          33 => 'صلايب',
          34 => 'تلة القعقور',
          35 => 'زغلة',
        );

        /*for ($i=0; $i < count($Hasbaya) ; $i++) {
            if(isset($Hasbaya[$i])){
                Area::insert([
                    'caza_id' => 17,
                    'name' => $Hasbaya[$i],
                    'arabic' => $Hasbaya1[$i]
                ]);
            }
        }*/

        $Marjaayoun = array (
              0 => 'MAZRAAT ZAIYEH',
              1 => 'Aadaisse',
              2 => 'Aadchit el Qoussair',
              3 => 'Aalmane',
              4 => 'Aamra',
              5 => 'Aarab el Louaize',
              6 => 'Ain Aarab Marjaayoun',
              7 => 'Baiyouda',
              8 => 'Beni Haiyane',
              9 => 'Blat Marjaayoun',
              10 => 'Blida',
              11 => 'Borj El Mlouk',
              12 => 'Deir Mimas',
              13 => 'Deir Siriane',
              14 => 'Dibbine',
              15 => 'Houla',
              16 => 'Houra',
              17 => 'Ibl es Saqi',
              18 => 'Jlali el Ghozlane',
              19 => 'Kfar Kila',
              20 => 'Khiam',
              21 => 'Khirbe',
              22 => 'Maissate',
              23 => 'Majdel Silim',
              24 => 'Marjaayoun',
              25 => 'Markaba',
              26 => 'Mazraat Doumiat',
              27 => 'Mazraat ej Jreine',
              28 => 'Mazraat Sahsahiye',
              29 => 'Meiss ej Jabal',
              30 => 'Mhaibib',
              31 => 'Qabrikha',
              32 => 'Qalaat Doubai',
              33 => 'Qantara',
              34 => 'Qlaiaa',
              35 => 'Qsair',
              36 => 'Rabb et Talatine',
              37 => 'Sarda',
              38 => 'Serail',
              39 => 'Souane Marjaayoun',
              40 => 'Taibe Marjaayoun',
              41 => 'Tallouse',
              42 => 'Touline',
            );

        $Marjaayoun1 = array (
              0 => 'مزرعة زئية',
              1 => 'عديسة مرجعيون',
              2 => 'عدشيت القصير',
              3 => 'علمانة',
              4 => 'عمرة',
              5 => 'عرب اللويزة',
              6 => 'عين عرب مرجعيون',
              7 => 'بويضة مرجعيون',
              8 => 'بني حيان',
              9 => 'بلاط مرجعيون',
              10 => 'بليدا',
              11 => 'برج الملوك',
              12 => 'دير ميماس',
              13 => 'دير سريان',
              14 => 'دبين',
              15 => 'حولا',
              16 => 'حوره',
              17 => 'إبل السقي',
              18 => 'جلال الغزلان',
              19 => 'كفركيلا',
              20 => 'الخيام',
              21 => 'خربة برج الملوك',
              22 => 'الميسات',
              23 => 'مجدل سلم',
              24 => 'مرجعيون',
              25 => 'مركبا',
              26 => 'مزرعة دمياط',
              27 => 'مزرعة الجرين',
              28 => 'مزرعة السهسهية',
              29 => 'ميس الجبل',
              30 => 'محيبيب',
              31 => 'قبريخا',
              32 => 'قلعة دبي',
              33 => 'قنطرة',
              34 => 'قليعة',
              35 => 'قصير',
              36 => 'رب التلاتين',
              37 => 'مزرعة سردة',
              38 => 'سراي',
              39 => 'صوانة مرجعيون',
              40 => 'طيبة مرجعيون',
              41 => 'طلوسة',
              42 => 'تولين',
            );

        /*for ($i=0; $i < count($Marjaayoun) ; $i++) {
            if(isset($Marjaayoun[$i])){
                Area::insert([
                    'caza_id' => 21,
                    'name' => $Marjaayoun[$i],
                    'arabic' => $Marjaayoun1[$i]
                ]);
            }
        }*/

        $Aley = array (
              0 => 'Aabey',
              1 => 'Aaley ej Jdide',
              2 => 'Aamroussieh Choueifat',
              3 => 'Aaramoun',
              4 => 'Aazzouniye',
              5 => 'Ain Al Saydeh',
              6 => 'Ain Anoub',
              7 => 'Ain Dara',
              8 => 'Ain Drafil',
              9 => 'Ain ej Jdide',
              10 => 'Ain el Fraidis',
              11 => 'Ain el Halzoun',
              12 => 'Ain el Jaouze',
              13 => 'Ain el Marj',
              14 => 'Ain er Remmane',
              15 => 'Ain Hala',
              16 => 'Ain Ksour',
              17 => 'Ain Trez',
              18 => 'Ainab',
              19 => 'Aitat',
              20 => 'Aley',
              21 => 'Baaouerta',
              22 => 'Baissour',
              23 => 'Bchamoun',
              24 => 'Bdedoun',
              25 => 'Bedghane',
              26 => 'Bhamdoun ed Dayaa',
              27 => 'Bhamdoun el Mhatta',
              28 => 'Bhouara',
              29 => 'Bihat',
              30 => 'Bkhechtay',
              31 => 'Blaibel',
              32 => 'Bmahray',
              33 => 'Bmekkine',
              34 => 'Bnaiye',
              35 => 'Botros',
              36 => 'Bou Zraid',
              37 => 'Bou Zraide',
              38 => 'Bourdine',
              39 => 'Bsatine',
              40 => 'Bserrine',
              41 => 'Bsous',
              42 => 'Btalloun',
              43 => 'Btater',
              44 => 'Chamlikh',
              45 => 'Chanay',
              46 => 'Charoun',
              47 => 'Chartoun',
              48 => 'Chemlane',
              49 => 'Chqif Btalloun',
              50 => 'Dahr El Ouahch',
              51 => 'Daqqoun',
              52 => 'Deir Qoubil',
              53 => 'Dfoun',
              54 => 'Doueir er Remmane',
              55 => 'El Blat',
              56 => 'El Ftaihat',
              57 => 'El Ouata',
              58 => 'En Njassa',
              59 => 'Es Shwayfate',
              60 => 'Fsaqine',
              61 => 'Ghaboun',
              62 => 'Ghadir',
              63 => 'Habramoun',
              64 => 'Haret Chbib',
              65 => 'Haret el Mir',
              66 => 'Haret Salem',
              67 => 'Hay el Aarab',
              68 => 'Hay es Sellom',
              69 => 'Hay es Sindiane',
              70 => 'Homs Oua Hama',
              71 => 'Houmal',
              72 => 'Ighmid',
              73 => 'Jabal El Aarid',
              74 => 'Jisr el Qadi',
              75 => 'Kahale',
              76 => 'Kaifoun',
              77 => 'Kfar Aamaiy',
              78 => 'Kfar Matta',
              79 => 'Khalde',
              80 => 'Kliliye',
              81 => 'Maaroufiye',
              82 => 'Maasraiti',
              83 => 'Majdalaya',
              84 => 'Mansouriye bhamdoun',
              85 => 'Mantra',
              86 => 'Marj Chartoun',
              87 => 'Mazraat el Boueit',
              88 => 'Mazraat en Nahr',
              89 => 'Mechakhti',
              90 => 'Mechrefe',
              91 => 'Mejdel Baana',
              92 => 'Mounsa Aaley',
              93 => 'Mreijat Aley',
              94 => 'Oumara Choueifat',
              95 => 'Qabr Chamoun',
              96 => 'Qmatiye',
              97 => 'Qoubbe Choueifat',
              98 => 'Ram Bchamoun',
              99 => 'Ramliye',
              100 => 'Rechmaiya',
              101 => 'Rejme',
              102 => 'Remhala',
              103 => 'Rjoum',
              104 => 'Rouissat Sofar',
              105 => 'Rouisset en Naamane',
              106 => 'Sarahmoul',
              107 => 'Sibaal',
              108 => 'Sil',
              109 => 'Silfaya',
              110 => 'Sofar',
              111 => 'Souq el Gharb',
              112 => 'Taazniye',
              113 => 'Touayte Ain Dara',
              114 => 'Watiye',
              115 => 'Yinnar',
            );

        $Aley1 = array (
              0 => 'عبيه',
              1 => 'عاليه الجديدة',
              2 => 'عمروسية الشويفات',
              3 => 'عرمون',
              4 => 'العزونيه',
              5 => 'عين السيدة',
              6 => 'عين عنوب',
              7 => 'عين داره',
              8 => 'عين درافيل',
              9 => 'عين الجديدة',
              10 => 'عين الفريديس',
              11 => 'عين الحلزون',
              12 => 'عين الجوزه',
              13 => 'عين المرج',
              14 => 'عين الرمانة',
              15 => 'عين حالا',
              16 => 'عين كسور',
              17 => 'عين تراز',
              18 => 'عيناب',
              19 => 'عيتات',
              20 => 'عاليه',
              21 => 'بعورته',
              22 => 'بيصور',
              23 => 'بشامون',
              24 => 'بدادون',
              25 => 'بدغان',
              26 => 'بحمدون الضيعة',
              27 => 'بحمدون المحطة',
              28 => 'بحوارا',
              29 => 'بهات',
              30 => 'بخشتيه',
              31 => 'بليبل',
              32 => 'بمهريه',
              33 => 'بمكين',
              34 => 'البينه',
              35 => 'بطرس',
              36 => 'بو زريدة',
              37 => 'بو زريده',
              38 => 'بردين',
              39 => 'البساتين',
              40 => 'بسرين',
              41 => 'بسوس',
              42 => 'بطلون',
              43 => 'بتاتر',
              44 => 'شاملخ',
              45 => 'شانيه',
              46 => 'شارون',
              47 => 'شرتون',
              48 => 'شملان',
              49 => 'شقيف بطلون',
              50 => 'ضهر الوحش',
              51 => 'دقون',
              52 => 'دير قوبل',
              53 => 'دفون',
              54 => 'دوير الرمان',
              55 => 'بلاط سلفايا',
              56 => 'الفتيحات',
              57 => 'الوطا',
              58 => 'النجاصة',
              59 => 'الشويفات',
              60 => 'فساقين',
              61 => 'الغابون',
              62 => 'غادير',
              63 => 'حبرمون',
              64 => 'حارة شبيب',
              65 => 'حارة المير',
              66 => 'حارة سالم',
              67 => 'حي العرب',
              68 => 'حي السلم',
              69 => 'حي السنديانة',
              70 => 'حمص وحمى',
              71 => 'حومال',
              72 => 'اغميد',
              73 => 'جبل العريض',
              74 => 'جسر القاضي',
              75 => 'الكحاله',
              76 => 'كيفون',
              77 => 'كفرعميه',
              78 => 'كفرمتى',
              79 => 'خلدة',
              80 => 'كليلة',
              81 => 'معروفية',
              82 => 'معصريتي',
              83 => 'مجدليا',
              84 => 'منصورية بحمدون',
              85 => 'المنطرة',
              86 => 'مرج شرتون',
              87 => 'مزرعة البويت',
              88 => 'مزرعة النهر',
              89 => 'مشاقتي',
              90 => 'مشرفه',
              91 => 'مجدل بعنا',
              92 => 'المونسه عاليه',
              93 => 'مريجات عاليه',
              94 => 'الشويفات الامراء',
              95 => 'قبر شمون',
              96 => 'قماطية',
              97 => 'قبة الشويفات',
              98 => 'رام بشامون',
              99 => 'رملية',
              100 => 'رشميا',
              101 => 'رجمة',
              102 => 'رمحالا',
              103 => 'رجوم',
              104 => 'رويسات صوفر',
              105 => 'رويسة النعمان',
              106 => 'سرحمول',
              107 => 'سبعل',
              108 => 'سيل',
              109 => 'سلفايا',
              110 => 'صوفر',
              111 => 'سوق الغرب',
              112 => 'تعزانية',
              113 => 'تويته عين داره',
              114 => 'واطية',
              115 => 'ينار',
            );

        /*for ($i=0; $i < count($Aley) ; $i++) {
            if(isset($Aley[$i])){
                Area::insert([
                    'caza_id' => 4,
                    'name' => $Aley[$i],
                    'arabic' => $Aley1[$i]
                ]);
            }
        }*/


        $Baabda = array (
          0 => 'Aabadiye',
          1 => 'Aarbaniye',
          2 => 'Abbdiyeh al Jadideh',
          3 => 'Ain er Roummane',
          4 => 'Ain es Sihha',
          5 => 'Ain Mouaffaq',
          6 => 'Arayia',
          7 => 'Arsoun',
          8 => 'Baabda',
          9 => 'Baajour',
          10 => 'Baalchmay',
          11 => 'Baalchmay ej Jdide',
          12 => 'Bhala',
          13 => 'Bir el AAbed',
          14 => 'Bir Hassan',
          15 => 'Bmariam',
          16 => 'Borj el Brajne',
          17 => 'Boutchai',
          18 => 'Brazilia',
          19 => 'Bsaba &amp; Ouadi Dlab',
          20 => 'Btaaline',
          21 => 'Btebyat',
          22 => 'Btekhnay',
          23 => 'Bzebdine',
          24 => 'Chatila',
          25 => 'Chbaniye',
          26 => 'Chiayah',
          27 => 'Chmaissa',
          28 => 'Chouit',
          29 => 'Cite Sportive',
          30 => 'Dahr el Baidar',
          31 => 'Deir el Harf',
          32 => 'Deir Khouna',
          33 => 'Deir Mar Elias',
          34 => 'Deir Mar Youhanna',
          35 => 'Deir Saiya',
          36 => 'Dhour Al Aabaydiyeh',
          37 => 'Dlaibe',
          38 => 'El Baqle',
          39 => 'El Maadan',
          40 => 'El Marmah',
          41 => 'El Mdaoura',
          42 => 'El Ouzaai',
          43 => 'Er Rihaniye',
          44 => 'Er Rouais',
          45 => 'Es Sheime',
          46 => 'Et Tahouita',
          47 => 'Ez Zire',
          48 => 'Faiyadiye',
          49 => 'Falougha',
          50 => 'Fsakin',
          51 => 'Furn ech Chebak',
          52 => 'Ghobeire',
          53 => 'Hadet',
          54 => 'Hammana',
          55 => 'Haql Hassan',
          56 => 'Haret El Botm',
          57 => 'Haret el Mjadle',
          58 => 'Haret er Roum',
          59 => 'Haret es Set',
          60 => 'Haret Hamze',
          61 => 'Haret Hraik',
          62 => 'Hasbaiya el Metn',
          63 => 'Hazmiye',
          64 => 'Hlaliye',
          65 => 'Jamhour',
          66 => 'Jnah',
          67 => 'Jouar el Haouz',
          68 => 'Jouret Arsoun',
          69 => 'Kahlouniye',
          70 => 'Kfar Selouane',
          71 => 'Kfarchima',
          72 => 'Khalouat',
          73 => 'Khraibe Baabda',
          74 => 'Knisse',
          75 => 'Lailake',
          76 => 'Louaize',
          77 => 'Mar Taqla',
          78 => 'Mazzraat Maaissra',
          79 => 'Mdeyrej',
          80 => 'Merdache',
          81 => 'Mraije',
          82 => 'Mzayraa',
          83 => 'Ouadi Chahrour el Olia',
          84 => 'Ouadi Chahrour el Soufla',
          85 => 'Qalaa',
          86 => 'Qirtada',
          87 => 'Qornayel',
          88 => 'Qoubbeiaa',
          89 => 'Qraiye',
          90 => 'Qsaibe',
          91 => 'Qtale',
          92 => 'Ras el Harf',
          93 => 'Ras el Metn',
          94 => 'Rouaisset Salima',
          95 => 'Rouisset el Ballout',
          96 => 'Sabra',
          97 => 'Salima Baabda',
          98 => 'Saqi Ain el Hadath',
          99 => 'Sibnay',
          100 => 'Tahouitet el Ghadir',
          101 => 'Tarchich',
          102 => 'Warware',
          103 => 'Yarzeh',
          104 => 'Zandouqa',
          105 => 'Zouaitini',
        );

        $Baabda1 = array (
          0 => 'عبادية',
          1 => 'عربانية',
          2 => 'عبادية الجديدة',
          3 => 'عين الرمانة بعبدا',
          4 => 'عين الصحة',
          5 => 'عين موفق',
          6 => 'عاريا',
          7 => 'ارصون',
          8 => 'بعبدا',
          9 => 'بعجور',
          10 => 'بعلشميه',
          11 => 'بعلشميه الجديدة',
          12 => 'بحالا',
          13 => 'بئر العبد',
          14 => 'بئر حسن',
          15 => 'بمريم',
          16 => 'برج البراجنة',
          17 => 'بطشيه',
          18 => 'برازيليا',
          19 => 'بسابا وادي الدلب',
          20 => 'بتعلين',
          21 => 'بتبيات',
          22 => 'بتخناي',
          23 => 'بزبدين',
          24 => 'شاتيلا',
          25 => 'شبانية',
          26 => 'شياح',
          27 => 'شميسة',
          28 => 'شويت',
          29 => 'المدينة الرياضية',
          30 => 'ضهر البيدر',
          31 => 'دير الحرف',
          32 => 'دير خونة',
          33 => 'دير مار الياس',
          34 => 'دير مار يوحنا',
          35 => 'دير سيا',
          36 => 'ضهور العبادية',
          37 => 'دليبه',
          38 => 'بقلة',
          39 => 'المعادن',
          40 => 'مرمح',
          41 => 'مدورا',
          42 => 'اوزاعي',
          43 => 'ريحانية',
          44 => 'الرويس',
          45 => 'الشيمة',
          46 => 'التحويطة',
          47 => 'زيره',
          48 => 'فياضية',
          49 => 'فالوغا',
          50 => 'فساقين ترشيش',
          51 => 'فرن الشباك',
          52 => 'غبيري',
          53 => 'حدث',
          54 => 'حمانا',
          55 => 'حقل حسن',
          56 => 'حارة البطم',
          57 => 'حارة المجادلة',
          58 => 'حارة الروم',
          59 => 'حارة الست',
          60 => 'حارة حمزة',
          61 => 'حارة حريك',
          62 => 'حاصبيّا المتن',
          63 => 'حازمية',
          64 => 'هلالية',
          65 => 'جمهور',
          66 => 'جناح',
          67 => 'جوار الحوز',
          68 => 'جورة ارصون',
          69 => 'كحلونية',
          70 => 'كفرسلوان',
          71 => 'كفرشيما',
          72 => 'خلوات',
          73 => 'خريبة بعبدا',
          74 => 'كنيسة بعبدا',
          75 => 'ليلكي',
          76 => 'لويزة',
          77 => 'مار تقلا',
          78 => 'مزرعة المعيصرة',
          79 => 'مديرج',
          80 => 'مرداشة',
          81 => 'مريجة',
          82 => 'مزيرعة بعبدا',
          83 => 'وادي شحرور العليا',
          84 => 'وادي شحرور السفلى',
          85 => 'القلعة',
          86 => 'قرطادة',
          87 => 'قرنايل',
          88 => 'قبيع',
          89 => 'قرية',
          90 => 'قصيبة',
          91 => 'قتالة',
          92 => 'راس الحرف',
          93 => 'راس المتن',
          94 => 'رويسات صليما',
          95 => 'رويسة البلوط',
          96 => 'صبرا',
          97 => 'صليما بعبدا',
          98 => 'سقي عين الحدث',
          99 => 'سبنيه',
          100 => 'تحويطة الغدير',
          101 => 'ترشيش',
          102 => 'الوروار',
          103 => 'اليرزة',
          104 => 'زندوقة',
          105 => 'زويتينة',
        );

        /*for ($i=0; $i < count($Baabda) ; $i++) {
            if(isset($Baabda[$i])){
                Area::insert([
                    'caza_id' => 5,
                    'name' => $Baabda[$i],
                    'arabic' => $Baabda1[$i]
                ]);
            }
        }*/

        $Chouf = array (
              0 => 'Aalmane Ech Chouf',
              1 => 'Aammatour',
              2 => 'Aammiq chouf',
              3 => 'Aanout',
              4 => 'Aaqline',
              5 => 'Aatrine',
              6 => 'Aazibett tahta',
              7 => 'Ain Aazime',
              8 => 'Ain Bal',
              9 => 'Ain El Assad',
              10 => 'Ain el Haour',
              11 => 'Ain Ouzain',
              12 => 'Ain Qeni',
              13 => 'Ain Zhalta',
              14 => 'Almane ed Daiaa',
              15 => 'Baadarane',
              16 => 'Baal en Naame',
              17 => 'Baaqline',
              18 => 'Baasir',
              19 => 'Bachqiye',
              20 => 'Baiqoun',
              21 => 'Baqaoun',
              22 => 'Baqse',
              23 => 'Barja',
              24 => 'Barouk',
              25 => 'Bater',
              26 => 'Batloun',
              27 => 'Bchatfine',
              28 => 'Bchella Ech Chouf',
              29 => 'Beit ed Dine',
              30 => 'Benoeti',
              31 => 'Bire',
              32 => 'Bkechtine',
              33 => 'Bkifa',
              34 => 'Boqaata',
              35 => 'Borjein',
              36 => 'Boudine',
              37 => 'Boutme',
              38 => 'Bqaiaa',
              39 => 'Brih',
              40 => 'Bsaba',
              41 => 'Bsennay',
              42 => 'Bzina',
              43 => 'Chhim',
              44 => 'Chmaarine',
              45 => 'Chmis chouf',
              46 => 'Choualiq Deir El Qamar',
              47 => 'Chourit',
              48 => 'Dabche',
              49 => 'Dahr ech Chqif',
              50 => 'Dahr el Aaqline',
              51 => 'Dahr el Mghara',
              52 => 'Dalhoun',
              53 => 'Damour',
              54 => 'Daraiya',
              55 => 'Dawha',
              56 => 'Deir Baba',
              57 => 'Deir Dourite',
              58 => 'Deir El MKhales',
              59 => 'Deir el Qamar',
              60 => 'Deir er Rahbat',
              61 => 'Deir es Saide',
              62 => 'Deir Qouche',
              63 => 'Delghani',
              64 => 'Dhour Ain Al Haour',
              65 => 'Dibbiye',
              66 => 'Dmit',
              67 => 'Douair Ed Dibbiye',
              68 => 'Douair El Hara',
              69 => 'Ech Charbine',
              70 => 'Ed Dalhamiye',
              71 => 'Ej Jreid',
              72 => 'El Aaqbe joun',
              73 => 'El Battal',
              74 => 'El Kherbe',
              75 => 'El Khraibe',
              76 => 'El Meghraiqa',
              77 => 'El Msayed',
              78 => 'El Qateaa',
              79 => 'Eskandarouna',
              80 => 'Et Taamir',
              81 => 'Faouarat Jaafar',
              82 => 'Fraidiss',
              83 => 'Ghabet Jaafar',
              84 => 'Ghandouriye',
              85 => 'Gharife',
              86 => 'Haffet el Hajal',
              87 => 'Halioune el Faouqa',
              88 => 'Halioune et Tahta',
              89 => 'Hamra Ed Damour',
              90 => 'Hardouch',
              91 => 'Haret Aalmane',
              92 => 'Haret Baasir',
              93 => 'Haret Beit Madi',
              94 => 'Haret el Ouasta',
              95 => 'Haret en Naame',
              96 => 'Haret Jandal',
              97 => 'Hasrout',
              98 => 'Hjaijiye',
              99 => 'Jadra',
              100 => 'Jahliye',
              101 => 'Jall Bou Haidar',
              102 => 'Jamailiye',
              103 => 'Jbaa',
              104 => 'Jdaide chouf',
              105 => "Je'ayel",
              106 => 'Jiblaye',
              107 => 'Jiye',
              108 => 'Jlailiye',
              109 => 'Joun',
              110 => 'Kahlouniye chouf',
              111 => 'Ketermaya',
              112 => 'Kfar Faqoud',
              113 => 'Kfar Hai',
              114 => 'Kfar Hamal',
              115 => 'Kfar Him',
              116 => 'Kfar Nabrakh',
              117 => 'Kfar Niss',
              118 => 'Kfar Qatra',
              119 => 'Khalouat Jernaya',
              120 => 'Khiam Ed Damour',
              121 => 'Khirbet Dabach',
              122 => 'Khirbit Bisri',
              123 => 'Khraibe chouf',
              124 => 'Knisse chouf',
              125 => 'Lahbiye',
              126 => 'Maaniye',
              127 => 'Maaser Beit ed Dine',
              128 => 'Maasser ech Chouf',
              129 => 'Majdalouna',
              130 => 'Majdel el Meouch',
              131 => 'Maqsabe',
              132 => 'Mar Mikheyel Ed Damour',
              133 => 'Mar Taqla En Naame',
              134 => 'Marj Aali',
              135 => 'Marj Barja',
              136 => 'Marj Ketermaya',
              137 => 'Marjiat',
              138 => 'Marjiat Borjein',
              139 => 'Mazboud',
              140 => 'Mazmoura',
              141 => 'Mazraat ech Chouf',
              142 => 'Mazraat ed Dahr',
              143 => 'Mazraat ed Doueir',
              144 => 'Mazraat El Barghoutiye',
              145 => 'Mazraat er Rzaniye',
              146 => 'Mazraat ez Zaitounniyeh',
              147 => 'Mazraat Khafiche',
              148 => 'Mechref',
              149 => 'Mermata',
              150 => 'Mghaire',
              151 => 'Mghairiye Chouf',
              152 => 'Mouhtaqara',
              153 => 'Moukhtara',
              154 => 'Mristi',
              155 => 'Mtaile',
              156 => 'Mtairiyat',
              157 => 'Mtoulle',
              158 => 'Naame',
              159 => 'Nabaa es Safa',
              160 => 'Nabi Younos',
              161 => 'Niha',
              162 => 'Ouadi Abou Youssef',
              163 => 'Ouadi Bnahle',
              164 => 'Ouadi Deir Dourit',
              165 => 'Ouadi ed Deir',
              166 => 'Ouadi es Sitt',
              167 => 'Ouadi Ez Zeyni',
              168 => 'Ouarhaniye',
              169 => 'Qalaat el Hosn',
              170 => 'Qalaat En Nimiri',
              171 => 'Qassoube',
              172 => 'Qraiaa',
              173 => 'Quardaniye',
              174 => 'Ras Aalous',
              175 => 'Rmaile',
              176 => 'Saadiyat',
              177 => 'Sabouniye',
              178 => 'Sahl Ej Jiye',
              179 => 'Samqaniye',
              180 => 'Saraouniye',
              181 => 'Sibline',
              182 => 'Sirjbal',
              183 => 'Souane Bsaba',
              184 => 'Traile',
              185 => 'Zaarour',
              186 => 'Zaarouriye',
            );

        $Chouf1 = array (
              0 => 'علمان الشوف',
              1 => 'عمّاطور',
              2 => 'عميق الشوف',
              3 => 'عانوت',
              4 => 'عقلين',
              5 => 'عترين',
              6 => 'عزبيات التحتا',
              7 => 'عين عزيمة',
              8 => 'عينبال',
              9 => 'عين الاسد',
              10 => 'عين الحور',
              11 => 'عين وزين',
              12 => 'عين قني',
              13 => 'عين زحلتا',
              14 => 'علمان الضيعة',
              15 => 'بعدران',
              16 => 'بعل الناعمه',
              17 => 'بعقلين',
              18 => 'بعاصير',
              19 => 'باشقية',
              20 => 'بيقون',
              21 => 'بقعون',
              22 => 'بقسه',
              23 => 'برجا',
              24 => 'الباروك',
              25 => 'باتر',
              26 => 'بتلون',
              27 => 'بشتفين',
              28 => 'بشله الشوف',
              29 => 'بيت الدين',
              30 => 'بنواتي',
              31 => 'بيرة',
              32 => 'بكشتين',
              33 => 'بكيفا',
              34 => 'بقعاتا',
              35 => 'البرجين',
              36 => 'بودين',
              37 => 'بطمة',
              38 => 'بقيعة',
              39 => 'بريح',
              40 => 'بسابا',
              41 => 'بصّني',
              42 => 'بزينا',
              43 => 'شحيم',
              44 => 'شمعرين',
              45 => 'شميس',
              46 => 'شواليق دير القمر',
              47 => 'شوريت',
              48 => 'دبشه',
              49 => 'ضهر الشقيف',
              50 => 'ضهر عقلين',
              51 => 'ضهر المغارة',
              52 => 'دلهون',
              53 => 'الدامور',
              54 => 'داريا الشوف',
              55 => 'الدوحة',
              56 => 'دير بابا',
              57 => 'دير دوريت',
              58 => 'دير المخلص الشوف',
              59 => 'دير القمر',
              60 => 'دير الراهبات',
              61 => 'دير السيدة',
              62 => 'دير كوشه',
              63 => 'دلغاني',
              64 => 'ضهور عين الحور',
              65 => 'دبية',
              66 => 'دميت',
              67 => 'دوير الدبية',
              68 => 'دوير الحارة',
              69 => 'شربين',
              70 => 'دلهميه الدبيه',
              71 => 'جريد',
              72 => 'عقبة جون',
              73 => 'بطال',
              74 => 'الخربة الشوف',
              75 => 'خريبة بيرة الشوف',
              76 => 'مغريقا',
              77 => 'المصايد',
              78 => 'قتيعا',
              79 => 'إسكندرونة',
              80 => 'تعمير',
              81 => 'فوارة جعفر',
              82 => 'فريديس الشوف',
              83 => 'غابة جعفر',
              84 => 'غندورية',
              85 => 'غريفة',
              86 => 'حافة الحجل',
              87 => 'حليونة الفوقا',
              88 => 'حليونة التحتا',
              89 => 'حمرا الدامور',
              90 => 'حردوش',
              91 => 'حارة علمان',
              92 => 'حارة بعاصير',
              93 => 'حارة بيت ماضي',
              94 => 'حارة الواسطة',
              95 => 'حارة الناعمه',
              96 => 'حارة جندل',
              97 => 'حصروت',
              98 => 'حجاجية',
              99 => 'جدرا',
              100 => 'جاهلية',
              101 => 'جل بو حيدر',
              102 => 'جميلية',
              103 => 'جباع',
              104 => 'جديدة الشوف',
              105 => 'جعايل',
              106 => 'جبلايا',
              107 => 'جية',
              108 => 'جليلية',
              109 => 'جون',
              110 => 'كحلونية الشوف',
              111 => 'كترمايا',
              112 => 'كفرفاقود',
              113 => 'كفر حي',
              114 => 'كفر حمل',
              115 => 'كفرحيم',
              116 => 'كفرنبرخ',
              117 => 'كفرنيس',
              118 => 'كفرقطرة',
              119 => 'خلوات جرنايا',
              120 => 'خيام الدامور',
              121 => 'خربة دبش',
              122 => 'خربة بسري',
              123 => 'خريبة الشوف',
              124 => 'كنيسة الشوف',
              125 => 'لهبية',
              126 => 'معنيه',
              127 => 'معاصر بيت الدين',
              128 => 'معاصر الشوف',
              129 => 'مجدلونا',
              130 => 'مجدل المعوش',
              131 => 'مقصبة',
              132 => 'مار مخايل الدامور',
              133 => 'مار تقلا الناعمه',
              134 => 'مرج علي',
              135 => 'مرج برجا',
              136 => 'مرج كترمايا',
              137 => 'مرجيات',
              138 => 'برجين',
              139 => 'مزبود',
              140 => 'مزمورة',
              141 => 'مزرعة',
              142 => 'مزرعة الضهر',
              143 => 'مزرعة الدوير',
              144 => 'مزرعة البرغوتية',
              145 => 'مزرعة الرزَانية',
              146 => 'مزرعة الزيتونه',
              147 => 'مزرعة الخفيش',
              148 => 'مشرف',
              149 => 'مرماتا',
              150 => 'مغيره',
              151 => 'مغيرية الشوف',
              152 => 'محتقره',
              153 => 'مختارة',
              154 => 'مرستى',
              155 => 'مطيلة',
              156 => 'مطيرية',
              157 => 'مطله',
              158 => 'ناعمه',
              159 => 'نبع الصفا',
              160 => 'نبي يونس',
              161 => 'نيحا',
              162 => 'وادي ابو يوسف',
              163 => 'وادي بنحليه',
              164 => 'وادي دير دوريت',
              165 => 'وادي الدير',
              166 => 'وادي الست',
              167 => 'وادي الزينة',
              168 => 'ورهانية',
              169 => 'قلعة الحصن',
              170 => 'قلعة النمري',
              171 => 'قصوبة',
              172 => 'قريعة',
              173 => 'وردانيه',
              174 => 'راس علوس',
              175 => 'رميلة',
              176 => 'السعديات',
              177 => 'صابونية',
              178 => 'سهل الجية',
              179 => 'سمقانية',
              180 => 'سرعونية',
              181 => 'سبلين',
              182 => 'سرجبال',
              183 => 'صوانة بسابا',
              184 => 'تريله',
              185 => 'زعرور',
              186 => 'زعرورية',
            );

        /*for ($i=0; $i < count($Chouf) ; $i++) {
            if(isset($Chouf[$i])){
                Area::insert([
                    'caza_id' => 10,
                    'name' => $Chouf[$i],
                    'arabic' => $Chouf1[$i]
                ]);
            }
        }*/

        $El_Meten = array (
          0 => 'Aabdine',
          1 => 'Aafs',
          2 => 'Aairoun',
          3 => 'Aammariye',
          4 => 'Aaqbe Zalqa',
          5 => 'Aaraar',
          6 => 'Aatchane',
          7 => 'Abou Mizane',
          8 => 'Ain Aalaq',
          9 => 'Ain Aar',
          10 => 'Ain El Kharroube',
          11 => 'Ain El Qabou',
          12 => 'Ain el Qassis',
          13 => 'Ain el-Kach',
          14 => 'Ain Er Rihane el meten',
          15 => 'Ain Es Safsaf el meten',
          16 => 'Ain Es Sindiane',
          17 => 'Ain et Toufaha',
          18 => 'Ain Najm',
          19 => 'Ain Saade',
          20 => 'Ain Zaitoune',
          21 => 'Aintoura el meten',
          22 => 'Aiyoun',
          23 => 'Antelias',
          24 => 'Baabdat',
          25 => 'Baaqrif',
          26 => 'Balouaa',
          27 => 'Baouchriye',
          28 => 'Baskinta',
          29 => 'Bchellama',
          30 => 'Beit Chebab',
          31 => 'Beit El Koukko',
          32 => 'Beit Meri',
          33 => 'Belle Vue',
          34 => 'Beqaata En Nahr',
          35 => 'Bhannes',
          36 => 'Bhersaf',
          37 => 'Biaqout',
          38 => 'Bikfayia',
          39 => 'Bnabil',
          40 => 'Bolonia',
          41 => 'Borj Hammoud',
          42 => 'Bqennaya',
          43 => 'Broumana',
          44 => 'Bsalim',
          45 => 'Bsatine Ain Saade',
          46 => 'Bsifrine',
          47 => 'Bteghrine',
          48 => 'Chaouiye',
          49 => 'Chbouq',
          50 => 'Cherchar',
          51 => 'Cherin',
          52 => 'Chmis Antelias',
          53 => 'Chouaiya',
          54 => 'Choueir',
          55 => 'Dahr Broummana',
          56 => 'Dahr el Bacheq',
          57 => 'Dahr el Hossein',
          58 => 'Dahr Es Souane Meten',
          59 => 'Daoura',
          60 => 'Daychouniye',
          61 => 'Dbaiye',
          62 => 'Deir Chamra',
          63 => 'Deir el Qalaa',
          64 => 'Deir es Salib',
          65 => 'Deir Ma Yohanna El Khenchara',
          66 => 'Deir Mar Chaaya',
          67 => 'Deir Mar Jergos',
          68 => 'Deir Mar Simaane',
          69 => 'Deir Tamich',
          70 => 'Deir-er-Raai es Saleh',
          71 => 'Dekouane',
          72 => 'Delb',
          73 => 'Dhour Ech Choueir',
          74 => 'Dik El Mehdi',
          75 => 'Douar',
          76 => 'Ej Jouaniye',
          77 => 'El Borj El Khenchara',
          78 => 'El Braij Qornet Chahouane',
          79 => 'El Firdaous',
          80 => 'El Habach',
          81 => 'El Loueize',
          82 => 'El Machrah',
          83 => 'El Manazil',
          84 => 'El Qalaa',
          85 => 'El Qalaa Sin el fil',
          86 => 'En Naas',
          87 => 'En Nabaa',
          88 => 'Er Rabie',
          89 => 'Er Raouda',
          90 => 'Er Rouaisse',
          91 => 'Et Tabche',
          92 => 'Fanar',
          93 => 'Fanar ej Jdid',
          94 => 'Faouar',
          95 => 'Faouar el meten',
          96 => 'Fraike',
          97 => 'Ghabe',
          98 => 'Ghabet Bolonia',
          99 => 'Gharouch',
          100 => 'Hamlaya',
          101 => 'Haret el Bellane',
          102 => 'Haret el Cheikh',
          103 => 'Haret El Ghouarni',
          104 => 'Hbous',
          105 => 'Horch Tabet',
          106 => 'Jall Ed Dib',
          107 => 'Jdaide el Meten',
          108 => 'Jisr El Bacha',
          109 => 'Jouar',
          110 => 'Jouret El Ballout',
          111 => 'Kafra El Meten',
          112 => 'Kfar Aaqab',
          113 => 'Kfartay',
          114 => 'Khalle',
          115 => 'Khenchara',
          116 => 'Khirbit el Aadass',
          117 => 'Ksayfiyeh',
          118 => 'Machraa',
          119 => 'Majdel Tarchich',
          120 => 'Majzoub',
          121 => 'Makhadet Nahr el Kalb',
          122 => 'Mamboukh',
          123 => 'Mansouriye',
          124 => 'Mar Aabda el Mshammar',
          125 => 'Mar Boutrous Karm El- Tine',
          126 => 'Mar Mkhayel Bnabil',
          127 => 'Mar Mousa Ed Daouar',
          128 => 'Mar Roukoz',
          129 => 'Marj Baskinta',
          130 => 'Marjaba',
          131 => 'Masqa',
          132 => 'Mayasse',
          133 => 'Mazraat Beit Ech Chaar',
          134 => 'Mazraat Deir Aaoukar',
          135 => 'Mazraat El Hdaira',
          136 => 'Mazraat Yachoua',
          137 => 'Mchaymcheh',
          138 => 'Mcheikha',
          139 => 'Mezher',
          140 => 'Mhaydse',
          141 => 'Mkalless',
          142 => 'Montiverdi',
          143 => 'Mountazah',
          144 => 'Mrah Ghanem',
          145 => 'Mrouj',
          146 => 'Mtaileb',
          147 => 'Mtein',
          148 => 'Mzakke',
          149 => 'Nabay',
          150 => 'Naqqach',
          151 => 'Ouadi Chahine',
          152 => 'Ouadi ed Delb',
          153 => 'Ouadi El Amine',
          154 => 'Ouadi El Karm',
          155 => 'Ouata El Mrouj',
          156 => 'Qaaqour',
          157 => 'Qanat Bakich',
          158 => 'Qennabet Broummana',
          159 => 'Qennabet Salima',
          160 => 'Qnaitra El Meten',
          161 => 'Qornet Chahouane',
          162 => 'Qornet El Hamra',
          163 => 'Qottara Aintouret',
          164 => 'Raboue',
          165 => 'Ramie',
          166 => 'Raqayeq',
          167 => 'Ras el Jdaide',
          168 => 'Roumie',
          169 => 'Sabtiye',
          170 => 'Sad el Baouchriye',
          171 => 'Sannine',
          172 => 'Saqeit El Misk',
          173 => 'Sfaile',
          174 => 'sfaileh Bikfaya',
          175 => 'Sijn ej Jdid',
          176 => 'Sinn el Fil',
          177 => 'Tall ez Zaatar',
          178 => 'Wata Amaret Chalhoub',
          179 => 'Zaaitriye',
          180 => 'Zabbougha',
          181 => 'Zaghrine El Meten',
          182 => 'Zahriye El Meten',
          183 => 'Zalqa',
          184 => 'Zaraaoun',
          185 => 'Zikrit',
          186 => 'Zouk el Kharab',
        );

        $El_Meten1 = array (
          0 => 'عبدين نقاش',
          1 => 'عفص',
          2 => 'عيرون',
          3 => 'عمّارية',
          4 => 'عقبة الزلقا',
          5 => 'عرعار',
          6 => 'عطشانة',
          7 => 'أبو ميزان',
          8 => 'عين علق',
          9 => 'عين عار',
          10 => 'عين الخروبة',
          11 => 'عين القبو',
          12 => 'عين القسيس',
          13 => 'عين القش',
          14 => 'عين الريحان المتن',
          15 => 'عين الصفصاف المتن',
          16 => 'عين السنديانة',
          17 => 'عين التفاحة',
          18 => 'عين نجم',
          19 => 'عين سعادة',
          20 => 'عين الزيتونة',
          21 => 'عينطورة المتن',
          22 => 'عيون المتن',
          23 => 'انطلياس',
          24 => 'بعبدات',
          25 => 'بعقريف',
          26 => 'بالوع',
          27 => 'بوشرية',
          28 => 'بسكنتا',
          29 => 'بشلامة',
          30 => 'بيت شباب',
          31 => 'بيت الككو',
          32 => 'بيت مري',
          33 => 'بلّفو',
          34 => 'بقعاتا النهر',
          35 => 'بحنس',
          36 => 'بحرصاف',
          37 => 'بياقوت',
          38 => 'بكفيا',
          39 => 'بنابيل',
          40 => 'بولونيا',
          41 => 'برج حمّود',
          42 => 'بقنايا',
          43 => 'برمانا المتن',
          44 => 'بصاليم',
          45 => 'بساتين عين سعادة',
          46 => 'بسفرين',
          47 => 'بتغرين',
          48 => 'شاوية',
          49 => 'شبوق',
          50 => 'شرشار',
          51 => 'شرين',
          52 => 'شميس أنطلياس',
          53 => 'شويا',
          54 => 'شوير',
          55 => 'ضهر برمانا',
          56 => 'ضهر الباشق',
          57 => 'ضهر الحسين المتن',
          58 => 'ضهر الصوان المتن',
          59 => 'دورة',
          60 => 'ديشونية',
          61 => 'ضبية',
          62 => 'دير شمرا',
          63 => 'دير القلعة',
          64 => 'دير الصليب',
          65 => 'ديرمار يوحنا الخنشارة',
          66 => 'دير مار شعيا',
          67 => 'دير مار جرجس',
          68 => 'دير مار سمعان',
          69 => 'دير طاميش',
          70 => 'دير الراعي الصالح',
          71 => 'دكوانة',
          72 => 'دلب',
          73 => 'ضهور الشوير',
          74 => 'ديك المحدي',
          75 => 'دوار',
          76 => 'الجوانية',
          77 => 'برج الخنشارة',
          78 => 'بريج قرنة شهوان',
          79 => 'فردوس',
          80 => 'حباش',
          81 => 'لويزة نقاش',
          82 => 'مشرح',
          83 => 'منازل',
          84 => 'قلعة',
          85 => 'قلعة سن الفيل',
          86 => 'نعص',
          87 => 'النبعه',
          88 => 'رابيه',
          89 => 'روضة',
          90 => 'رويسة برمانا',
          91 => 'طبشة',
          92 => 'الفنار',
          93 => 'فنار الجديدة',
          94 => 'فوار',
          95 => 'فوار المتن',
          96 => 'فريكه',
          97 => 'غابة المسقى',
          98 => 'غابة بولونيا',
          99 => 'غاروش',
          100 => 'حملايا',
          101 => 'حارة البلان',
          102 => 'حارة الشيخ',
          103 => 'حارة الغوارني',
          104 => 'حبوس',
          105 => 'حرش تابت',
          106 => 'جل الديب',
          107 => 'جديدة المتن',
          108 => 'جسر الباشا',
          109 => 'جوار المتن',
          110 => 'جورة البلوط',
          111 => 'كفرا المتن',
          112 => 'كفرعقاب',
          113 => 'كفرتيه',
          114 => 'خلة المتين',
          115 => 'خنشارة',
          116 => 'خربة العدس',
          117 => 'قصيفية',
          118 => 'مشرع',
          119 => 'مجدل ترشيش',
          120 => 'مجذوب',
          121 => 'مخاضة نهر الكلب',
          122 => 'الممبوخ',
          123 => 'منصورية',
          124 => 'دير مار عبدا المشمر',
          125 => 'مار بطرس كرم التين',
          126 => 'مار مخايل بنابيل',
          127 => 'مار موسى الدوار',
          128 => 'مار روكز',
          129 => 'مرج بسكنتا',
          130 => 'مرجبا',
          131 => 'المسقى',
          132 => 'مياسة',
          133 => 'مزرعة بيت الشعّار',
          134 => 'مزرعة دير عوكر',
          135 => 'مزرعة الحضيرة',
          136 => 'مزرعة يشوع',
          137 => 'مشيمشة',
          138 => 'مشيخا',
          139 => 'مزهر',
          140 => 'محيدثة المتن',
          141 => 'مكلس',
          142 => 'منتفردي',
          143 => 'منتزه',
          144 => 'مراح غانم',
          145 => 'المروج',
          146 => 'مطيلب',
          147 => 'المتين',
          148 => 'مزكة',
          149 => 'نابيه',
          150 => 'نقاش',
          151 => 'وادي شاهين',
          152 => 'وادي الدلب',
          153 => 'وادي الامين',
          154 => 'وادي الكرم المتن',
          155 => 'وطى المروج',
          156 => 'القعقور',
          157 => 'قناة باكيش',
          158 => 'قنابة برمانا',
          159 => 'قنابة صليما',
          160 => 'قنيطرة المتن',
          161 => 'قرنة شهوان',
          162 => 'قرنة الحمرا',
          163 => 'قطارة عينطورة المتن',
          164 => 'ربوة',
          165 => 'رامية',
          166 => 'رقايق',
          167 => 'راس الجديدة',
          168 => 'روميه المتن',
          169 => 'سبتيه',
          170 => 'سد البوشرية',
          171 => 'صنين',
          172 => 'ساقية المسك',
          173 => 'سفيلة',
          174 => 'سفيلة بكفيا',
          175 => 'سجن الجديد',
          176 => 'سن الفيل',
          177 => 'تل الزعتر',
          178 => 'الوطى عمارة شلهوب',
          179 => 'زعيتريه',
          180 => 'زبوغا',
          181 => 'زغرين المتن',
          182 => 'زاهرية المتن',
          183 => 'الزلقا',
          184 => 'زرعون',
          185 => 'زكريت',
          186 => 'ذوق الخراب',
        );

        /*for ($i=0; $i < count($El_Meten) ; $i++) {
            if(isset($El_Meten[$i])){
                Area::insert([
                    'caza_id' => 14,
                    'name' => $El_Meten[$i],
                    'arabic' => $El_Meten1[$i]
                ]);
            }
        }*/

        $Jbeil = array (
          0 => 'Aabeidat',
          1 => 'Aaboud',
          2 => 'Aafs jbeil',
          3 => 'Aainat',
          4 => 'Aalita',
          5 => 'Aamchit',
          6 => 'Aannaya',
          7 => 'Aaouaini',
          8 => 'Aaqoura',
          9 => 'Aarab el Lahib',
          10 => 'Aarasta',
          11 => 'Aayoun el Aalaq',
          12 => 'Adonis',
          13 => 'Afqa',
          14 => 'Ain Bqechqoch',
          15 => 'Ain ed Deir',
          16 => 'Ain Ed Delbe Jbeil',
          17 => 'Ain el Ghouaibe',
          18 => 'Ain el Qadah',
          19 => 'Ain es Salib',
          20 => 'Ain Ghalboun',
          21 => 'Ain Jrain',
          22 => 'Ain Kfaa',
          23 => 'Almat ech Chemaliye',
          24 => 'Almat Ej Jnoubiye',
          25 => 'Aydamoun',
          26 => 'Baachta',
          27 => 'Balhoss',
          28 => 'Barbara',
          29 => 'Barij',
          30 => 'Bchelli',
          31 => 'Bechtelida',
          32 => 'Behdaidat',
          33 => 'Beit El Boume',
          34 => 'Beit Hbaq',
          35 => 'Bejje',
          36 => 'Bekhaaz',
          37 => 'Bekouane',
          38 => 'Bentaael',
          39 => 'Berket Hejoula',
          40 => 'Beziyoun',
          41 => 'Bhassis',
          42 => 'Bir El Hait',
          43 => 'Bkourkaz',
          44 => 'Blat',
          45 => 'Bmehrine',
          46 => 'Boaatara',
          47 => 'Bqarta',
          48 => 'Broqta',
          49 => 'Chaabiyat el Fawqa',
          50 => 'Chaloumas',
          51 => 'Chamat',
          52 => 'Charbine Mazraat Es Siyad',
          53 => 'Chekhnaya',
          54 => 'Chikhane',
          55 => 'Chmout',
          56 => 'Chouata',
          57 => 'Daouret Edde Jbayl',
          58 => 'Deir el Qattara',
          59 => 'Deir Mar Maroun',
          60 => 'Deir Mar Sarkis',
          61 => 'Dmalsa',
          62 => 'Douar Bou chahine',
          63 => 'Doueir',
          64 => 'Ed Darje',
          65 => 'Edde',
          66 => 'Ehmej',
          67 => 'El Aambra',
          68 => 'El Aarich',
          69 => 'El Barraniye',
          70 => 'El Bhayri',
          71 => 'El Biyade',
          72 => 'El Borj',
          73 => 'El Boustane',
          74 => 'El Houssoun',
          75 => 'El Hraifat',
          76 => 'El Marj Lassa',
          77 => 'El Mtolle',
          78 => 'El Owaynate',
          79 => 'El-Harf',
          80 => 'Ernaya',
          81 => 'Es Saqi',
          82 => 'Es Sare',
          83 => 'Fatre',
          84 => 'Ferhet',
          85 => 'Fghal',
          86 => 'Fidar',
          87 => 'Fidar el Faouqa',
          88 => 'Fidar Et Tahta',
          89 => 'Frat',
          90 => 'Ghabate',
          91 => 'Ghabline',
          92 => 'Ghalboun',
          93 => 'Gharfine',
          94 => 'Gharzouz',
          95 => 'Habboub',
          96 => 'Habil',
          97 => 'Halat',
          98 => 'Haqel',
          99 => 'Haqlet et Tine',
          100 => 'Hara Jbeil',
          101 => 'Harsha',
          102 => 'Hay El Aarbe',
          103 => 'Hay El Baalbakiye',
          104 => 'Hbalin',
          105 => 'Hedayne',
          106 => 'Heloue',
          107 => 'Hima Er Rehbane',
          108 => 'Hima Mar Maroun Aannaya',
          109 => 'Hjoula',
          110 => 'Hosn Aar',
          111 => 'Hosna',
          112 => 'Hosrayel',
          113 => 'Hourata',
          114 => 'Hrazmin',
          115 => 'Hsarat',
          116 => 'Jaj',
          117 => 'Janne',
          118 => 'Jbail',
          119 => 'Jdayel',
          120 => 'Jengel',
          121 => 'Jlaisse',
          122 => 'Jouret El Qattine',
          123 => 'Jrebta Jbeil',
          124 => 'Kafr',
          125 => 'Kelesh',
          126 => 'Kfar Chakha',
          127 => 'Kfar Chilli',
          128 => 'Kfar Hitta',
          129 => 'Kfar Kahli',
          130 => 'Kfar Kidda',
          131 => 'Kfar Mashoun',
          132 => 'Kfar Qaouass',
          133 => 'Kfar Sal',
          134 => 'Kfar Shabbouh',
          135 => 'Kfar Zbouna',
          136 => 'Kfarbaal',
          137 => 'Kfoun',
          138 => 'Khaab',
          139 => 'Khaabiya',
          140 => 'Kharbe',
          141 => 'Kour El Hooua',
          142 => 'Laqlouq',
          143 => 'Lassa',
          144 => 'Lehfed',
          145 => 'Maad',
          146 => 'Maaytiq',
          147 => 'Mahmarat Bejje',
          148 => 'Maifouq',
          149 => 'Majdel',
          150 => 'Malhoun',
          151 => 'Mar Meqna',
          152 => 'Marbaa',
          153 => 'Marj Mokhtara',
          154 => 'Mazraa Lassa',
          155 => 'Mazraat ej Jmaiyel',
          156 => 'Mazraat el Hajj Khalil',
          157 => 'Mazraat El Maadene',
          158 => 'Mazraat Es Siyad',
          159 => 'Mdamit',
          160 => 'Mechane',
          161 => 'Mechhellene',
          162 => 'MechMech Jbeil',
          163 => 'Meftah es Sellom',
          164 => 'Mestita',
          165 => 'Mghaira',
          166 => 'Mnaitra',
          167 => 'Monsef',
          168 => 'Mouftah el Mir',
          169 => 'Moukhada',
          170 => 'Mzarib',
          171 => 'Nabaa Tourzaiya',
          172 => 'Nahrh Ibrahim',
          173 => 'Naqour',
          174 => 'Ouata El Bane',
          175 => 'Ouata el bourj',
          176 => 'Ouata el Khirbe',
          177 => 'Qartaba',
          178 => 'Qartaboun',
          179 => 'Qass',
          180 => 'Qateaa',
          181 => 'Qattara',
          182 => 'Qehmez',
          183 => 'Qerqraiya',
          184 => 'Qeryaqous',
          185 => 'Ramiet el Hsoun',
          186 => 'Ramout',
          187 => 'Ras Osta',
          188 => 'Rihani',
          189 => 'Rouaiss',
          190 => 'Saqi Lassa',
          191 => 'Saqi Rechmaiya',
          192 => 'Saqiet ed Delb',
          193 => 'Saqiet el Khait',
          194 => 'Sariita',
          195 => 'Sbail',
          196 => 'Sebrine',
          197 => 'Serghol',
          198 => 'Sinnawr',
          199 => 'Sirine',
          200 => 'Slaiyeb Ghalboun',
          201 => 'Souane',
          202 => 'Souq el Firi',
          203 => 'Taht el Qalaa',
          204 => 'Talbita',
          205 => 'Tartij',
          206 => 'Tedmor',
          207 => 'Terouil',
          208 => 'Tourzaiya',
          209 => 'Wadi el Kalb',
          210 => 'Yanouh',
          211 => 'Zaayber',
          212 => 'Zebdine',
          213 => 'Zelhmaya',
          214 => 'Zmar',
        );

        $Jbeil1 = array (
          0 => 'عبيدات',
          1 => 'عبود',
          2 => 'عفص',
          3 => 'عينات',
          4 => 'عاليتا',
          5 => 'عمشيت',
          6 => 'عنَايا',
          7 => 'عويني',
          8 => 'عاقورة',
          9 => 'عرب اللهيب',
          10 => 'عرستا',
          11 => 'عيون العلاق',
          12 => 'ادونيس',
          13 => 'افقا',
          14 => 'عين بقشقش',
          15 => 'عين الدير',
          16 => 'عين الدلبة جبيل',
          17 => 'عين الغويبة',
          18 => 'عين القدح',
          19 => 'عين الصليب',
          20 => 'عين غلبون',
          21 => 'عين جرين',
          22 => 'عين كفاع',
          23 => 'علمات الشمالية',
          24 => 'علمات الجنوبية',
          25 => 'عيدامون',
          26 => 'بعشتا',
          27 => 'بلحص',
          28 => 'بربارة',
          29 => 'بريج',
          30 => 'بشلّلي',
          31 => 'بشتليدا',
          32 => 'بحديدات',
          33 => 'بيت البومة',
          34 => 'بيت حبّاق',
          35 => 'بجه',
          36 => 'بخعاز',
          37 => 'بكونا',
          38 => 'بنتاعل',
          39 => 'بركة حجولا',
          40 => 'بزيون',
          41 => 'بحسيس',
          42 => 'بير الهيت',
          43 => 'بكركز',
          44 => 'بلاط',
          45 => 'بمهرين',
          46 => 'بعتارا',
          47 => 'بقرتا',
          48 => 'برقتا',
          49 => 'شعبيات الفوقا',
          50 => 'شلوماس',
          51 => 'شامات',
          52 => 'شربين مزرعة السياد',
          53 => 'شخنايا',
          54 => 'شيخان',
          55 => 'شموت',
          56 => 'شواتا',
          57 => 'دورة إده جبيل',
          58 => 'دير القطارة',
          59 => 'دير مار مارون',
          60 => 'دير مار سركيس',
          61 => 'دملصا',
          62 => 'دوار بو شاهين',
          63 => 'الدوير',
          64 => 'درجه',
          65 => 'إده',
          66 => 'اهمج',
          67 => 'العمبرا',
          68 => 'عريش',
          69 => 'برانية',
          70 => 'بحيري',
          71 => 'البياضة جبيل',
          72 => 'برج',
          73 => 'بستان يانوح',
          74 => 'حصون',
          75 => 'الحريفات',
          76 => 'مرج لاسا',
          77 => 'مطله جبيل',
          78 => 'عوينات',
          79 => 'حرف قرطبون',
          80 => 'ارنايا',
          81 => 'سقي',
          82 => 'سار',
          83 => 'فتري',
          84 => 'فرحت',
          85 => 'فغال',
          86 => 'الفيدار',
          87 => 'فدار الفوقا',
          88 => 'فدار التحتا',
          89 => 'فرات',
          90 => 'غابات',
          91 => 'غبالين',
          92 => 'غلبون',
          93 => 'غرفين',
          94 => 'غرزوز',
          95 => 'حبوب',
          96 => 'هابيل',
          97 => 'حالات',
          98 => 'حقل',
          99 => 'حقلة التينة',
          100 => 'حارة',
          101 => 'هرشا',
          102 => 'حي العربي',
          103 => 'حي البعلبكية',
          104 => 'حبالين',
          105 => 'هدينة',
          106 => 'حلوة',
          107 => 'حمى الرهبان',
          108 => 'حمى مار مارون عنَايا',
          109 => 'حجولا',
          110 => 'حصن العر',
          111 => 'حصنا',
          112 => 'حصرايل',
          113 => 'حوراتا',
          114 => 'حرازمين',
          115 => 'حصارات',
          116 => 'جاج',
          117 => 'جنة',
          118 => 'جبيل',
          119 => 'جدايل',
          120 => 'جونجل',
          121 => 'جليسه',
          122 => 'جورة القطين',
          123 => 'جربتا جبيل',
          124 => 'كفر',
          125 => 'كلش',
          126 => 'كفر شخي',
          127 => 'كفر شلي',
          128 => 'كفر حتى',
          129 => 'كفر كخلة',
          130 => 'كفر كده',
          131 => 'كفر مسحون',
          132 => 'كفر قواص',
          133 => 'كفر سالا',
          134 => 'كفر شبوح',
          135 => 'كفرزبونا',
          136 => 'كفر بعال',
          137 => 'كفون',
          138 => 'خعب',
          139 => 'خاعبية',
          140 => 'خاربة جبيل',
          141 => 'كور الهوا',
          142 => 'اللقلوق',
          143 => 'لاسا',
          144 => 'لحفد',
          145 => 'معاد',
          146 => 'معيتيق',
          147 => 'محمرة بجّه',
          148 => 'ميفوق',
          149 => 'المجدل',
          150 => 'ملحون',
          151 => 'مار مقانة',
          152 => 'مربعه',
          153 => 'مرج مختارة',
          154 => 'مزرعة لاسا',
          155 => 'مزرعة الجميل',
          156 => 'مزرعة الحاج خليل',
          157 => 'مزرعة المعادن',
          158 => 'مزرعة السياد',
          159 => 'مداميت',
          160 => 'مشان',
          161 => 'مشحلان',
          162 => 'مشمش جبيل',
          163 => 'مفتاح السلم',
          164 => 'مستيتا',
          165 => 'مغيره',
          166 => 'منيطرة',
          167 => 'المنصف',
          168 => 'مفتاح المير',
          169 => 'مخاضة',
          170 => 'المزاريب',
          171 => 'نبع طورزيا',
          172 => 'نهر ابراهيم',
          173 => 'نقور',
          174 => 'وطى البان',
          175 => 'وطى البرج',
          176 => 'وطى الخربة',
          177 => 'قرطبا',
          178 => 'قرطبون',
          179 => 'القص',
          180 => 'القاطعة',
          181 => 'قطارة',
          182 => 'قهمز',
          183 => 'قرقريا',
          184 => 'قرياقس',
          185 => 'رامية الحصون',
          186 => 'الراموط',
          187 => 'راس اسطا',
          188 => 'ريحانة',
          189 => 'رويس',
          190 => 'سقي لاسا',
          191 => 'سقي رشميا',
          192 => 'ساقية الدلب',
          193 => 'ساقية الخيط',
          194 => 'سرعيتا',
          195 => 'سبايل',
          196 => 'سربين',
          197 => 'سرغل',
          198 => 'سنور',
          199 => 'سيران',
          200 => 'صلايب غلبون',
          201 => 'صوانة',
          202 => 'سوق الفارة',
          203 => 'تحت القلعة',
          204 => 'تلبيتا',
          205 => 'ترتج',
          206 => 'تدمر',
          207 => 'ترويل',
          208 => 'طورزيا',
          209 => 'وادي الكلب',
          210 => 'يانوح',
          211 => 'زعيبر',
          212 => 'زبدين',
          213 => 'زلحمايا',
          214 => 'زمار',
        );

        /*for ($i=0; $i < count($Jbeil) ; $i++) {
            if(isset($Jbeil[$i])){
                Area::insert([
                    'caza_id' => 18,
                    'name' => $Jbeil[$i],
                    'arabic' => $Jbeil1[$i]
                ]);
            }
        }*/

        $Kesrwane = array (
          0 => 'Aabri',
          1 => 'Aachqout',
          2 => 'Aafs kesrwane',
          3 => 'Aajaltoun',
          4 => 'Aarabe Ghosta',
          5 => 'Aaramoun Kesrwane',
          6 => 'Aayoun es Simane',
          7 => 'Aazrane',
          8 => 'Adonis Kesserwan',
          9 => 'Aghbe',
          10 => 'Ain Abaal',
          11 => 'Ain Ed Delbe',
          12 => 'Ain Ej Jorn',
          13 => 'Ain Er Rihane',
          14 => 'Ain Et Tannour',
          15 => 'Ain Jouaiya',
          16 => 'Aintoura',
          17 => 'Ayn Es Safra',
          18 => 'Bahhara',
          19 => 'Balloune',
          20 => 'Batha',
          21 => 'Bayader Fatqa',
          22 => 'Beit Eid',
          23 => 'Beit El Kreidi',
          24 => 'Beit Khachbou',
          25 => 'Beqaatet Aachqout',
          26 => 'Biqaatet Kannane',
          27 => 'Bizhel',
          28 => 'Bkirke',
          29 => 'Blat Mazraat Kfar Dibiane',
          30 => 'Bouar',
          31 => 'Bqaatouta',
          32 => 'Bqaq Ed Dine',
          33 => 'Broummana Kfar Dibian',
          34 => 'Bzoummar',
          35 => 'Chaab',
          36 => 'Chahtoul',
          37 => 'Chehhara',
          38 => 'Chnanaair',
          39 => 'Chouaya',
          40 => 'Chouene',
          41 => 'Christ Roi',
          42 => 'Daasse',
          43 => 'Dahr Badris',
          44 => 'Dahr el Qattine',
          45 => 'Daraaoun',
          46 => 'Darayia Kesrwane',
          47 => 'Dayr Saydet el Haqle',
          48 => 'Deir Baklouche',
          49 => 'Deir Hrach',
          50 => 'Deir Nisbey',
          51 => 'Deir Ram Bou Daqen',
          52 => 'Deir saydet Louaize',
          53 => 'Deir Ziraaya',
          54 => 'Delbta',
          55 => 'Deraali',
          56 => 'Dqarine',
          57 => 'Ech Chqif Bqaatouta',
          58 => 'Ed Dahr',
          59 => 'Ed Dahr Ghbale',
          60 => 'Ed Daoura Shaile',
          61 => 'Edma et Dafne',
          62 => 'Ej Jaayel',
          63 => 'El Aaqaybe Kesrouane',
          64 => 'El Aazra et el Aazr',
          65 => 'El Ghouabi',
          66 => 'El Hara Mairouba',
          67 => 'El Kharayeb',
          68 => 'El Kharayeb Dlebta',
          69 => 'El Maaden',
          70 => 'El Marji',
          71 => 'El Massiaf',
          72 => 'El Qacha',
          73 => 'El Qarqouf',
          74 => 'Es Salhiye Bezhel',
          75 => 'Es Shoum Kfar Debiane',
          76 => 'Es Slayekh',
          77 => 'Es Souhoum',
          78 => 'Esh Shahoute',
          79 => 'Et Tarouaa',
          80 => 'Ez Zaaytriye',
          81 => 'Faitroun',
          82 => 'Fanyoun',
          83 => 'Faqra',
          84 => 'Faraiya',
          85 => 'Fatqa',
          86 => 'Ftah Ech Chouha',
          87 => 'Ftahate',
          88 => 'Ghadir jounieh',
          89 => 'Ghadras',
          90 => 'Ghazir',
          91 => 'Ghbale',
          92 => 'Ghine',
          93 => 'Ghoshraiya',
          94 => 'Ghosta',
          95 => 'Hakl Er Raiyess',
          96 => 'Hamassiyat',
          97 => 'Haret El Mir Zouk Mkayel',
          98 => 'Haret Halane',
          99 => 'Haret Sakher',
          100 => 'Harharaya',
          101 => 'Hariqa',
          102 => 'Hariqa Chahtoul',
          103 => 'Harissa',
          104 => 'Hayata',
          105 => 'Hilane',
          106 => 'Hrajel',
          107 => 'Hsayn',
          108 => 'Jdaidet Ghazir',
          109 => 'Jitta',
          110 => 'Jouar El Baouechiq',
          111 => 'Jouar El Hachich chahtoul',
          112 => 'Jounieh',
          113 => 'Jounieh Kaslik',
          114 => 'Jouret Bedrane',
          115 => 'Jouret Ed Dardour',
          116 => 'Jouret Et Tormoss',
          117 => 'Jouret Mghad',
          118 => 'Kfar Hbab',
          119 => 'Kfar Jrif',
          120 => 'Kfardibiane',
          121 => 'Kfarshihham',
          122 => 'Kfaryassine',
          123 => 'Kfour',
          124 => 'Khalal',
          125 => 'Khdayra',
          126 => 'Ksayer',
          127 => 'Maamelteine',
          128 => 'Maarab',
          129 => 'Maaysra',
          130 => 'Mairouba',
          131 => 'Mar Nouhra',
          132 => 'Mashhat',
          133 => 'Mazzarat Er Ras',
          134 => 'Mchaa El Ftouh',
          135 => 'Mchaa Faraya',
          136 => 'Mchaa Kfar Dibian',
          137 => 'Mchati',
          138 => 'Mehqane el Mazloum',
          139 => 'Mghayer',
          140 => 'Mradiye',
          141 => 'Mrah El Mir',
          142 => 'Mreijet Kesserwan',
          143 => 'Nabaa el Mghara',
          144 => 'Nahr Ed Dahab',
          145 => 'Nahr El Hussein',
          146 => 'Nahr el Kalb',
          147 => 'Nammoura',
          148 => 'Nmoura',
          149 => 'Ouata Ej Jaouz',
          150 => 'Ouata el Laouz',
          151 => 'Ouata Nahr El Kelb',
          152 => 'Ouata Slam',
          153 => 'Qalaa Kfardibiane',
          154 => 'Qalaat Maarab',
          155 => 'Qarqara',
          156 => 'Qarqouf',
          157 => 'Qarsa',
          158 => 'Qattine',
          159 => 'Qlaiaat',
          160 => 'Qmayrze',
          161 => 'Qouwale',
          162 => 'Raashine',
          163 => 'Raifoun',
          164 => 'Ramiet Kfaryasin',
          165 => 'Rihane Kesrwane',
          166 => 'Safra kesrwane',
          167 => 'Sahel Aalma',
          168 => 'Saidet Bzoummar',
          169 => 'Sarba',
          170 => 'Shaile',
          171 => 'Sirje',
          172 => 'Snoubar',
          173 => 'Tabarja',
          174 => 'Talle',
          175 => 'Wata Tabriye',
          176 => 'Yahchouch',
          177 => 'Zaaitra',
          178 => 'Zayer',
          179 => 'Zeitoun',
          180 => 'Zleikat',
          181 => 'Zouk Mosbeh',
          182 => 'Zouq Mkayel',
        );

        $Kesrwane1 = array (
          0 => 'عبري',
          1 => 'عشقوت',
          2 => 'عفص كسروان',
          3 => 'عجلتون',
          4 => 'عربة غوسطا',
          5 => 'عرمون كسروان',
          6 => 'عيون السيمان',
          7 => 'عزرانة',
          8 => 'أدونيس كسروان',
          9 => 'إغبة',
          10 => 'عين ابعل',
          11 => 'عين الدلبة',
          12 => 'عين الجرن',
          13 => 'عين الريحان',
          14 => 'عين التنور',
          15 => 'عين جويا',
          16 => 'عينطورة',
          17 => 'عين الصفرا',
          18 => 'بحارة',
          19 => 'بلونة',
          20 => 'بطحا',
          21 => 'بيادر فتقا',
          22 => 'بيت عيد',
          23 => 'بيت كريدي',
          24 => 'بيت خشبو',
          25 => 'بقعاتة عشقوت',
          26 => 'بقعاتة كنعان',
          27 => 'بزحل',
          28 => 'بكركي',
          29 => 'بلاط كفر ذبيان',
          30 => 'بوار',
          31 => 'بقعتوتا',
          32 => 'بقاق الدين',
          33 => 'برمانا كفر ذبيان',
          34 => 'بزمار',
          35 => 'شعب',
          36 => 'شحتول',
          37 => 'شحارة',
          38 => 'شننعير',
          39 => 'شويا يحشوش',
          40 => 'شوان',
          41 => 'يسوع الملك',
          42 => 'دعسه',
          43 => 'ضهر بدريس',
          44 => 'ضهر القطين',
          45 => 'درعون',
          46 => 'داريا كسروان',
          47 => 'دير سيدة الحقلة',
          48 => 'دير بقلوش',
          49 => 'دير حراش',
          50 => 'دير نسبيه',
          51 => 'دير رام بو دقن',
          52 => 'دير سيدة اللويزة',
          53 => 'دير زرعيا',
          54 => 'دلبتا',
          55 => 'درعليه',
          56 => 'دقارين',
          57 => 'شقيف بقعتوتا',
          58 => 'الضهر',
          59 => 'ضهر غبالة',
          60 => 'دورة سهيلة',
          61 => 'أدما والدفنه',
          62 => 'جعايل غبالة',
          63 => 'عقيبة',
          64 => 'عذره والعذر',
          65 => 'غوابي',
          66 => 'حارة ميروبا',
          67 => 'خرايب',
          68 => 'الخرايب دلبتا',
          69 => 'معادن',
          70 => 'مرج',
          71 => 'مصيف',
          72 => 'قشا',
          73 => 'قرقوف',
          74 => 'صالحية بزحل',
          75 => 'شوم كفر ذبيان',
          76 => 'السلايخ',
          77 => 'سوحوم الغينة',
          78 => 'الشاحوط',
          79 => 'التروع',
          80 => 'زعيترية',
          81 => 'فيطرون',
          82 => 'فنيوان',
          83 => 'فقرا',
          84 => 'فاريا',
          85 => 'فتقا',
          86 => 'فتاح الشوحا',
          87 => 'فتاحات جورة الترمس',
          88 => 'غادير جونيه',
          89 => 'غدراس',
          90 => 'غزير',
          91 => 'غبالة',
          92 => 'غينة',
          93 => 'غيشرايه',
          94 => 'غوسطا',
          95 => 'حقل الريس',
          96 => 'حماسيات',
          97 => 'حارة المير ذوق مكايل',
          98 => 'حارة حلان',
          99 => 'حارة صخر',
          100 => 'هرهريا',
          101 => 'حريقة',
          102 => 'حريق شحتول',
          103 => 'حريصا',
          104 => 'حياطة',
          105 => 'حلان',
          106 => 'حراجل',
          107 => 'حصين',
          108 => 'جديدة غزير',
          109 => 'جعيتا',
          110 => 'جوار البواشق',
          111 => 'جوار الحشيش شحتول',
          112 => 'جونيه',
          113 => 'جونيه كسليك',
          114 => 'جورة بدران',
          115 => 'جورة الدردور',
          116 => 'جورة الترمس',
          117 => 'جورة مهاد',
          118 => 'كفرحباب',
          119 => 'كفر جريف',
          120 => 'كفر دبيان',
          121 => 'كفر شيحام',
          122 => 'كفر ياسين',
          123 => 'الكفور',
          124 => 'خلال',
          125 => 'خضيره',
          126 => 'كساير',
          127 => 'معاملتين',
          128 => 'معراب',
          129 => 'المعيصرة',
          130 => 'ميروبا',
          131 => 'مار نهرا',
          132 => 'مشحات',
          133 => 'مزرعة الراس',
          134 => 'مشاع الفتوح',
          135 => 'مشاع فاريا',
          136 => 'مشاع كفر ذبيان',
          137 => 'مشاته',
          138 => 'محقان المظلوم',
          139 => 'المغاير',
          140 => 'مرادية',
          141 => 'مراح المير',
          142 => 'مريجة كسروان',
          143 => 'نبع المغارة',
          144 => 'نهر الدهب',
          145 => 'نهر الحصين',
          146 => 'نهر الكلب',
          147 => 'النموره',
          148 => 'نمورة',
          149 => 'وطى الجوز',
          150 => 'وطى اللوز',
          151 => 'وطى نهر الكلب',
          152 => 'وطى سلام',
          153 => 'قلعة كفر ذبيان',
          154 => 'قلعة معراب',
          155 => 'قرقرا',
          156 => 'القرقوف',
          157 => 'قرصة',
          158 => 'القطين',
          159 => 'قليعات كسروان',
          160 => 'قميزرة',
          161 => 'قواله',
          162 => 'رعشين',
          163 => 'ريفون',
          164 => 'رامية كفر ياسين',
          165 => 'ريحان كسروان',
          166 => 'صفرا كسروان',
          167 => 'ساحل علما',
          168 => 'دير سيدة بزمار',
          169 => 'صربا',
          170 => 'سهيلة',
          171 => 'سيرجه',
          172 => 'صنوبر يحشوش',
          173 => 'طبرجا',
          174 => 'تلة',
          175 => 'وطى طبرية',
          176 => 'يحشوش',
          177 => 'زعيتره',
          178 => 'زاير',
          179 => 'زيتون',
          180 => 'زليكات',
          181 => 'ذوق مصبح',
          182 => 'ذوق مكايل',
        );

        /*for ($i=0; $i < count($Kesrwane) ; $i++) {
            if(isset($Kesrwane[$i])){
                Area::insert([
                    'caza_id' => 20,
                    'name' => $Kesrwane[$i],
                    'arabic' => $Kesrwane1[$i]
                ]);
            }
        }*/

        $Bcharre = array (
          0 => 'Aabdine Bcharre',
          1 => 'Ariz',
          2 => 'Bane',
          3 => 'Barhalioun',
          4 => 'Bazaoun',
          5 => 'Bcharre',
          6 => 'Beit Menzer',
          7 => 'Billa',
          8 => 'Blaouza',
          9 => 'Bqaa Kafra',
          10 => 'Bqerqacha',
          11 => 'Braissat',
          12 => 'Chira',
          13 => 'Dimane',
          14 => 'Hadchit',
          15 => 'Hadet Ej jebbe',
          16 => 'Hasroun',
          17 => 'Kfar Saroun dimane',
          18 => 'Mazraat Assaf',
          19 => 'Mazraat Beni Saab',
          20 => 'Mchaa ej Joubbeh',
          21 => 'Moghr El Ahoual',
          22 => 'Qnaiouer',
          23 => 'Qnat',
          24 => 'Tourza',
          25 => 'Wadi Qannoubine',
        );

        $Bcharre1 = array (
          0 => 'عبدين بشري',
          1 => 'أرز',
          2 => 'بان',
          3 => 'برحليون',
          4 => 'بزعون',
          5 => 'بشري',
          6 => 'بيت منذر',
          7 => 'بلا',
          8 => 'بلوزا',
          9 => 'بقاع كفرا',
          10 => 'بقرقاشا',
          11 => 'بريسات',
          12 => 'شيرا',
          13 => 'ديمان',
          14 => 'حدشيت',
          15 => 'حدث الجبه',
          16 => 'حصرون',
          17 => 'كفر صارون الديمان',
          18 => 'مزرعة عساف',
          19 => 'مزرعة بني صعب',
          20 => 'مشاع الجبه',
          21 => 'مغر الاحول',
          22 => 'قنيور',
          23 => 'قناة',
          24 => 'طورزا',
          25 => 'وادي قنوبين',
        );

        /*for ($i=0; $i < count($Bcharre) ; $i++) {
            if(isset($Bcharre[$i])){
                Area::insert([
                    'caza_id' => 7,
                    'name' => $Bcharre[$i],
                    'arabic' => $Bcharre1[$i]
                ]);
            }
        }*/

        $El_Betroun = array (
          0 => 'Aabdelle',
          1 => 'Aabrine',
          2 => 'Aalali',
          3 => 'Aaoura',
          4 => 'Aartez',
          5 => 'Ain el Batie',
          6 => 'Ain el Blat',
          7 => 'Ain er Raha',
          8 => 'Assia',
          9 => 'Balaa',
          10 => 'Barzakine',
          11 => 'Basbina',
          12 => 'Batroun',
          13 => 'Bcheale',
          14 => 'Bechtoudar-Aoura',
          15 => 'Beit Chlala',
          16 => 'Beit Kassab',
          17 => 'Bijdarfel',
          18 => 'Borj',
          19 => 'Boustane El Aassi',
          20 => 'Bqaiaa et Dahr Abi Yaghi',
          21 => 'Bqosmaiya',
          22 => 'Chabtine',
          23 => 'Chatine',
          24 => 'Chawi',
          25 => 'Chekka',
          26 => 'Chnata',
          27 => 'Daael',
          28 => 'Dahr Abi Yaghi',
          29 => 'Dahr el Ghbare',
          30 => 'Dahr El Qotlob',
          31 => 'Dahr Mar Risha',
          32 => 'Dawrat',
          33 => 'Dayr Shouwah',
          34 => 'Deir Billa',
          35 => 'Deir Kfifane',
          36 => 'Deir Mar Youhanna Douma',
          37 => 'Deir Mar Youssef Jrabta',
          38 => 'Derya',
          39 => 'Douma',
          40 => 'Douq',
          41 => 'Edde el Batroun',
          42 => 'El Aazeqa',
          43 => 'El Hamra JRANE',
          44 => 'El Harf',
          45 => 'El Heri',
          46 => 'El Khraize',
          47 => 'El Midane Kfifane',
          48 => 'El Qabaah',
          49 => 'En Nahriye',
          50 => 'Fadaous',
          51 => 'Fehta',
          52 => 'Ftahat',
          53 => 'Ghouma',
          54 => 'Hadtoun',
          55 => 'Hai el Birke',
          56 => 'Halta',
          57 => 'Hamat',
          58 => 'Hannouch',
          59 => 'Harbouna',
          60 => 'Hardine',
          61 => 'Harissa el batroun',
          62 => 'Hazrita',
          63 => 'Hourata el batroun',
          64 => 'Hrayek',
          65 => 'Ijdabra',
          66 => 'Jibla',
          67 => 'Joundi',
          68 => 'Jrane',
          69 => 'Jrebta',
          70 => 'Kandoula',
          71 => 'Kfar Aabida',
          72 => 'Kfar Chlaimane',
          73 => 'Kfar Hatna',
          74 => 'Kfar Hay',
          75 => 'Kfar Helda',
          76 => 'Kfarhollos',
          77 => 'Kfifane',
          78 => 'Kfour El Aarbi',
          79 => 'Koubba',
          80 => 'Kour',
          81 => 'Madfoun',
          82 => 'Mahmerch',
          83 => 'Mar Mama',
          84 => 'Mar Youhanna Maroun',
          85 => 'Mar Youssef',
          86 => 'Masrah',
          87 => 'Mazraat Biyade',
          88 => 'Meghrak',
          89 => 'Mrah Chdid',
          90 => 'Mrah El Haj',
          91 => 'Mrah Ez Zaiat',
          92 => 'Myle',
          93 => 'Nabaa ej Jdid',
          94 => 'Nahle batroun',
          95 => 'Najmet es Sobh',
          96 => 'Niha El Batroun',
          97 => 'Ouadi ej Jord',
          98 => 'Ouadi Tanourine Et Tahta',
          99 => 'Ouata Haub',
          100 => 'Qarnaoun',
          101 => 'Qornet el Marj',
          102 => 'Quajh El - Hajar',
          103 => 'Racha',
          104 => 'Rachana',
          105 => 'Rachkida',
          106 => 'Rachkidde',
          107 => 'Ram el batroun',
          108 => 'Ramate',
          109 => 'Ras Bnaiya',
          110 => 'Ras Ed Daouali',
          111 => 'Ras Nahhach',
          112 => 'Selaata',
          113 => 'Sghar',
          114 => 'Smar Jbail',
          115 => 'Sourat',
          116 => "Ssel'aal",
          117 => 'Tannourine el Faouqa',
          118 => 'Tanourine Et Tahta',
          119 => 'Thoum',
          120 => 'Toula',
          121 => 'Yarita',
          122 => 'Zane',
        );

        $El_Betroun1 = array (
          0 => 'عبدللي',
          1 => 'عبرين',
          2 => 'علالي',
          3 => 'عورا البترون',
          4 => 'عرطز',
          5 => 'عين البطيه',
          6 => 'عين البلاط',
          7 => 'عين الراحا',
          8 => 'اسيا',
          9 => 'بلعة',
          10 => 'برزقين',
          11 => 'بسبينا',
          12 => 'بترون',
          13 => 'بشعلة',
          14 => 'بشتودار',
          15 => 'بيت شلالا',
          16 => 'بيت كسّاب',
          17 => 'بجدرفل',
          18 => 'البرج كفر عبيدا',
          19 => 'بساتين العصي',
          20 => 'بقيعة البترون',
          21 => 'بقسميا',
          22 => 'شبطين',
          23 => 'شاتين',
          24 => 'شاوي',
          25 => 'شكَا',
          26 => 'شناتا',
          27 => 'داعل',
          28 => 'ضهر ابي ياغي',
          29 => 'ضهر الغبار',
          30 => 'ضهر القطلب',
          31 => 'ضهر مار ريشا',
          32 => 'دورة كفر عبيدا',
          33 => 'دير شواح',
          34 => 'ديربلا',
          35 => 'دير كفيفان',
          36 => 'دير مار يوحنا دوما',
          37 => 'دير مار يوسف جربتا',
          38 => 'دريا',
          39 => 'دوما',
          40 => 'دوق',
          41 => 'إده البترون',
          42 => 'عزيقه',
          43 => 'حمرا جران',
          44 => 'حرف',
          45 => 'هري',
          46 => 'خريزه',
          47 => 'ميدان كفيفان',
          48 => 'قبع كفيفان',
          49 => 'نهريه',
          50 => 'فدعوس',
          51 => 'فحتا',
          52 => 'فتاحات',
          53 => 'غوما',
          54 => 'حدتون',
          55 => 'حي البركة',
          56 => 'حلتا',
          57 => 'حامات',
          58 => 'حنٌوش',
          59 => 'حربونا',
          60 => 'حردين',
          61 => 'حريصا البترون',
          62 => 'حزريتا',
          63 => 'حوراتا البترون',
          64 => 'حرايق',
          65 => 'اجدبرا',
          66 => 'جبلا',
          67 => 'جندي',
          68 => 'جران',
          69 => 'جربتا',
          70 => 'قندولا',
          71 => 'كفر عبيدا',
          72 => 'كفر شليمان',
          73 => 'كفرحتنا',
          74 => 'كفرحي',
          75 => 'كفر حلدا',
          76 => 'كفر خلص',
          77 => 'كفيفان',
          78 => 'كفور العربي',
          79 => 'كوبا',
          80 => 'كور',
          81 => 'مدفون',
          82 => 'محمرش',
          83 => 'مار ماما',
          84 => 'مار يوحنا مارون',
          85 => 'مار يوسف',
          86 => 'مسرح',
          87 => 'مزرعة بياض',
          88 => 'مغراق',
          89 => 'مراح شديد',
          90 => 'مراح الحاج',
          91 => 'مراح الزيات',
          92 => 'ميل',
          93 => 'نبع الجديد',
          94 => 'نحلا البترون',
          95 => 'نجمة الصبح',
          96 => 'نيحا البترون',
          97 => 'وادي الجرد',
          98 => 'وادي تنورين التحتا',
          99 => 'وطى حوب',
          100 => 'قرنعون',
          101 => 'قرنة المرج',
          102 => 'وجه الحجر',
          103 => 'راشا',
          104 => 'راشانا',
          105 => 'راشكيدا',
          106 => 'راشكِدّه',
          107 => 'الرام البترون',
          108 => 'رمات',
          109 => 'راس بنيه',
          110 => 'راس الدوالي',
          111 => 'راس نحاش',
          112 => 'سلعاتا',
          113 => 'صغار',
          114 => 'سمار جبيل',
          115 => 'صورات',
          116 => 'سلع',
          117 => 'تنورين الفوقا',
          118 => 'تنورين التحتا',
          119 => 'تحوم',
          120 => 'تولا',
          121 => 'ياريتا',
          122 => 'زان',
        );

        /*for ($i=0; $i < count($El_Betroun) ; $i++) {
            if(isset($El_Betroun[$i])){
                Area::insert([
                    'caza_id' => 11,
                    'name' => $El_Betroun[$i],
                    'arabic' => $El_Betroun1[$i]
                ]);
            }
        }*/

        $El_Koura = array (
          0 => 'DEIR EL BALAMAND',
          1 => 'KELBATA',
          2 => 'MJEYDIL KFAR HAZIR',
          3 => 'Aaba',
          4 => 'Aafsdiq',
          5 => 'Ain Aakrine',
          6 => 'Al-Hraiche',
          7 => 'Amioun',
          8 => 'Bahbouch',
          9 => 'Barghoun',
          10 => 'Barsa',
          11 => 'Batroumine',
          12 => 'Bdeihoun',
          13 => 'Bdibba',
          14 => 'Bechmizzine',
          15 => 'Bednayel el koura',
          16 => 'Bkeftine',
          17 => 'Bnehrane',
          18 => 'Bsarma',
          19 => 'Btaaboura',
          20 => 'Btouratij',
          21 => 'Btourram',
          22 => 'Bziza',
          23 => 'Dahr AlAin',
          24 => 'Dar Baachtar',
          25 => 'Dar Chmizzine',
          26 => 'Dedde',
          27 => 'El Aaqbe',
          28 => 'El Bahsas',
          29 => 'El Bqaiaa',
          30 => 'En Nakhle',
          31 => 'Enfe',
          32 => 'Fiaa',
          33 => 'Haret El KHASSEH',
          34 => 'Ijdabrine',
          35 => 'Jdeideh Berkacha',
          36 => 'Kaftoun',
          37 => 'Kefraiya',
          38 => 'Kfar Aaqqa',
          39 => 'Kfar Hata',
          40 => 'Kfar Hazir',
          41 => 'Kfar Qahel',
          42 => 'Kfar Saroun',
          43 => 'Kousba',
          44 => 'Majdel el Koura',
          45 => 'Metrit',
          46 => 'Oueta Fares',
          47 => 'Qalhat',
          48 => 'Ras Maska',
          49 => 'Ras Masqa Ech Chmaliye',
          50 => 'Ras Masqa Ej Jnoubiye',
          51 => 'Rechdibbine',
          52 => 'Zakroun',
          53 => 'Zakzouk',
          54 => 'Zgharta el Mtaouleh',
        );

        $El_Koura1 = array (
          0 => 'دير البلمند',
          1 => 'كلباتا',
          2 => 'مجيدل كفر حزير',
          3 => 'عبا الكورة',
          4 => 'عفصديق',
          5 => 'عين عكرين',
          6 => 'حريشه',
          7 => 'اميون',
          8 => 'بحبوش',
          9 => 'برغون',
          10 => 'برصا',
          11 => 'بترومين',
          12 => 'بدبهون',
          13 => 'بدبا',
          14 => 'بشمزين',
          15 => 'بدنايل الكورة',
          16 => 'بكفتين',
          17 => 'بنهران',
          18 => 'بصرما',
          19 => 'بتعبورة',
          20 => 'بتوراتيج',
          21 => 'بطرام',
          22 => 'بزيزا',
          23 => 'ضهر العين',
          24 => 'دار بعشتار',
          25 => 'دار شمزين',
          26 => 'دده',
          27 => 'عقبة',
          28 => 'بحصاص',
          29 => 'البقيعة',
          30 => 'نخلة',
          31 => 'أنفه',
          32 => 'فيع',
          33 => 'حارة الخسة',
          34 => 'اجدعبرين',
          35 => 'جديدة برقاشا',
          36 => 'كفتون',
          37 => 'كفريا الكورة',
          38 => 'كفر عقا',
          39 => 'كفرحاتا',
          40 => 'كفرحزير',
          41 => 'كفرقاهل',
          42 => 'كفرصارون',
          43 => 'كوسبا',
          44 => 'مجدل الكورة',
          45 => 'متريت',
          46 => 'وطى فارس',
          47 => 'قلحات',
          48 => 'راس مسقا',
          49 => 'راس مسقا الشمالية',
          50 => 'راس مسقا الجنوبية',
          51 => 'رشدبين',
          52 => 'زكرون',
          53 => 'زكزوك',
          54 => 'زغرتا المتاولة',
        );

        /*for ($i=0; $i < count($El_Koura) ; $i++) {
            if(isset($El_Koura[$i])){
                Area::insert([
                    'caza_id' => 13,
                    'name' => $El_Koura[$i],
                    'arabic' => $El_Koura1[$i]
                ]);
            }
        }*/

        $El_Minieh = array (
          0 => 'MAZRAAT KETRANE',
          1 => 'Aadoui',
          2 => 'Aassaimout',
          3 => 'Aassoun',
          4 => 'Abou Hamad',
          5 => 'Afqa El Minieh',
          6 => 'Ain es Safsaf',
          7 => 'Ain Et Tine',
          8 => 'Amar',
          9 => 'Azqey',
          10 => 'Baazqoun',
          11 => 'Bahsa',
          12 => 'Bakhaoun',
          13 => 'Bchennata',
          14 => 'Bechhara',
          15 => 'Bechtayel',
          16 => 'Behouaita',
          17 => 'Beit Bakkour',
          18 => 'Beit Daoud Izal',
          19 => 'Beit El Faqs',
          20 => 'Beit Haouik',
          21 => 'Beit Hasna',
          22 => 'Beit jida',
          23 => 'Beit Kanj',
          24 => 'Beit Moumne',
          25 => 'Beit Radouane',
          26 => 'Beit Zoud',
          27 => 'Bhannine El Minieh',
          28 => 'Borj El Yahoudiye',
          29 => 'Bqaa Safrin',
          30 => 'Bqarsouna',
          31 => 'Btahline',
          32 => 'Btellaiye',
          33 => 'Btermaz',
          34 => 'Chmis',
          35 => 'Dairaiya',
          36 => 'Debaal El Minieh',
          37 => 'Deir Amar',
          38 => 'Deir Nbouh',
          39 => 'Ech Chalout',
          40 => 'El Beddaoui',
          41 => 'El Hazmiye',
          42 => 'El Kharnoub',
          43 => 'El Medine ej jdide',
          44 => 'El Minie',
          45 => 'En Nabi Kzaiber',
          46 => 'En Nabi Youchaa',
          47 => 'Er Rihaniye El Minieh',
          48 => 'Es Snoubar',
          49 => 'Haoura',
          50 => 'Haql El Aazime',
          51 => 'Haqlit',
          52 => 'Harf es siyad',
          53 => 'Izal',
          54 => 'Jairoun',
          55 => 'Jarjour',
          56 => 'Kahf El - Malloul',
          57 => 'Karm El - Mohr',
          58 => 'Karm El Akhras',
          59 => 'Kfar Bebnine',
          60 => 'Kfar Chillane',
          61 => 'Kfar Habou',
          62 => 'Kharnoub',
          63 => 'Maassarati',
          64 => 'Markabta',
          65 => 'Mazraat Aartoussi',
          66 => 'MAZRAAT EL KREYM',
          67 => 'Mgharet ech Cheikh',
          68 => 'Moulid',
          69 => 'Mrah Es Sfire',
          70 => 'Mrah Es Sreij',
          71 => 'Mrebbine',
          72 => 'Nemrine',
          73 => 'Ouadi En Nahle',
          74 => 'Ouatiye',
          75 => 'Qarhaiya',
          76 => 'Qarn',
          77 => 'Qarsita',
          78 => 'Qattine El Minieh',
          79 => 'Qemmamine',
          80 => 'Qraine',
          81 => 'Raouda',
          82 => 'Sertouka',
          83 => 'Sfire',
          84 => 'Sir Ed Danniye',
          85 => 'Souaqi',
          86 => 'Tarane',
          87 => 'Terbol El Minieh',
          88 => 'Wadi en Njass',
          89 => 'Zghartighrine',
          90 => 'Zouq Bhannine',
        );

        $El_Minieh1 = array (
          0 => 'مزرعة كتران',
          1 => 'عدوة',
          2 => 'عصيموت',
          3 => 'عاصون',
          4 => 'ابو حمد',
          5 => 'افقا المنيه',
          6 => 'عين الصفصاف',
          7 => 'عين التينه المنيه',
          8 => 'عيمر',
          9 => 'عزقي',
          10 => 'بعزقون',
          11 => 'البحصة',
          12 => 'بخعون',
          13 => 'بشناتا',
          14 => 'بشحارة',
          15 => 'بشتايل',
          16 => 'بحويتا',
          17 => 'بيت بكور',
          18 => 'بيت داوود عزال',
          19 => 'بيت الفقس',
          20 => 'بيت حاويك',
          21 => 'بيت حسنة',
          22 => 'بيت جدا',
          23 => 'بيت كنج',
          24 => 'بيت مومنة',
          25 => 'بيت رضوان',
          26 => 'بيت زود',
          27 => 'بحنين المنيه',
          28 => 'برج اليهودية',
          29 => 'بقاع صفرين',
          30 => 'بقرصونه',
          31 => 'بتحلين',
          32 => 'بتلايه',
          33 => 'بطرماز',
          34 => 'الشميس',
          35 => 'داريا المنيه',
          36 => 'دبعل المنيه',
          37 => 'دير عمار',
          38 => 'دير نبوح',
          39 => 'شالوط',
          40 => 'بداوي',
          41 => 'حازمية المنيه',
          42 => 'خرنوب المنيه',
          43 => 'مدينة الجديدة',
          44 => 'المنيه',
          45 => 'النبي كزيبر',
          46 => 'النبي يوشع',
          47 => 'ريحانيه المنيه',
          48 => 'صنوبر',
          49 => 'حوارة',
          50 => 'حقل العزيمة',
          51 => 'حقلة',
          52 => 'حرف السياد',
          53 => 'إيزال',
          54 => 'جيرون',
          55 => 'جرجور',
          56 => 'كفَ الملول',
          57 => 'كرم المهر',
          58 => 'كرم الاخرس',
          59 => 'كفر ببنين',
          60 => 'كفر شلان',
          61 => 'كفر حبو',
          62 => 'خرنوب',
          63 => 'معصراتي',
          64 => 'مركبتا',
          65 => 'مزرعة عرطوسي',
          66 => 'مزرعة الكريم',
          67 => 'مغارة الشيخ',
          68 => 'موليد',
          69 => 'مراح السفيرة',
          70 => 'مراح السريج',
          71 => 'مربين',
          72 => 'نمرين',
          73 => 'وادي النحلة',
          74 => 'واطيه',
          75 => 'قرحيا',
          76 => 'القرن',
          77 => 'قرصيتا',
          78 => 'القطين المنيه',
          79 => 'قمامين',
          80 => 'قرين',
          81 => 'روضه المنيه',
          82 => 'سرتوكا',
          83 => 'سفيرة',
          84 => 'سير الضنية',
          85 => 'السواقي',
          86 => 'طاران',
          87 => 'تربل المنيه',
          88 => 'وادي النجاص',
          89 => 'زغرتغرين',
          90 => 'ذوق بحنين',
        );

        /*for ($i=0; $i < count($El_Minieh) ; $i++) {
            if(isset($El_Minieh[$i])){
                Area::insert([
                    'caza_id' => 15,
                    'name' => $El_Minieh[$i],
                    'arabic' => $El_Minieh1[$i]
                ]);
            }
        }*/

        $Tripoli = array (
          0 => 'Abou Samra',
          1 => 'Bab Al Ramel',
          2 => 'Bahsas',
          3 => 'Dam Wal Farz',
          4 => 'Ed Debbagha',
          5 => 'El Maloula',
          6 => 'El Mina',
          7 => 'Hadid',
          8 => 'Hdadine',
          9 => 'Jessrine',
          10 => 'Mankoubin',
          11 => 'Mhatreh',
          12 => 'MINA 1',
          13 => 'MINA 2',
          14 => 'Mina Jardin',
          15 => 'Noury',
          16 => 'Qalamoun',
          17 => 'Qoubbe',
          18 => 'Rammanet',
          19 => 'Shok',
          20 => 'Souayqa',
          21 => 'Tabbaneh',
          22 => 'Tal',
          23 => 'Trablous Jardins',
          24 => 'Trablous Zeitoun',
          25 => 'Tripoli',
          26 => 'Zahrieh',
        );

        $Tripoli1 = array (
          0 => 'ابو سمرا',
          1 => 'باب الرمل',
          2 => 'البحصاص',
          3 => 'الضم و الفرز',
          4 => 'الدباغة',
          5 => 'الملولة',
          6 => 'المينا',
          7 => 'الحديد',
          8 => 'الحدادين',
          9 => 'جسرين',
          10 => 'منكوبين',
          11 => 'المهاترة',
          12 => 'مينا طرابلس 1',
          13 => 'مينا طرابلس 2',
          14 => 'بساتين المينا',
          15 => 'النوري',
          16 => 'القلمون',
          17 => 'القبة',
          18 => 'الرمانة',
          19 => 'شق',
          20 => 'السويقة',
          21 => 'التبانة',
          22 => 'التل',
          23 => 'بساتين طرابلس',
          24 => 'طرابلس الزيتون',
          25 => 'طرابلس',
          26 => 'الزاهرية',
        );

        /*for ($i=0; $i < count($Tripoli) ; $i++) {
            if(isset($Tripoli[$i])){
                Area::insert([
                    'caza_id' => 25,
                    'name' => $Tripoli[$i],
                    'arabic' => $Tripoli1[$i]
                ]);
            }
        }*/

        $Zgharta = array (
          0 => 'IAAL',
          1 => 'Aachach',
          2 => 'Aalma',
          3 => 'Aaqbet Sibaal',
          4 => 'Aarbet Qozhaiya',
          5 => 'Aardat',
          6 => 'Aarjess',
          7 => 'Ain Tourine',
          8 => 'Aitou',
          9 => 'Al Aaqbe',
          10 => 'Arde',
          11 => 'Aslout',
          12 => 'Asnoun',
          13 => 'Baslouqit',
          14 => 'Bayader Rachaaine',
          15 => 'Bchama',
          16 => 'Bchannine',
          17 => 'Beit Aabeid',
          18 => 'Beit Aaoukar',
          19 => 'Beit Barakat',
          20 => 'Beit el Hraqsa',
          21 => 'Beit Knaty',
          22 => 'Bnechaai',
          23 => 'Bouhairet Toula',
          24 => 'Bousit',
          25 => 'Bsebaal',
          26 => 'Danha',
          27 => 'Darayia',
          28 => 'Ehden',
          29 => 'Ejbeaa',
          30 => 'El Hariq',
          31 => 'El Houakir',
          32 => 'El Khaldiye',
          33 => 'El Qadriye',
          34 => 'Er Rmaile',
          35 => 'Et Talle',
          36 => 'Fouwar zgharta',
          37 => 'Fradis',
          38 => 'Haouqa Et En Naher',
          39 => 'Haret al Fouwar',
          40 => 'Haret Ej Jdide Zgharta',
          41 => 'Haret el Baklik',
          42 => 'Harfe Arde',
          43 => 'Hariq Zgharta',
          44 => 'Harsoun Ej Jdide',
          45 => 'Hilane zgharta',
          46 => 'Hmais zgharta',
          47 => 'Hraykess',
          48 => 'Jdeide zgharta',
          49 => 'Kaabouch',
          50 => 'Kafar Zeina',
          51 => 'Kafraiya zgharta',
          52 => 'Karbribe',
          53 => 'Karm Sadde',
          54 => 'Kfar Chakhna',
          55 => 'Kfar Dlaqous',
          56 => 'Kfar Fou',
          57 => 'Kfar Haoura',
          58 => 'Kfar Hata',
          59 => 'Kfar Sghab',
          60 => 'Kfar Yachit',
          61 => 'Majdalaya zgharta',
          62 => 'Mar Semaane',
          63 => 'Mazraat Ejbeh',
          64 => 'Mazraat Et Toufah',
          65 => 'Mazraat Hraqs',
          66 => 'Mazraat Jnaid',
          67 => 'Mazret al Nahr',
          68 => 'Miryata',
          69 => 'Miziara',
          70 => 'Qarah Bach',
          71 => 'Qareit Sakhra',
          72 => 'Rachaaine',
          73 => 'Raskifa',
          74 => 'Sahl Danha',
          75 => 'Sakhra',
          76 => 'Sanaallah',
          77 => 'Sebaal',
          78 => 'Seraal',
          79 => 'Toula zgharta',
          80 => 'Zgharta',
        );

        $Zgharta1 = array (
          0 => 'إيعال',
          1 => 'عشاش',
          2 => 'علما',
          3 => 'عقبة سبعل',
          4 => 'عربة قزحيا',
          5 => 'عردات',
          6 => 'عرجس',
          7 => 'عينطورين',
          8 => 'أيطو',
          9 => 'عقبة علما',
          10 => 'أرده',
          11 => 'اسلوت',
          12 => 'اصنون',
          13 => 'بسلوقيت',
          14 => 'بيادر رشعين',
          15 => 'بشاما',
          16 => 'بشنين',
          17 => 'بيت عبيد',
          18 => 'بيت عوكر',
          19 => 'بيت بركات',
          20 => 'بيت الحرقصى',
          21 => 'بيت قناطي',
          22 => 'بنشعي',
          23 => 'بحيرة تولا',
          24 => 'بوسيط',
          25 => 'بسبعل',
          26 => 'دنها',
          27 => 'داريا',
          28 => 'اهدن',
          29 => 'اجبع',
          30 => 'حريق',
          31 => 'حواكير',
          32 => 'خالدية',
          33 => 'قادريه',
          34 => 'رميله أرده',
          35 => 'تلة زغرتا',
          36 => 'فوار زغرتا',
          37 => 'الفراديس',
          38 => 'حوقا النهر',
          39 => 'حارة الفوار',
          40 => 'حارة الجديدة زغرتا',
          41 => 'حارة البكليك',
          42 => 'حرف أرده',
          43 => 'حريق زغرتا',
          44 => 'حصرون الجديدة',
          45 => 'حيلان زغرتا',
          46 => 'حميص',
          47 => 'حريقص',
          48 => 'الجديدة زغرتا',
          49 => 'كبوش',
          50 => 'كفر زينا',
          51 => 'كفريا زغرتا',
          52 => 'كربريب',
          53 => 'كرم سده',
          54 => 'كفر شخنا',
          55 => 'كفردلاقوس',
          56 => 'كفر فو',
          57 => 'كفر حورا',
          58 => 'كفر حاتا',
          59 => 'كفر صغاب',
          60 => 'كفر ياشيت',
          61 => 'مجدليا زغرتا',
          62 => 'مار سمعان',
          63 => 'مزرعة إجبع',
          64 => 'مزرعة التفاح',
          65 => 'مزرعة حريقص',
          66 => 'مزرعة جنيد',
          67 => 'مزرعة النهر',
          68 => 'مرياطا',
          69 => 'مزيارة',
          70 => 'قره باش',
          71 => 'قرعية صخرا',
          72 => 'رشعين',
          73 => 'راس كيفا',
          74 => 'سهل دنها',
          75 => 'صخرة',
          76 => 'صنع الله',
          77 => 'سبعل زغرتا',
          78 => 'سرعيل',
          79 => 'تولا زغرتا',
          80 => 'زغرتا',
        );

        /*for ($i=0; $i < count($Zgharta) ; $i++) {
            if(isset($Zgharta[$i])){
                Area::insert([
                    'caza_id' => 28,
                    'name' => $Zgharta[$i],
                    'arabic' => $Zgharta1[$i]
                ]);
            }
        }*/


        $Jezzine = array (
          0 => 'Aadour',
          1 => 'Aaichiye',
          2 => 'Aaqmata',
          3 => 'Aaramta',
          4 => 'Aariye',
          5 => 'Aarqoub',
          6 => 'Aazour',
          7 => 'Ain el Mir el Estabel',
          8 => 'Ain et Taghra',
          9 => 'Ain Majdalain',
          10 => 'Anane',
          11 => 'Azibeh',
          12 => 'Baanoub',
          13 => 'Baba',
          14 => 'Baissour Jezzine',
          15 => 'Benouati',
          16 => 'Bhannine',
          17 => 'Bisri',
          18 => 'Biyad',
          19 => 'Bkassine',
          20 => 'Bouslaya',
          21 => 'Bteddine el Loqch',
          22 => 'Chamkha',
          23 => 'Chbeil',
          24 => 'Choualiq',
          25 => 'Dahr ed Deir',
          26 => 'Dahr er Ramle',
          27 => 'Darayia Jezzine',
          28 => 'Deir Chkedif',
          29 => 'Deir El Qattine',
          30 => 'Deir Machmouche',
          31 => 'Deir Moukhalles',
          32 => 'Dimechqiye',
          33 => 'El Harf Jezzine',
          34 => 'El Houraniye',
          35 => 'El Msous',
          36 => 'El Qabaa',
          37 => 'Ghbatiye',
          38 => 'Haidab',
          39 => 'Haitoule',
          40 => 'Haitoura',
          41 => 'Haret el Bayder',
          42 => 'Harf',
          43 => 'Hassaniye',
          44 => 'Homsiye',
          45 => 'Jabal Toura',
          46 => 'Jall Nachi',
          47 => 'Jarmaq',
          48 => 'Jdaidet el Ouadi',
          49 => 'Jensnaya',
          50 => 'Jernaya',
          51 => 'Jezzine',
          52 => 'Karkha',
          53 => 'Kfar Falous',
          54 => 'Kfar Houne',
          55 => 'Kfar Jarra',
          56 => 'Kfar Taala',
          57 => 'Khallet Khazen',
          58 => 'Khirkhaya',
          59 => 'Lebaa',
          60 => 'Louaiziye',
          61 => 'Maarous el Branieh',
          62 => 'Maarous el Jouanieh',
          63 => 'Machmouche',
          64 => 'Mahmoudiye Jezzine',
          65 => 'Maknouniye',
          66 => 'Mazraat Aarqoub',
          67 => 'Mazraat Jabal Toura',
          68 => 'Mazraat Tamra',
          69 => 'Mazraat Aaqmata',
          70 => 'Mazraat Aaraji',
          71 => 'Mazraat Al Souairi',
          72 => 'Mazraat el Btadiniye',
          73 => 'Mazraat el Khaoukh',
          74 => 'Mazraat el Mathane',
          75 => 'Mazraat er Rohbane',
          76 => 'Mazraat Louzyde',
          77 => 'Mharbiye',
          78 => 'Midane',
          79 => 'Mjaydel',
          80 => 'Mlikh',
          81 => 'Mrah Abdu Chedid',
          82 => 'Mrah El Hbas',
          83 => 'Mrah Mghaibe',
          84 => 'Mzairaa',
          85 => 'Nabaa',
          86 => 'Nabi Sejoud',
          87 => 'Ouadi Baanqoudine',
          88 => 'Ouadi el Leimoun',
          89 => 'Ouardiye',
          90 => 'Ouazaaiye',
          91 => 'Qaitoule',
          92 => 'Qotrani',
          93 => 'Qrouh',
          94 => 'Qtale Jezzine',
          95 => 'Raimat',
          96 => 'Rihane Jezzine',
          97 => 'Roum',
          98 => 'Roummane Jezzine',
          99 => 'Rous El Franj',
          100 => 'Sabah',
          101 => 'Salima',
          102 => 'Sejoud',
          103 => 'Sfarai',
          104 => 'Sidoun',
          105 => 'Sniye',
          106 => 'Sriri',
          107 => 'Taaid',
          108 => 'Tamra',
          109 => 'Wadi Jezzine',
          110 => 'Zaghrine Jezzine',
          111 => 'Zhalta',
        );

        $Jezzine1 = array (
          0 => 'عاضور',
          1 => 'عيشية',
          2 => 'عقماتا',
          3 => 'عرمتى',
          4 => 'عاريه',
          5 => 'العرقوب',
          6 => 'عازور',
          7 => 'عين المير إسطبل',
          8 => 'عين التغرى',
          9 => 'عين مجدلين',
          10 => 'أنان',
          11 => 'عزيبة',
          12 => 'بعانوب',
          13 => 'بيبه',
          14 => 'بيصور جزين',
          15 => 'بنواتي جزين',
          16 => 'بحنين',
          17 => 'بسري',
          18 => 'البياض',
          19 => 'بكاسين',
          20 => 'بوصلايا',
          21 => 'بتدين اللقش',
          22 => 'شامخة',
          23 => 'شبيل',
          24 => 'شواليق جزين',
          25 => 'ضهر الدير',
          26 => 'ضهر الرملة',
          27 => 'داريا جزين',
          28 => 'شقاديف',
          29 => 'دير قطِين',
          30 => 'دير مشموشه',
          31 => 'دير المخلص',
          32 => 'دمشقية',
          33 => 'الحرف جزين',
          34 => 'حورانية',
          35 => 'مصوص',
          36 => 'قبع',
          37 => 'غبَاطية',
          38 => 'حيداب',
          39 => 'حيتوله',
          40 => 'حيطورة',
          41 => 'حارة البيادر',
          42 => 'الحرف',
          43 => 'حسانية',
          44 => 'حمصية',
          45 => 'جبل طوره',
          46 => 'جل ناشي',
          47 => 'الجرمق',
          48 => 'الجديدة وادي جزين',
          49 => 'جنسنايا',
          50 => 'جرنايا',
          51 => 'جزين',
          52 => 'كرخا',
          53 => 'كفرفالوس',
          54 => 'كفرحون',
          55 => 'كفرجرا',
          56 => 'كفرتعلا',
          57 => 'خلة خازن',
          58 => 'خرخيا',
          59 => 'لبعا',
          60 => 'لويزة جزين',
          61 => 'ماروس البرانية',
          62 => 'ماروس الجوانية',
          63 => 'مشموشة',
          64 => 'محمودية جزين',
          65 => 'مكنونية',
          66 => 'مزرعة العرقوب',
          67 => 'مزرعة جبل طوره',
          68 => 'مزرعة طمره',
          69 => 'مزرعة عقماتا',
          70 => 'مزرعة عراجي',
          71 => 'مزرعة الصويري',
          72 => 'مزرعة البتدينية',
          73 => 'مزرعة الخوخ',
          74 => 'مزرعة المطحنة',
          75 => 'مزرعة الرهبان',
          76 => 'مزرعة لوزيد',
          77 => 'محاربية',
          78 => 'ميدان',
          79 => 'مجيدل',
          80 => 'مليخ',
          81 => 'مراح أبو شديد',
          82 => 'مراح الحباس',
          83 => 'مراح مغبيه',
          84 => 'مزيرعة',
          85 => 'نبعه',
          86 => 'نبي سجد',
          87 => 'وادي بعنقودين',
          88 => 'وادي الليمون',
          89 => 'وردية',
          90 => 'اوزاعية',
          91 => 'قيتولي',
          92 => 'قطراني',
          93 => 'قروح',
          94 => 'قتالة جزين',
          95 => 'ريمات',
          96 => 'ريحانة جزين',
          97 => 'روم',
          98 => 'رمانة',
          99 => 'راس الوادي الحوة',
          100 => 'صّباح',
          101 => 'صليما',
          102 => 'سجد',
          103 => 'صفاريه',
          104 => 'صيدون',
          105 => 'سنيَا',
          106 => 'سريرة',
          107 => 'تعيد',
          108 => 'طمره',
          109 => 'وادي جزين',
          110 => 'زغرين جزين',
          111 => 'زحلتا',
        );

        /*for ($i=0; $i < count($Jezzine) ; $i++) {
            if(isset($Jezzine[$i])){
                Area::insert([
                    'caza_id' => 19,
                    'name' => $Jezzine[$i],
                    'arabic' => $Jezzine1[$i]
                ]);
            }
        }*/

        $Saida = array (
          0 => 'Aabra',
          1 => 'Aaddoussiye',
          2 => 'Aadloun',
          3 => 'Aanqoun',
          4 => 'Aaqbiye',
          5 => 'Aaqtanit',
          6 => 'Aarnaba',
          7 => 'Abou el Assouad',
          8 => 'Ain Ed Delb',
          9 => 'Ain el Hiloue',
          10 => 'Arkey',
          11 => 'Arzay',
          12 => 'Babliye',
          13 => 'Barti',
          14 => 'Bissariyeh',
          15 => 'Bnaafoul',
          16 => 'Bqosta',
          17 => 'Brak et Tall',
          18 => 'Bramiye',
          19 => 'Daoudiye',
          20 => 'Darb es Sim',
          21 => 'Deir Taqla',
          22 => 'Dekerman',
          23 => 'Dhour Darb es Sim',
          24 => 'El Achrafiye',
          25 => 'El Mahmoudiye',
          26 => 'Er Rouayess',
          27 => 'Ez Zahrani',
          28 => 'Ghassaniye',
          29 => 'Ghaziye',
          30 => 'Hababiye',
          31 => 'Hajje',
          32 => 'Haret Saida',
          33 => 'Hartai',
          34 => 'Hlaliye Saida',
          35 => 'Insariye',
          36 => 'Jazire',
          37 => 'Jdaide Arzai',
          38 => 'Jinjlaya',
          39 => 'Kafraiya',
          40 => 'Kaouthariyet es Siyad',
          41 => 'Kfar Badde',
          42 => 'Kfar Beit',
          43 => 'Kfar Chellal',
          44 => 'Kfar Hatta',
          45 => 'Kfar Melki Saida',
          46 => 'Khannoussiye',
          47 => 'Kharayeb Saida',
          48 => 'Khartoum',
          49 => 'Khaziz',
          50 => 'Khirbet Ain el Qanater',
          51 => 'Khirbet Bassal',
          52 => 'Khirbet ed Daoueir',
          53 => 'Loubiye',
          54 => 'Maamriye',
          55 => 'Maamriyet el Kharab',
          56 => 'Maghdouche',
          57 => 'Majdelyoun',
          58 => 'Maqsam El JAOUHARI',
          59 => 'Matariyet ech Choumar',
          60 => 'Mazraat Aabboudiye',
          61 => 'Mazraat Aarab ej Jall',
          62 => 'Mazraat Ain el Qantara',
          63 => 'Mazraat Arab Soukkar',
          64 => 'Mazraat Arab Tobbaya',
          65 => 'Mazraat ej Joudaye',
          66 => 'Mazraat el Aite Niye',
          67 => 'Mazraat el Daoudiye',
          68 => 'Mazraat el Hsainiye',
          69 => 'Mazraat el Ouasta',
          70 => 'Mazraat el Yahoudiye',
          71 => 'Mazraat Iskandarouna',
          72 => 'Mazraat Jemjim',
          73 => 'Mazraat Khaizarane',
          74 => 'Mazraat Khoutaryet er Rezz',
          75 => 'Mazraat Matariyet Jbaa',
          76 => 'Mazraat Sekkaniye',
          77 => 'Mazraat Sinai',
          78 => 'Mazraat Zaita',
          79 => 'Merouaniye',
          80 => 'Mghairiye',
          81 => 'Mhaidle',
          82 => 'Miyeh ou Miyeh',
          83 => 'Mrah Kiouane',
          84 => 'Msaileh',
          85 => 'Najjaryie',
          86 => 'Oussamiyat',
          87 => 'Qaaqaaii es Snoubar',
          88 => 'Qennarit',
          89 => 'Qiyaa',
          90 => 'Qnaitra',
          91 => 'Qraiye Saida',
          92 => 'Saida',
          93 => 'Saida Ed Dekermane',
          94 => 'Saksakiye',
          95 => 'Salhiye',
          96 => 'Sarafand',
          97 => 'Sari',
          98 => 'Sfenti',
          99 => 'Sinai',
          100 => 'Snaiber',
          101 => 'Tanbourit',
          102 => 'Tebna',
          103 => 'Toufahta',
          104 => 'Wastani',
          105 => 'Zaghdraiya',
          106 => 'Zaita',
          107 => 'Zrariye',
        );

        $Saida1 = array (
          0 => 'عبرا',
          1 => 'عدّوسية',
          2 => 'عدلون',
          3 => 'عنقون',
          4 => 'العاقبية',
          5 => 'عقتنيت',
          6 => 'عرنابة',
          7 => 'ابو الاسود',
          8 => 'عين الدلب',
          9 => 'عين الحلوة',
          10 => 'اركي',
          11 => 'أرزي',
          12 => 'بابلية',
          13 => 'برتي',
          14 => 'بيسارية',
          15 => 'بنعفول',
          16 => 'بقسطا',
          17 => 'براك التل',
          18 => 'برامية',
          19 => 'الداودية',
          20 => 'درب السيم',
          21 => 'دير تقلا',
          22 => 'الدكرمان',
          23 => 'ضهور درب السيم',
          24 => 'أشرفية المية ومية',
          25 => 'محمودية',
          26 => 'روايس',
          27 => 'الزهراني',
          28 => 'غسانية',
          29 => 'غازية',
          30 => 'حبابية',
          31 => 'حجة',
          32 => 'حارة صيدا',
          33 => 'حارتية',
          34 => 'هلالية صيدا',
          35 => 'إنصارية',
          36 => 'جزيرة صيدا',
          37 => 'جديدة أرزي',
          38 => 'جنجلاية',
          39 => 'كفريا',
          40 => 'كوثرية السياد',
          41 => 'كفر بدَه',
          42 => 'كفربيت',
          43 => 'كفر شلال',
          44 => 'كفرحتى',
          45 => 'كفرملكي صيدا',
          46 => 'خنوسية',
          47 => 'الخرائب صيدا',
          48 => 'خرطوم',
          49 => 'خزيز',
          50 => 'خربة عين القناطر',
          51 => 'خربة البصل',
          52 => 'خربة الدوير صيدا',
          53 => 'لوبية',
          54 => 'معمارية',
          55 => 'معمرية الخراب',
          56 => 'مغدوشة',
          57 => 'مجدليون',
          58 => 'مقسم الجوهري',
          59 => 'مطرية الشومر',
          60 => 'مزرعة العبودية',
          61 => 'مزرعة عرب الجل',
          62 => 'مزرعة عين القنطرة',
          63 => 'مزرعة عرب سكر',
          64 => 'مزرعة عرب طبَايا',
          65 => 'مزرعة الجودية',
          66 => 'مزرعة العيتانية',
          67 => 'مزرعة الداودية',
          68 => 'مزرعة الحسينية',
          69 => 'مزرعة الواسطة',
          70 => 'مزرعة اليهودية',
          71 => 'مزرعة إسكندرونة',
          72 => 'مزرعة جمجيم',
          73 => 'مزرعة خيزران',
          74 => 'مزرعة كوثرية الرز',
          75 => 'مزرعة مطيرية جباع',
          76 => 'مزرعة السكنية',
          77 => 'مزرعة سيناي',
          78 => 'مزرعة زيتا',
          79 => 'مروانية',
          80 => 'مغيرية',
          81 => 'المحيدلة',
          82 => 'مية ومية',
          83 => 'مراح كيوان',
          84 => 'المصيلح',
          85 => 'نجارية',
          86 => 'الاوساميات',
          87 => 'قعقعية الصنوبر',
          88 => 'قناريت',
          89 => 'قياعة',
          90 => 'القنيطرة',
          91 => 'قرية صيدا',
          92 => 'صيدا',
          93 => 'صيدا الدكرمان',
          94 => 'سكسكية',
          95 => 'صالحية',
          96 => 'صرفند',
          97 => 'ساري',
          98 => 'سفنتا',
          99 => 'سيناي',
          100 => 'مزرعة سنيبر',
          101 => 'طنبوريت',
          102 => 'تبنا',
          103 => 'تفاحتا',
          104 => 'الوسطاني',
          105 => 'زغدرايا',
          106 => 'زيتا',
          107 => 'زرارية',
        );

        /*for ($i=0; $i < count($Saida) ; $i++) {
            if(isset($Saida[$i])){
                Area::insert([
                    'caza_id' => 23,
                    'name' => $Saida[$i],
                    'arabic' => $Saida1[$i]
                ]);
            }
        }*/

        $Sour = array (
          0 => 'Aabbassiye',
          1 => 'Aaitit',
          2 => 'Aalma ech Chaab',
          3 => 'Aamrane',
          4 => 'Aazziye',
          5 => 'Abou Chach',
          6 => 'Ain Abu Aabdalla',
          7 => 'Ain Baal',
          8 => 'Arzoun',
          9 => 'Bafliye',
          10 => 'Barich',
          11 => 'Batouliye',
          12 => 'Bazouriye',
          13 => 'Bedias',
          14 => 'Bestiyat',
          15 => 'Biyad Sour',
          16 => 'Borj ech Chmali',
          17 => 'Borj el Haoua',
          18 => 'Borj el Qibli',
          19 => 'Borj Rahhal',
          20 => 'Bourghliye',
          21 => 'Boustane Sour',
          22 => 'Btaichiye',
          23 => 'Chaaitiyeh',
          24 => 'Chabriha',
          25 => 'Chahour',
          26 => 'Chamaa',
          27 => 'Charnaiye',
          28 => 'Chehabiye',
          29 => 'Chihine',
          30 => 'Debaal',
          31 => 'Deir Aamess',
          32 => 'Deir Kifa',
          33 => 'Deir Qanoun',
          34 => 'Deir Qanoun en Nahr',
          35 => 'Derdghaiya',
          36 => 'Dhaira',
          37 => 'Ech Choumara',
          38 => 'Ed Dikiye',
          39 => 'El Bass',
          40 => 'El Biyada',
          41 => 'El Borj En-Naqoura',
          42 => 'El Kleile',
          43 => 'El Ouardani',
          44 => 'Er Rafid',
          45 => 'Hallousiyet el Faouqa',
          46 => 'Halloussiye',
          47 => 'Hammadiye',
          48 => 'Hamoul',
          49 => 'Hannaouiye',
          50 => 'Hanniye',
          51 => 'Haumeiri',
          52 => 'Iskandarouna Sour',
          53 => 'Jannata',
          54 => 'Jbal el Botm',
          55 => 'Jebbain',
          56 => 'Jijim',
          57 => 'Jouaiya',
          58 => 'Jour en Nakhl',
          59 => 'Kfarnay',
          60 => 'Knisse Sour',
          61 => 'Labboune',
          62 => 'Maachouq',
          63 => 'Maaliye',
          64 => 'Maarake',
          65 => 'Maaroub',
          66 => 'Machta El Aaziye',
          67 => 'Mahrouneh',
          68 => 'Majdel Zoun',
          69 => 'Malkeit es Sahel',
          70 => 'Mansouri',
          71 => 'Marnaba',
          72 => 'Marouahine',
          73 => 'Matmoura',
          74 => 'Mazraat Aaiye',
          75 => 'Mazraat Ain ez Zarqa',
          76 => 'Mazraat Biout es Siyad',
          77 => 'Mazraat Bsaile',
          78 => 'Mazraat Deir Hanna',
          79 => 'Mazraat Mechref',
          80 => 'Mheilib',
          81 => 'Mjadel',
          82 => 'Nabi Qassem',
          83 => 'Naffakhiye',
          84 => 'Naqoura',
          85 => 'Niha Sour',
          86 => 'Ouadi Jilou',
          87 => 'Oum Toute',
          88 => 'Qalaat Maroun',
          89 => 'Qana',
          90 => 'Qasmiye',
          91 => 'Rachidiye',
          92 => 'Ras el Ain',
          93 => 'Rechkananey',
          94 => 'Rmadiyeh',
          95 => 'Salaa',
          96 => 'Sammaaiye',
          97 => 'Siddiqine',
          98 => 'Sour',
          99 => 'Srifa',
          100 => 'Taibe Sour',
          101 => 'Tair Debba',
          102 => 'Tair Filsay',
          103 => 'Tair Harfa',
          104 => 'Tair Semhat',
          105 => 'Tair Zebna',
          106 => 'Touairi',
          107 => 'Toura',
          108 => 'Yarine',
          109 => 'Ynouh',
          110 => 'Zabqine',
          111 => 'Zahriye',
          112 => 'Zalloutiye',
        );

        $Sour1 = array (
          0 => 'عباسية',
          1 => 'عيتيت',
          2 => 'علما الشعب',
          3 => 'عمران',
          4 => 'عزِّيه',
          5 => 'أبو شاش',
          6 => 'عين أبو عبدالله',
          7 => 'عين بعل',
          8 => 'ارزون',
          9 => 'بافليه',
          10 => 'باريش',
          11 => 'باتوليه',
          12 => 'بازورية',
          13 => 'بدياس',
          14 => 'بستيات',
          15 => 'البياض صور',
          16 => 'برج الشمالي',
          17 => 'برج الهوا',
          18 => 'برج قبلي',
          19 => 'برج رحال',
          20 => 'برغلية',
          21 => 'بستان صور',
          22 => 'بطيشية',
          23 => 'شعيتية',
          24 => 'شبريحا',
          25 => 'شحور',
          26 => 'شمع',
          27 => 'شارنية',
          28 => 'شهابية',
          29 => 'شيحين',
          30 => 'دبعل',
          31 => 'ديرعامص',
          32 => 'دير كيفا',
          33 => 'دير قانون',
          34 => 'دير قانون النهر',
          35 => 'دردغايا',
          36 => 'ظهيرة',
          37 => 'الشومارا',
          38 => 'الديكية',
          39 => 'البصَ',
          40 => 'بياضة',
          41 => 'برج الناقورة',
          42 => 'قليلة',
          43 => 'ورداني',
          44 => 'الرافد',
          45 => 'حلوسية الفوقا',
          46 => 'حلوسية',
          47 => 'حمَادية',
          48 => 'حامول',
          49 => 'حناوي',
          50 => 'حنية',
          51 => 'حميري',
          52 => 'إسكندرونة',
          53 => 'جناتا',
          54 => 'جبال البطم',
          55 => 'جبين',
          56 => 'ججيم',
          57 => 'جويا',
          58 => 'جوار النخل',
          59 => 'كفرنية',
          60 => 'كنيسة صور',
          61 => 'لبونة',
          62 => 'معشوق',
          63 => 'معليَة',
          64 => 'معركة',
          65 => 'معروب',
          66 => 'مشتى العزِية',
          67 => 'محرونه',
          68 => 'مجدل زون',
          69 => 'مالكية الساحل',
          70 => 'المنصوري',
          71 => 'مرنبا',
          72 => 'مروحين',
          73 => 'المطمورة',
          74 => 'مزرعة عيا',
          75 => 'مزرعة عين الزرقا',
          76 => 'مزرعة بيوت السياد',
          77 => 'مزرعة بسيلة',
          78 => 'مزرعة دير حنا',
          79 => 'مزرعة المشرف',
          80 => 'محيليب',
          81 => 'المجادل',
          82 => 'نبي قاسم',
          83 => 'نفاخية',
          84 => 'الناقورة',
          85 => 'نيحا صور',
          86 => 'وادي جيلو',
          87 => 'ام التوت',
          88 => 'قلعة مارون',
          89 => 'قانا',
          90 => 'قاسمية',
          91 => 'الرشيدية',
          92 => 'راس العين',
          93 => 'رشكنانيه',
          94 => 'رمادية',
          95 => 'سلعا',
          96 => 'سماعية',
          97 => 'صديقين',
          98 => 'صور',
          99 => 'صريفا',
          100 => 'الطيبة صور',
          101 => 'طير دبّه',
          102 => 'طير فلسيه',
          103 => 'طير حرفا',
          104 => 'طير سمحات',
          105 => 'طير زبنا',
          106 => 'طويري',
          107 => 'طورا',
          108 => 'يارين',
          109 => 'يانوح صور',
          110 => 'زبقين',
          111 => 'زهيرية',
          112 => 'مزرعة الزلوطية',
        );

        for ($i=0; $i < count($Sour) ; $i++) {
            if(isset($Sour[$i])){
                Area::insert([
                    'caza_id' => 24,
                    'name' => $Sour[$i],
                    'arabic' => $Sour1[$i]
                ]);
            }
        }
    }
}
