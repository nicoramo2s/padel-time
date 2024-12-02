<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
{
    if ($e instanceof ValidationException) {
        return JsonResponse(message: $e->getMessage(), status: 422, errors: $e->errors());
    }
    if ($e instanceof Exception) {
        return JsonResponse(message: $e->getMessage(), status: 500, errors: $e);
    }

    return parent::render($request, $e);
}
}
