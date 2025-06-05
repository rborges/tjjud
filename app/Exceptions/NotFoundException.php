<?php

namespace App\Exceptions;

use Exception;

/**
 * Exceção lançada quando um recurso não é encontrado.
 */
class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message Mensagem da exceção
     */
    public function __construct(string $message = 'Recurso não encontrado')
    {
        parent::__construct($message, 404);
    }
}
