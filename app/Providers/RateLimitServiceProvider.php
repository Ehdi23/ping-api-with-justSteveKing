<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for(
            name: 'api',
            callback: static fn(): Limit => Limit::perMinute(
                maxAttempts: 60,
            ),
        );

        RateLimiter::for(
            name: 'auth',
            callback: static fn(): Limit => Limit::perMinute(
                maxAttempts: 5,
            ),
        );
    }
}
