<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Governorate (legacy spelling kept for the table name). */
class Gouvernate extends Model
{
    protected $table = 'gouvernate';

    protected $fillable = ['name', 'arabic'];

    public function cazas(): HasMany
    {
        return $this->hasMany(Caza::class, 'gouvernate_id');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'gouvernate_id');
    }
}
