<?php

namespace App\Observers;

use App\Enums\CacheKey;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class ServiceObserver
{
    public function created(Service $service): void
    {
        $this->forgetServicesForUser(
            id: $service->user_id,
        );
    }

    public function updated(Service $service): void
    {
        $this->forgetServicesForUser(
            id: $service->user_id,
        );

        $this->forgetService(
            ulid: $service->id,
        );
    }

    public function deleted(Service $service): void
    {
        $this->forgetServicesForUser(
            id: $service->user_id,
        );

        $this->forgetService(
            ulid: $service->id,
        );
    }

    private function forgetServicesForUser(string $id): void
    {
        Cache::forget(
            CacheKey::User_services->value . '_' . $id,
        );
    }

    private function forgetService(string $ulid): void
    {
        Cache::forget(
            key: CacheKey::Service->value . '_' . $ulid,
        );
    }
}
