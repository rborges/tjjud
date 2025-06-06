<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as LaravelValidationException;
use Illuminate\Contracts\Validation\Validator;

class ValidationException extends LaravelValidationException
{
    /**
     * Cria uma exceção com base no validador.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        parent::__construct($validator);
    }

    /**
     * Retorna os erros de validação.
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        return $this->validator->errors()->toArray();
    }
}
