<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class BookValidator
{
    /**
     * Retorna um validador configurado com as regras de validação para livro.
     *
     * @param array $data
     * @return ValidatorContract
     */
    public static function validate(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'title'          => 'required|string|max:255',
            'publisher'      => 'nullable|string|max:100',
            'edition'        => 'nullable|string|max:50',
            'published_year' => 'nullable|digits:4|integer|min:1000|max:' . date('Y'),
            'price'          => 'nullable|numeric|min:0',
            'author_ids'     => 'nullable|array',
            'author_ids.*'   => 'integer|exists:authors,id',
            'subject_ids'    => 'nullable|array',
            'subject_ids.*'  => 'integer|exists:subjects,id',
        ]);
    }
}
