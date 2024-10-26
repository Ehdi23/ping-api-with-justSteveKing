<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Services;

use App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

final class IndexController
{
    public function __invoke(): JsonResource
    {
        $services = Service::query()->simplePaginate(config('app.pagination.limit'));
        
        return new JsonResource($services);
    }
}