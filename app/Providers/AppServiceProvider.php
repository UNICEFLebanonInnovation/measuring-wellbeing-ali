<?php

namespace App\Providers;

use App\Sdq\ApplicationCodeGenerator;
use App\Sdq\SdqScorer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SdqScorer::class, fn () => SdqScorer::fromConfig());
        $this->app->bind(ApplicationCodeGenerator::class, fn () => ApplicationCodeGenerator::fromConfig());
    }

    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Vite::usePrefetchStrategy('aggressive');
        Password::defaults(fn () => Password::min(8)->letters()->numbers());
    }
}
