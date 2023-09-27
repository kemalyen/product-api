<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        // Force to application/json rendering on API calls
        if ($request->is('api*')) {
            // set Accept request header to application/json
            $request->headers->set('Accept', 'application/json');
        }

        // Default to the parent class' implementation of handler
        return parent::render($request, $e);
    }
}
