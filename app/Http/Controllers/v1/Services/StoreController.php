<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Services;

use App\Models\Service;
use App\Jobs\Services\CreateNewService;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Http\Responses\V1\MessageResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\V1\Services\WriteRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

final readonly class StoreController
{
    public function __construct(
        private readonly Dispatcher $bus,
    ) {}
    public function __invoke(WriteRequest $request)
    {
        if (! Gate::allows('create', Service::class)) {
            throw new UnauthorizedException(
                message: __('services.v1.create.failure'),
                code: Response::HTTP_FORBIDDEN,
            );
        }

        $this->bus->dispatch(
            command: new CreateNewService(
                payload: $request->payload(),
            ),
        );
        $service = Service::query()->create(array_merge(
            $request->validate(),
            [
                'user_id' => auth()->id,
            ]
        ));

        return new MessageResponse(
            message: __('services.v1.create.success'),
            status: Response::HTTP_ACCEPTED,
        );
    }
}
