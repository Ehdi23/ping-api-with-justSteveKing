<?php

declare(strict_types=1);

namespace App\Jobs\Services;

use App\Http\Payloads\V1\CreateService;
use App\Models\Service;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;

use function PHPUnit\Framework\callback;

class UpdateService implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly CreateService $payload,
        public readonly Service $service
    ){}

    public function handle(DatabaseManager $database, Service $service): void
    {
        $database->transaction(
            callback: fn() => $this->service->update(
                attributes: $this->payload->toArray(),
            ),
            attempts: 3,
        );
    }
}
