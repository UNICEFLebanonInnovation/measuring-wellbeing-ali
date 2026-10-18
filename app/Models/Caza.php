<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caza extends Model
{
    protected $table = 'caza';

    protected $fillable = ['gouvernate_id', 'name', 'arabic'];

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Gouvernate::class, 'gouvernate_id');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'caza_id');
    }
}
