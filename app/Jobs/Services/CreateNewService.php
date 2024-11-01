<?php

declare(strict_types=1);

namespace App\Jobs\Services;

use App\Models\Service;
use Illuminate\Queue\SerializesModels;
use App\Http\Payloads\V1\CreateService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\DatabaseManager;

final class CreateNewService implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public function __construct(
        public readonly CreateService $payload,
    ){}

    public function handle(DatabaseManager $database): void
    {
        $database->transaction(
            callback: fn() => Service::query()->create(
                attributes: $this->payload->toArray(),
            ),
            attempts: 3,
        );
    }
}
