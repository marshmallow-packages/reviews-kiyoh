<?php

namespace Marshmallow\Reviews\Kiyoh\Exceptions;

use Exception;
use Marshmallow\Reviews\Kiyoh\Exceptions\KiyohException;

class KiyohInviteException extends Exception
{
    public function __construct($error_array)
    {
        throw new KiyohException('Kiyoh said: ' . $error_array['detailedError'][0]['message'], 1);
    }
}
