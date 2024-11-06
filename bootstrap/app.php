<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use App\Factories\ErrorFactory;
use PhpParser\Node\Expr\Throw_;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Application;
use Treblle\ApiResponses\Data\ApiError;
use Treblle\ErrorCodes\Enums\ErrorCode;
use App\Http\Middleware\SunsetMiddleware;
use JustSteveKing\Tools\Http\Enums\Status;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Treblle\ApiResponses\Responses\ErrorResponse;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Treblle\SecurityHeaders\Http\Middleware\RemoveHeaders;
use Treblle\SecurityHeaders\Http\Middleware\PermissionsPolicy;
use Treblle\SecurityHeaders\Http\Middleware\SetReferrerPolicy;
use Treblle\SecurityHeaders\Http\Middleware\ContentTypeOptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Treblle\SecurityHeaders\Http\Middleware\StrictTransportSecurity;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Treblle\SecurityHeaders\Http\Middleware\CertificateTransparencyPolicy;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/routes.php',
        api: __DIR__ . '/../routes/api/routes.php',
        commands: __DIR__ . '/../routes/console/routes.php',
        health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
            RemoveHeaders::class,
            SetReferrerPolicy::class,
            StrictTransportSecurity::class,
            PermissionsPolicy::class,
            ContentTypeOptions::class,
            CertificateTransparencyPolicy::class,
        ]);

        $middleware->alias([
            'sunset' => SunsetMiddleware::class,
            'verified' => App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        app()->make(ExceptionHandler::class)->renderable(function (Exception $exception, Request $request) {
            return ErrorFactory::create($exception, $request);
        });
        $exceptions->render(fn (UnprocessableEntityHttpException $exception) => new JsonResponse(
            data: $exception->getMessage(),
            status: 422,
        ));
        $exceptions->render(fn(Throwable $exception, Request $request) => ErrorFactory::create(
            exception: $exception,
            request: $request
        ));
    })->create();
