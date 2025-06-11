<?php

namespace App\Domains\Book\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateBookRequest
{
    /**
     * Valida os dados para atualização de um livro.
     *
     * @param Request $request
     * @return array Dados validados
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validate(Request $request): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'edition' => 'required|integer|min:1',
            'published_year' => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'author_ids' => 'array',
            'author_ids.*' => 'integer|exists:authors,id',
            'subject_ids' => 'array',
            'subject_ids.*' => 'integer|exists:subjects,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        return $validator->validated();
    }
}
