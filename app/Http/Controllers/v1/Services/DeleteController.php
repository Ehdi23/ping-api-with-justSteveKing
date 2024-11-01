<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Http\Responses\V1\MessageResponse;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Bus\Dispatcher;
use App\Jobs\Services\DeleteService;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;

final readonly class DeleteController
{
    public function __construct(
        private readonly Dispatcher $bus,
    ){}

    public function __invoke(Request $request, Service $service)
    {
        if (! Gate::allows('delete', $service::class)) {
            throw new UnauthorizedException(
                message: 'services.v1.delete.failure',
                code: Response::HTTP_FORBIDDEN,
            );

            $this->bus->dispatch(
                command: new DeleteService(
                    service: $service,
                ),
            );

            return new MessageResponse(
                message: 'services.v1.delete.success',
                status: Response::HTTP_ACCEPTED,
            );
        }
    }
}