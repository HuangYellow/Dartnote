<?php

namespace App\Exceptions;

use Throwable;

class PropertyNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("The property '{$message}' does not exist.", $code, $previous);
    }
}