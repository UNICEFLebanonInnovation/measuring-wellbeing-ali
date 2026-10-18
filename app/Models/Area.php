<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    protected $table = 'area';

    protected $fillable = ['caza_id', 'gouvernate_id', 'name', 'arabic'];

    public function caza(): BelongsTo
    {
        return $this->belongsTo(Caza::class, 'caza_id');
    }

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Gouvernate::class, 'gouvernate_id');
    }
}
