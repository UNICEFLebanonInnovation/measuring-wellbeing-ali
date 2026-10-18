<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $collector = $this->collector;
        $partner = $this->isPartner() ? $this->partner : $collector?->partner;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'roles' => $this->getRoleNames()->values()->all(),
            'is_readonly' => (bool) $this->is_readonly,
            'locale' => $this->locale,
            'partner' => $partner ? [
                'user_id' => $partner->user_id,
                'name' => $partner->name,
                'prefix' => $partner->prefix,
                'max_app_per_year' => $partner->max_app_per_year,
            ] : null,
            'collector' => $collector ? [
                'prefix' => $collector->prefix,
                'city' => $collector->city,
            ] : null,
        ];
    }
}
