<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    public function report(Throwable $e): void
    {
        Log::error($e->getMessage(), ['exception' => $e]);

        parent::report($e);
    }

    public function render($request, Throwable $e): JsonResponse
    {

        if ($e instanceof ValidationException) {
            return response()->json(['error' => 'Error validation data', 'details' => $e->errors()], 422);
        }

        return response()->json(['error' => 'An internal error has occurred'], 500);
    }
}
