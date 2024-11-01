<?php

declare(strict_types=1);

namespace App\Http\Responses\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

final readonly class MessageResponse implements Responsable
{
    public function __construct(
    private string $message,
    private int $status = Response::HTTP_OK,
    ) {}

    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: [
                'message' => $this->message,
            ],
            status: $this->status,
        );
    }
}