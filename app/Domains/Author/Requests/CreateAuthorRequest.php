<?php

namespace App\Domains\Author\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Request de validação para criação de autor.
 */
class CreateAuthorRequest
{
    /**
     * Valida os dados da requisição para criação de autor.
     *
     * @param Request $request
     * @return array Dados validados
     *
     * @throws ValidationException
     */
    public static function validate(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        $validator->validate();

        return $validator->validated();
    }
}
