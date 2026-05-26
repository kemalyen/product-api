<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JsonException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidateJsonMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): JsonResponse| Response
    {
        if ($this->shouldValidate($request)) {
            $this->validateJson($request);
        }
        return $next($request);
    }

    private function shouldValidate(Request $request): bool
    {
        return $request->isJson() &&
            $request->getContent() !== '' &&
            !$request->isMethodSafe() &&
            empty($request->json()?->all());
    }

    /**
     * Validate the JSON content of the request.
     *
     * @param Request $request
     * @throws BadRequestHttpException
     */
    private function validateJson(Request $request): void
    {
        try {
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new JsonException(json_last_error_msg(), json_last_error());
            }
            json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new BadRequestHttpException('Json Error: ' . $exception->getMessage(), $exception);
        }
    }
}
