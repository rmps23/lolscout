<?php

namespace App\Providers;

use App\Services\Riot\RiotClient;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RiotClient::class, fn () => new RiotClient(
            config('services.riot.key'),
            config('services.riot.platform'),
            config('services.riot.region'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination.lolscout');

        if ($this->app->isProduction()) {
            URL::forceHttps();
        }

        Password::defaults(fn () => $this->app->isProduction()
            ? Password::min(10)->letters()->numbers()->uncompromised()
            : Password::min(10)->letters()->numbers());
    }
}
