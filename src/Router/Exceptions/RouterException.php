<?php

namespace Zgeniuscoders\Zgeniuscoders\Router\Exceptions;

use Exception;

class RouterException extends Exception
{

    public function error404()
    {
        http_response_code(404);
    }
}
