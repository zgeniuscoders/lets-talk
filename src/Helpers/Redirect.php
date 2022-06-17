<?php


namespace Legacy\Legacy\Helpers;

use GuzzleHttp\Psr7\Response;

class Redirect extends Response
{
    public function __construct(string $url)
    {
        parent::__construct(301, ['Location' => $url]);
    }
}
