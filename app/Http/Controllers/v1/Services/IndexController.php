<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Models\Service;
use function config;
use App\Http\Resources\V1\ServiceResource;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(): Response
    {
        // $services = Service::query()->simplePaginate(config('app.pagination.limit'));
        $services = QueryBuilder::for(
            subject: Service::class,
        )->allowedIncludes(
            includes: [
                'checks',
            ],
        )->getEloquentBuilder()->simplePaginate(
            perPage: config(key: 'app.pagination.limit')
        );
        
        return new JsonResponse(
            data: ServiceResource::collection(
                resource: $services,
            ),
        );
    }
}
