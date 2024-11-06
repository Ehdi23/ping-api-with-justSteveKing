<?php

declare(strict_types=1);

use App\Console\Commands\Ping;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command(
    command: Ping::class,
)->everyFiveMinutes()->withoutOverlapping()->onOneServer();
