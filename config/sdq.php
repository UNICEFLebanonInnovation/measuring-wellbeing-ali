<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scoring policy
    |--------------------------------------------------------------------------
    |
    | "documented" applies the formula from the UNICEF scoring document
    | (average of answered items x 5 + 0.5, NA omitted). "legacy" reproduces
    | the arithmetic of the original application (sum of answered items +
    | 0.5). Use "legacy" only when verifying migrated data against the
    | reference environment. See docs/ARCHITECTURE.md.
    |
    */
    'scoring_policy' => env('SDQ_SCORING_POLICY', 'documented'),

    /*
    | A questionnaire with more than this many "NA" answers is recorded with
    | status "NA" and excluded from analysis (legacy rule: > 3).
    */
    'max_na_answers' => (int) env('SDQ_MAX_NA_ANSWERS', 3),

    /*
    | Format of generated application codes. Placeholders: {year}, {partner},
    | {collector}, {n}. The 2021 guidance note uses YEAR-PARTNER-COLLECTOR-N.
    */
    'code_format' => env('SDQ_CODE_FORMAT', '{year}-{partner}-{collector}-{n}'),

    /*
    | Whether the partner's yearly quota (partners.max_app_per_year) is
    | enforced per calendar year (true) or over all time as the legacy
    | application did (false).
    */
    'quota_per_year' => (bool) env('SDQ_QUOTA_PER_YEAR', true),

    /*
    | Public URL of the current Android APK shown in the UI.
    */
    'apk_url' => env('SDQ_APK_URL'),

];
