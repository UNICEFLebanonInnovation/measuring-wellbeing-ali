<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A partner organisation (NGO). Note the legacy convention: collectors and
 * applications reference the partner by its *user id* (partners.user_id),
 * not by partners.id.
 */
class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = ['user_id', 'name', 'prefix', 'logo', 'max_app_per_year'];

    protected function casts(): array
    {
        return ['max_app_per_year' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function collectors(): HasMany
    {
        return $this->hasMany(Collector::class, 'partner_id', 'user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'partner_id', 'user_id');
    }
}
