<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Enums\CacheKey;
use App\Models\Service;
use function config;
use App\Http\Resources\V1\ServiceResource;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Constraint\Operator;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexController
{
    public function __invoke(): Response
    {
        // cache all services for the current user.
        Cache::forever(
            key: CacheKey::User_services->value . '_' . auth()->id(),
            value: $cachedServices = Service::query()->where(
                column: 'user_id',
                operator: '=',
                value: auth()->id(),
            )->get()
        );
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
