<?php

use App\Hexagon\Domain\Exceptions\CustomException;
use App\Http\Middleware\Localization;
use App\Services\Enums\Payload\PayloadExceptionMessage;
use App\Services\Utils\Payload\PayloadFactory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
//            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
//            // \Illuminate\Http\Middleware\TrustHosts::class,
//            \Illuminate\Http\Middleware\TrustProxies::class,
//            \Illuminate\Http\Middleware\HandleCors::class,
//            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
//            \Illuminate\Http\Middleware\ValidatePostSize::class,
//            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
//            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            Localization::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, Request $request) {
            if ($request->is('api/*')) {
                $errors = null;
                //TODO::Genelle
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                if ($exception instanceof CustomException) {
                    $statusCode = $exception->getCode();
                    $localeKey = $exception->getMessage();
                    $localeOptions = $exception->getValue() ? ['value' => $exception->getValue()] : null;
                    $payload = PayloadFactory::error($localeKey,$localeOptions,[],$statusCode);
                    return response()->json($payload->toArray(),$payload->getCode());
                }
//                if ($exception instanceof AuthenticationException) {
//                    $statusCode = $exception->getCode();
//                }
                if ($exception instanceof ValidationException) {
                    $errors = $exception->validator->errors()->all();
                    $statusCode = Response::HTTP_BAD_REQUEST;
                    $payload = PayloadFactory::error(PayloadExceptionMessage::VALIDATION_ERROR,null,$errors,$statusCode);
                    return response()->json($payload->toArray(),$payload->getCode());
                }
                if ($exception instanceof Exception) {
                    dd($exception);
                    $payload = PayloadFactory::error(PayloadExceptionMessage::HTTP_ERROR,null,$errors,$statusCode);
                    return response()->json($payload->toArray(),$payload->getCode());
                }
            } else {
                return;
            }
        });
        $exceptions->render(function(AuthenticationException $exception, Request $request) {
            if ($request->is('api/*')) {
                $payload = PayloadFactory::error("ok",[$exception->getMessage()],$exception->getCode());
                return response()->json($payload->toArray(),$payload->getCode());
            } else {
                return;
            }
        });
    })->create();
