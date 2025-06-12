<?php

namespace App\Domains\Subject\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Classe responsável pela validação dos dados para atualização de um assunto.
 */
class UpdateSubjectRequest
{
    /**
     * Valida os dados da requisição para atualizar um assunto.
     *
     * @param Request $request
     * @return array Dados validados
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validate(Request $request): array
    {
        $rules = [
            'description' => 'required|string|max:20',
            'book_ids' => 'sometimes|array',
            'book_ids.*' => 'integer|exists:books,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->validate();

        return $validator->validated();
    }
}
