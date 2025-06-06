<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as SymfonyNotFoundHttpException;

class NotFoundHttpException extends SymfonyNotFoundHttpException
{
    /**
     * Construtor da exceção personalizada.
     *
     * @param string|null $message
     */
    public function __construct(string $message = 'Recurso não encontrado.')
    {
        parent::__construct($message);
    }
}
