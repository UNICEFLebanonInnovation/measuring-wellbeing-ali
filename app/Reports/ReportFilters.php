<?php

namespace App\Reports;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Filters common to every report. Partners are always restricted to
 * their own data by Application::visibleTo(); the partner filter is
 * honoured for administrators only.
 */
final readonly class ReportFilters
{
    public function __construct(
        public User $user,
        public ?int $year = null,
        public ?int $partner = null,
        public ?int $governorate = null,
        public ?string $gender = null,
        public ?string $form = null,
        public ?string $nationality = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $data = $request->validate([
            'partner' => ['nullable', 'integer'],
            'governorate' => ['nullable', 'integer'],
            'gender' => ['nullable', 'in:male,female'],
            'form' => ['nullable', 'in:Form 6-11,Form 12-17'],
            'nationality' => ['nullable', 'string', 'max:50'],
        ]);
        $user = $request->user();

        return new self(
            user: $user,
            year: $request->session()->get('year') ? (int) $request->session()->get('year') : null,
            partner: $user->isAdmin() && ! empty($data['partner']) ? (int) $data['partner'] : null,
            governorate: ! empty($data['governorate']) ? (int) $data['governorate'] : null,
            gender: $data['gender'] ?? null,
            form: $data['form'] ?? null,
            nationality: $data['nationality'] ?? null,
        );
    }

    /** Partner filter, honoured for administrators only. */
    public function partnerId(): ?int
    {
        return $this->user->isAdmin() ? $this->partner : null;
    }

    public function toArray(): array
    {
        return [
            'partner' => $this->partner,
            'governorate' => $this->governorate,
            'gender' => $this->gender,
            'form' => $this->form,
            'nationality' => $this->nationality,
        ];
    }
}
