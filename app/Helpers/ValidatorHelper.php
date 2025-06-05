<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidatorHelper
{
    /**
     * Valida os dados com base nas regras fornecidas.
     *
     * @param array $data Dados a serem validados.
     * @param array $rules Regras de validação.
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validate(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }
}
