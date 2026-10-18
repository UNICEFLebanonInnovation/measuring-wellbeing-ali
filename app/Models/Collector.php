<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collector extends Model
{
    use HasFactory;

    protected $table = 'collectors';

    protected $fillable = ['user_id', 'partner_id', 'name', 'prefix', 'city', 'is_subpartner', 'sub_partner'];

    protected function casts(): array
    {
        return ['is_subpartner' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** partner_id holds the partner's user id. */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'collector_id', 'user_id');
    }
}
