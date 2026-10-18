<?php

namespace App\Http\Requests;

use App\Sdq\FormOptions;
use App\Sdq\SdqItems;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validation shared by the pre-test and post-test forms (web and API).
 */
abstract class TestRequest extends FormRequest
{
    abstract protected function isPostTest(): bool;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $form = $this->input('form');
        [$min, $max] = FormOptions::ageRange((string) $form);

        $rules = [
            'form' => ['required', Rule::in(FormOptions::FORMS)],
            'may_i_start_now' => ['required', Rule::in(FormOptions::CONSENT)],
            'submit' => ['sometimes', Rule::in(['save', 'submit'])],
        ];

        // When consent is refused nothing else is required.
        if ($this->input('may_i_start_now') === 'no') {
            return $rules;
        }

        $rules += [
            'category' => ['required', Rule::in(FormOptions::CATEGORIES)],
            'agency_name' => ['required', 'string', 'max:50'],
            'donor_name' => ['required', Rule::in(FormOptions::DONORS)],
            'interview_date' => ['required', 'date', 'before:'.now()->addDays(2)->toDateString()],
            'interviewers_name' => ['required', 'string', 'max:50'],
            'age' => ['required', 'integer', "between:{$min},{$max}"],
            'gender' => ['required', Rule::in(FormOptions::GENDERS)],
            'nationality' => ['required', Rule::in(FormOptions::NATIONALITIES)],
            'other_nationality' => ['required_if:nationality,Other Nationality', 'nullable', 'string', 'max:100'],
            'gouvarnate' => ['required', 'exists:gouvernate,id'],
            'caza' => ['required', 'exists:caza,id'],
            'area' => ['required', 'exists:area,id'],
            'gateway_type' => ['required', Rule::in(FormOptions::GATEWAY_TYPES)],
            'p_code' => ['nullable', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'altitude' => ['nullable', 'numeric'],
            'accuracy' => ['nullable', 'numeric'],
            'child_code' => ['nullable', 'string', 'max:50'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'do_the_child_receive_any_other_child_protection_services' => ['nullable', 'array'],
            'do_the_child_receive_any_other_child_protection_services.*' => [Rule::in(FormOptions::SERVICES)],
        ];

        $submitting = $this->input('submit', 'submit') === 'submit';
        foreach (SdqItems::all() as $item) {
            $rules[$item] = [$submitting ? 'required' : 'nullable', Rule::in(SdqItems::ANSWERS)];
        }

        if ($this->isPostTest()) {
            $rules['dropout_reason'] = [$submitting ? 'required' : 'nullable', Rule::in(FormOptions::DROPOUT_REASONS)];
            $rules['justify_the_dropout_reason'] = ['nullable', 'string', 'max:255'];
            $rules['number_of_hours_that_the_child_attended'] = [$submitting ? 'required' : 'nullable', 'numeric', 'min:0'];
            $rules['total_number_of_hours_in_your_program'] = [$submitting ? 'required' : 'nullable', 'numeric', 'min:0'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        foreach (SdqItems::all() as $item) {
            if ($this->has($item) && is_string($this->input($item))) {
                $this->merge([$item => strtolower($this->input($item))]);
            }
        }
    }

    public function isSubmitting(): bool
    {
        return $this->input('submit', 'submit') === 'submit';
    }
}
