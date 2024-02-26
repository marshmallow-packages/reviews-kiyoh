<?php

namespace Marshmallow\Reviews\Kiyoh\Exceptions;

use Exception;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;

class KiyohApiException extends Exception
{
    public function __construct(string $error_message)
    {
        throw new KiyohException("Kiyoh said: {$error_message}", 1);
    }
}
