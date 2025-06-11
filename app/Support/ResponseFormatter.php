<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

/**
 * Responsável por padronizar todas as respostas JSON da aplicação.
 */
class ResponseFormatter
{
    /**
     * Retorna uma resposta de sucesso padronizada.
     *
     * @param mixed $data Dados a serem retornados
     * @param string|null $message Mensagem opcional
     * @param int $code Código HTTP (200 por padrão)
     * @return JsonResponse
     */
    public static function success(mixed $data, ?string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    /**
     * Retorna uma resposta de erro padronizada.
     *
     * @param string|null $message Mensagem de erro
     * @param int $code Código HTTP (400 por padrão)
     * @param mixed $errors Detalhes adicionais do erro (array, string, etc.)
     * @return JsonResponse
     */
    public static function error(?string $message = null, int $code = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $code,
        ], $code);
    }
}
