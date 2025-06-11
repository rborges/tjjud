<?php

namespace App\Domains\Author\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Request de validação para atualização de autor.
 */
class UpdateAuthorRequest
{
    /**
     * Valida os dados da requisição para atualização de autor.
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
        ]);

        $validator->validate();

        return $validator->validated();
    }
}
