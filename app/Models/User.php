<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_PARTNER = 'partner';

    public const ROLE_COLLECTOR = 'collector';

    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'zone', 'address', 'fax',
        'is_active', 'is_readonly', 'password', 'locale', 'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token', 'api_token'];

    protected $appends = ['name'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_readonly' => 'boolean',
        ];
    }

    public function getNameAttribute(): string
    {
        return trim(($this->firstname ?? '').' '.($this->lastname ?? ''));
    }

    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class, 'user_id');
    }

    public function collector(): HasOne
    {
        return $this->hasOne(Collector::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function isPartner(): bool
    {
        return $this->hasRole(self::ROLE_PARTNER);
    }

    public function isCollector(): bool
    {
        return $this->hasRole(self::ROLE_COLLECTOR);
    }

    /** The user id that owns applications for this account's partner (the partner's user id). */
    public function partnerUserId(): ?int
    {
        if ($this->isPartner()) {
            return $this->id;
        }
        if ($this->isCollector()) {
            return $this->collector?->partner_id;
        }

        return null;
    }

    /** Ids of collector users that belong to the partner this user represents. */
    public function collectorUserIds(): array
    {
        $partnerUserId = $this->partnerUserId();
        if ($partnerUserId === null) {
            return [];
        }

        return Collector::where('partner_id', $partnerUserId)->pluck('user_id')->all();
    }
}
