<?php

namespace Legacy\Legacy\Router\Exceptions;

use Exception;

class RouterException extends Exception
{

    public function error404()
    {
        http_response_code(404);
    }
}
