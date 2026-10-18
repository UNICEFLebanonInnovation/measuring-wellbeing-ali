<?php

namespace App\Sdq;

use App\Models\Application;
use App\Models\Collector;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Generates application codes on the server (the legacy system generated
 * them on the device, which caused collisions when a collector used both
 * the app and the web form).
 *
 * Format (config sdq.code_format): {year}-{partner}-{collector}-{n}
 * where n is a running number per collector. Generation runs inside a
 * transaction with a row lock on the collector so concurrent requests
 * cannot produce the same code.
 */
final class ApplicationCodeGenerator
{
    public function __construct(private readonly string $format) {}

    public static function fromConfig(): self
    {
        return new self((string) config('sdq.code_format', '{year}-{partner}-{collector}-{n}'));
    }

    /**
     * Reserve the next code for the given collector user.
     *
     * @return array{code: string, sequence: int, year: int, partner: Partner, collector: Collector}
     */
    public function next(User $collectorUser, ?int $year = null): array
    {
        $year ??= (int) now()->format('Y');

        return DB::transaction(function () use ($collectorUser, $year) {
            $collector = Collector::where('user_id', $collectorUser->id)->lockForUpdate()->first();
            if (! $collector) {
                throw new RuntimeException('Collector profile not found for this user.');
            }
            if (empty($collector->prefix)) {
                throw new RuntimeException('Collector prefix not set.');
            }
            $partner = Partner::where('user_id', $collector->partner_id)->first();
            if (! $partner || empty($partner->prefix)) {
                throw new RuntimeException('Partner prefix not set.');
            }

            $sequence = (int) Application::withTrashed()
                ->where('collector_id', $collectorUser->id)
                ->max('sequence');

            do {
                $sequence++;
                $code = $this->format($year, $partner->prefix, $collector->prefix, $sequence);
            } while (Application::withTrashed()->where('code', $code)->exists());

            return [
                'code' => $code,
                'sequence' => $sequence,
                'year' => $year,
                'partner' => $partner,
                'collector' => $collector,
            ];
        });
    }

    public function format(int $year, string $partnerPrefix, string $collectorPrefix, int $n): string
    {
        return strtr($this->format, [
            '{year}' => (string) $year,
            '{partner}' => strtoupper(trim($partnerPrefix)),
            '{collector}' => strtoupper(trim($collectorPrefix)),
            '{n}' => (string) $n,
        ]);
    }
}
