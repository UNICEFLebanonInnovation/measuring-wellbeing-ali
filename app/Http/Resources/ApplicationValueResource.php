<?php

namespace App\Http\Resources;

use App\Models\ApplicationValue;
use App\Sdq\SdqItems;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ApplicationValue */
class ApplicationValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $answers = [];
        foreach (SdqItems::all() as $item) {
            $answers[$item] = $this->{$item};
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'category' => $this->category,
            'child_code' => $this->child_code,
            'form' => $this->form,
            'agency_name' => $this->agency_name,
            'donor_name' => $this->donor_name,
            'interview_date' => $this->interview_date,
            'interviewers_name' => $this->interviewers_name,
            'age' => $this->age,
            'gender' => $this->gender,
            'nationality' => $this->nationality,
            'other_nationality' => $this->other_nationality,
            'gouvarnate' => $this->gouvarnate,
            'caza' => $this->caza,
            'area' => $this->area,
            'gateway_type' => $this->gateway_type,
            'p_code' => $this->p_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'altitude' => $this->altitude,
            'accuracy' => $this->accuracy,
            'may_i_start_now' => $this->may_i_start_now,
            'answers' => $answers,
            'comment' => $this->comment,
            'number_of_hours_that_the_child_attended' => $this->number_of_hours_that_the_child_attended,
            'total_number_of_hours_in_your_program' => $this->total_number_of_hours_in_your_program,
            'dropout_reason' => $this->dropout_reason,
            'justify_the_dropout_reason' => $this->justify_the_dropout_reason,
            'services' => $this->servicesList(),
            'scores' => [
                'emotional_scale' => $this->emotional_scale,
                'conduct_scale' => $this->conduct_scale,
                'hyper_activity_scale' => $this->hyper_activity_scale,
                'peer_problem_scale' => $this->peer_problem_scale,
                'pro_social_scale' => $this->pro_social_scale,
                'na_count' => $this->na_count,
                'total' => $this->totalScore(),
            ],
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
