<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\NotFoundException;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        ValidationException::class,
        NotFoundHttpException::class,
        NotFoundException::class,
    ];

    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        }

        if ($e instanceof NotFoundHttpException || $e instanceof NotFoundException) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso não encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro interno no servidor.',
            'error' => env('APP_DEBUG') ? $e->getMessage() : null,
        ], 500);
    }
}
