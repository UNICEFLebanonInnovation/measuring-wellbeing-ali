<?php

namespace App\Models;

use App\Sdq\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['name'];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'status');
    }

    private static ?array $byName = null;

    private static ?array $byId = null;

    public static function idOf(ApplicationStatus $status): int
    {
        self::loadLookup();
        if (! isset(self::$byName[$status->value])) {
            $row = self::firstOrCreate(['name' => $status->value]);
            self::flushLookup();
            self::loadLookup();

            return $row->id;
        }

        return self::$byName[$status->value];
    }

    public static function nameOf(?int $id): ?string
    {
        if ($id === null) {
            return null;
        }
        self::loadLookup();

        return self::$byId[$id] ?? null;
    }

    public static function idsOf(ApplicationStatus ...$statuses): array
    {
        return array_map(fn (ApplicationStatus $s) => self::idOf($s), $statuses);
    }

    public static function flushLookup(): void
    {
        self::$byName = null;
        self::$byId = null;
        Cache::forget('sdq.status.lookup');
    }

    private static function loadLookup(): void
    {
        if (self::$byName !== null) {
            return;
        }
        $rows = Cache::remember('sdq.status.lookup', 3600, fn () => self::query()->pluck('id', 'name')->all());
        self::$byName = $rows;
        self::$byId = array_flip($rows);
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::flushLookup());
        static::deleted(fn () => self::flushLookup());
    }
}
