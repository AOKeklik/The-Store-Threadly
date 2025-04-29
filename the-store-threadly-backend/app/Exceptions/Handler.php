<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    // 404
    protected function handleNotFoundHttpException($request, NotFoundHttpException $exception)
    {
        return response()->json([
            'success' => false,
            'error_type' => 'credential',
            'message' => 'The resource you are looking for could not be found.',
            'error' => 'resource_not_found'
        ], 404);
    }

    // 422
    protected function handleValidationException(ValidationException $e, $request)
    {
        return response()->json([
            'success' => false,
            'error_type' => 'validation',
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }

    // 401
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'success' => false,
            'error_type' => 'credential',
            'message' => 'Unauthenticated. Please log in.',
            'error' => 'authentication_required',
            'login_url' => route('login')
        ], 401);
        
        // return redirect()->guest(route('login'));
    }

    public function render($request, Throwable $exception)
    {
        // Handle NotFoundHttpException (404)
        if ($exception instanceof NotFoundHttpException) {
            return $this->handleNotFoundHttpException($request, $exception);
        }

        // Handle ValidationException (422)
        if ($exception instanceof ValidationException) {
            return $this->handleValidationException($exception, $request);
        }

        // Handle other exceptions (e.g., ValidationException, AuthenticationException)
        return parent::render($request, $exception);
    }
}
