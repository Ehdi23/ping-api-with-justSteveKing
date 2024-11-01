<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Enums\CacheKey;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\V1\ServiceResource;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;

final class ShowController
{
    public function __invoke(Request $request, string $ulid): Response
    {
        Cache::forever(
            key: CacheKey::Service->value . '_' . $ulid,
            value: $service = Service::query()->findOrFail(
                id: $ulid,
            )
        );
        if (! Gate::allows('view', $service)) {
            throw new UnauthorizedException(
                message: __('services.v1.show.failure'),
                code: Response::HTTP_FORBIDDEN
            );
        }

        return new JsonResponse(
            data: new ServiceResource(
                resource: $service,
            ),
        );
    }
}
