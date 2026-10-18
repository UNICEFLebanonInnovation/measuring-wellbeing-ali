<?php

namespace App\Sdq;

/**
 * Closed option lists of the questionnaire.
 *
 * The canonical spellings below are those of the Android application
 * (sdq-12.apk), which produced most of the production data. The legacy web
 * form used slightly different spellings and casing for a few values; those
 * are accepted and mapped by normalise() so both historical data and
 * requests from the old app validate.
 */
final class FormOptions
{
    public const FORMS = ['Form 6-11', 'Form 12-17'];

    public const CATEGORIES = [
        'Child Labour Activity',
        'Child Marriage Activity',
        'Violent Discipline Activity',
        'Other',
    ];

    public const DONORS = [
        'UNICEF', 'UNHCR', 'ERF', 'BPRM', 'SiDA', 'UNRWA', 'UNFPA', 'DFID', 'ECHO', 'UNDP',
        'DFATD - Canada', 'EC - DEVCO', 'Other',
    ];

    public const GENDERS = ['male', 'female'];

    public const NATIONALITIES = ['Lebanese', 'Syrian', 'Palestinian', 'Other Nationality'];

    public const GATEWAY_TYPES = [
        'Informal Settlement',
        'Social Development Center',
        'School',
        'Primary Health Center',
        'Secondary Health Center',
        'Municipality',
        'Community center',
        'Palestinian camp',
        'Palestinian gathering',
        'UNHCR registration center',
        'Border crossing',
        'Remotely',
        'Other',
    ];

    /** Partner agencies offered by the mobile application (free text is also accepted). */
    public const AGENCIES = [
        'ABAAD', 'AMEL', 'AND', 'ARC', 'ASMAE', 'CARE International', 'Caritas Lebanon', 'CONECRN', 'Dorcas',
        'Danish Refugee Council', 'Himaya', 'ICRC', 'Intersos', 'IOCC', 'IRC', 'KAFA', 'Makhzoumi Foundation',
        'Mercy Corps', 'Mouvement Social', 'MSF', 'Nabad', 'NRC', 'RAHMA', 'RESTART', 'Renee Mouawad Foundation',
        'RtP', 'Sanabel Al Janoub', 'SAWA', 'SCI', 'SIF', 'TDH-Italy', 'TDH-Lausanne', 'WCH', 'WVI', 'YNCA',
        'MAP-UK', 'Other',
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

    /** Legacy or client spellings => canonical value. Keys are compared case-insensitively. */
    private const ALIASES = [
        'category' => [
            'child mariage activity' => 'Child Marriage Activity',
            'violent discipline  activity' => 'Violent Discipline Activity',
        ],
        'gateway_type' => [
            'border crossing, other' => 'Border crossing',
        ],
        'may_i_start_now' => [
            'yes, permission is given' => 'yes',
            'no, permission is not given' => 'no',
            'yes' => 'yes',
            'no' => 'no',
        ],
        'dropout_reason' => [
            'لم ينسحب' => self::DID_NOT_DROP_OUT,
        ],
    ];

    public static function ageRange(string $form): array
    {
        return $form === 'Form 6-11' ? [6, 11] : [12, 17];
    }

    /**
     * Map values coming from the legacy web form or the Android app onto
     * the canonical lists. Unknown values are left untouched so validation
     * reports them.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalise(array $data): array
    {
        foreach (self::ALIASES as $field => $map) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $key = mb_strtolower(trim($data[$field]));
                if (isset($map[$key])) {
                    $data[$field] = $map[$key];
                }
            }
        }
        if (isset($data['gender']) && is_string($data['gender'])) {
            $data['gender'] = mb_strtolower(trim($data['gender']));
        }
        foreach (['category', 'gateway_type', 'nationality', 'donor_name', 'form', 'dropout_reason'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = self::canonicalCase($field, $data[$field]);
            }
        }
        $services = $data['do_the_child_receive_any_other_child_protection_services'] ?? null;
        if (is_array($services)) {
            $data['do_the_child_receive_any_other_child_protection_services'] = array_values(array_filter(
                $services,
                fn ($s) => is_string($s) && ! in_array(mb_strtolower(trim($s)), ['', 'no', 'none'], true),
            ));
        }

        return $data;
    }

    /** Match a value against its list ignoring case and surrounding spaces. */
    private static function canonicalCase(string $field, string $value): string
    {
        $list = match ($field) {
            'category' => self::CATEGORIES,
            'gateway_type' => self::GATEWAY_TYPES,
            'nationality' => self::NATIONALITIES,
            'donor_name' => self::DONORS,
            'form' => self::FORMS,
            'dropout_reason' => self::DROPOUT_REASONS,
            default => [],
        };
        $needle = mb_strtolower(trim($value));
        foreach ($list as $canonical) {
            if (mb_strtolower($canonical) === $needle) {
                return $canonical;
            }
        }

        return $value;
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
            'agencies' => self::AGENCIES,
            'dropout_reasons' => self::DROPOUT_REASONS,
            'services' => self::SERVICES,
            'decrease_reasons' => self::DECREASE_REASONS,
            'answers' => SdqItems::ANSWERS,
            'items' => SdqItems::all(),
        ];
    }
}
