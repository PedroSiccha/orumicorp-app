<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class RepositoryException extends Exception
{
    public function __construct(string $message = "Error en el repositorio", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
