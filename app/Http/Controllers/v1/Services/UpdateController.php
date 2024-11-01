<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Models\Service;
use Illuminate\Bus\Dispatcher;
use App\Jobs\Services\UpdateService;
use App\Http\Requests\V1\Services\WriteRequest;
use App\Http\Responses\V1\MessageResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

final readonly class UpdateController
{
    public function __construct(
        private Dispatcher $bus,
    ) {}

    public function __invoke(WriteRequest $request, Service $service): Responsable
    {
        if (! Gate::allows('update', Service::class)) {
            throw new UnauthorizedException(
                message: 'services.v1.update.failure',
                code: Response::HTTP_FORBIDDEN,
            );
        }

        $this->bus->dispatch(
            command: new UpdateService(
                payload: $request->payload(),
                service: $service
            ),
        );

        return new MessageResponse(
            message: 'services.v1.update.success',
            status: Response::HTTP_ACCEPTED,
        );
    }
}