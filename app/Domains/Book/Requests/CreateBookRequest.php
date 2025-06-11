<?php

namespace App\Domains\Book\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateBookRequest
{
    /**
     * Valida os dados para criar um livro.
     *
     * @param Request $request
     * @return array
     */
    public static function validate(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'edition' => 'required|integer|min:1',
            'published_year' => 'required|digits:4|integer|min:1500|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'author_ids' => 'required|array',
            'author_ids.*' => 'integer|exists:authors,id',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'integer|exists:subjects,id',
        ]);

        $validator->validate();

        return $validator->validated();
    }
}
