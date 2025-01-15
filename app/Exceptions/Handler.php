<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponse;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('*api/*')) {
                return $this->sendResponse(401, '', __('messages.not_auth', locale: $request->lang ?? "ar"));
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('*api/*')) {
                return $this->sendResponse(404, '', __('messages.not_founded', locale: $request->lang ?? "ar"));
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('*api/*')) {
                return $this->sendResponse(405, '', __('messages.wrong_method', locale: $request->lang ?? "ar"));
            }
        });
    }
}
