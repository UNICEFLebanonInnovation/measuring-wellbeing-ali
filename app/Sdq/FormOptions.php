<?php

namespace App\Sdq;

/**
 * Closed option lists of the questionnaire. Values are stored verbatim in
 * application_value, so they must stay identical to the legacy ones.
 */
final class FormOptions
{
    public const FORMS = ['Form 6-11', 'Form 12-17'];

    public const CATEGORIES = [
        'Child Labour Activity',
        'Child Mariage Activity',
        'Violent Discipline  Activity',
        'Other',
    ];

    public const DONORS = [
        'BPRM', 'DFATD - Canada', 'DFID', 'EC - DEVCO', 'ECHO', 'ERF', 'SiDA',
        'UNDP', 'UNFPA', 'UNHCR', 'UNICEF', 'UNRWA', 'Other',
    ];

    public const GENDERS = ['male', 'female'];

    public const NATIONALITIES = ['Lebanese', 'Syrian', 'Palestinian', 'Other Nationality'];

    public const GATEWAY_TYPES = [
        'Border crossing, Other',
        'Community center',
        'Informal Settlement',
        'Municipality',
        'Palestinian camp',
        'Palestinian gathering',
        'Primary Health Center',
        'School',
        'Secondary Health Center',
        'Social Development Center',
        'UNHCR registration center',
    ];

    public const DID_NOT_DROP_OUT = 'Did Not Drop Out';

    public const DROPOUT_REASONS = [
        self::DID_NOT_DROP_OUT,
        'Child was no longer allowed to access activity',
        'Child said he did not want to participate in activity any longer',
        'Relocation within Lebanon',
        'Returned to Syria',
        'Left for third country',
        'Other reason',
    ];

    public const SERVICES = [
        'Case management',
        'Community based Child protection activities',
        'Formal Education',
        'Non-formal education (VET programs…)',
    ];

    /** Reasons a partner can give when a child's score got worse. */
    public const DECREASE_REASONS = [
        'Family situation changed',
        'Child dropped out of other services',
        'Child experienced a new protection concern',
        'Post-test administered differently from pre-test',
        'Other',
    ];

    public const CONSENT = ['yes', 'no'];

    public static function ageRange(string $form): array
    {
        return $form === 'Form 6-11' ? [6, 11] : [12, 17];
    }

    public static function all(): array
    {
        return [
            'forms' => self::FORMS,
            'categories' => self::CATEGORIES,
            'donors' => self::DONORS,
            'genders' => self::GENDERS,
            'nationalities' => self::NATIONALITIES,
            'gateway_types' => self::GATEWAY_TYPES,
            'dropout_reasons' => self::DROPOUT_REASONS,
            'services' => self::SERVICES,
            'decrease_reasons' => self::DECREASE_REASONS,
            'answers' => SdqItems::ANSWERS,
            'items' => SdqItems::all(),
        ];
    }
}
