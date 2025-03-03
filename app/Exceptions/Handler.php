<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    public function report(Throwable $e)
    {
        // Логирование исключения
        Log::error($e->getMessage(), ['exception' => $e]);

        parent::report($e);
    }

    public function render($request, Throwable $e)
    {

        if ($e instanceof ValidationException) {
            return response()->json(['error' => 'Ошибка валидации данных', 'details' => $e->errors()], 422);
        }

        return response()->json(['error' => 'Произошла внутренняя ошибка'], 500);
    }
}
