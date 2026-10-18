<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Sdq\FormOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var User|null $user */
        $user = $request->user();
        $locale = app()->getLocale();

        return [
            ...parent::share($request),
            'appName' => config('app.name'),
            'locale' => $locale,
            'locales' => ['en' => 'English', 'ar' => 'العربية'],
            'translations' => fn () => $this->translations($locale),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()->all(),
                    'is_admin' => $user->isAdmin(),
                    'is_partner' => $user->isPartner(),
                    'is_collector' => $user->isCollector(),
                    'is_readonly' => (bool) $user->is_readonly,
                    'partner_name' => $user->isPartner() ? $user->partner?->name : ($user->isCollector() ? $user->collector?->partner?->name : null),
                ] : null,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'filters' => [
                'year' => fn () => $request->session()->get('year'),
            ],
            'options' => fn () => FormOptions::all(),
            'apkUrl' => config('sdq.apk_url'),
        ];
    }

    private function translations(string $locale): array
    {
        $out = [];
        foreach (['messages', 'ui', 'reports'] as $file) {
            $lines = Lang::get($file, [], $locale);
            foreach (is_array($lines) ? $lines : [] as $key => $value) {
                if (is_string($value)) {
                    $out[$file.'.'.$key] = $value;
                }
            }
        }

        return $out;
    }
}
