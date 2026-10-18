<?php

namespace App\Http\Resources;

use App\Models\Application;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Application */
class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'client_uuid' => $this->client_uuid,
            'year' => $this->year,
            'language' => $this->language,
            'status' => Status::nameOf($this->status),
            'status_id' => $this->status,
            'partner_id' => $this->partner_id,
            'collector_id' => $this->collector_id,
            'pre_test_date' => $this->pre_test_date?->toDateString(),
            'post_test_date' => $this->post_test_date?->toDateString(),
            'change' => $this->whenLoaded('preTest', fn () => $this->relationLoaded('postTest') ? $this->change() : null),
            'pre_test' => $this->whenLoaded('preTest', fn () => $this->preTest ? new ApplicationValueResource($this->preTest) : null),
            'post_test' => $this->whenLoaded('postTest', fn () => $this->postTest ? new ApplicationValueResource($this->postTest) : null),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
