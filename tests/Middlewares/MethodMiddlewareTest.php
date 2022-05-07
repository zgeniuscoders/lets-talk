<?php


namespace Middlewares;


use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Zgeniuscoders\Zgeniuscoders\Middlewares\MethodMiddleware;

class MethodMiddlewareTest extends TestCase
{
    private MethodMiddleware $middleware;

    protected function setUp(): void
    {
        $this->middleware = new MethodMiddleware();
    }

    public function testAddMethode()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->once())
            ->method('handle')
            ->with($this->callback(function($request) {
                return $request->getMethod() === 'DELETE';
            }));

        $request = (new ServerRequest("POST","/login"))
            ->withParsedBody(['_method' => 'DELETE']);

        $this->middleware->process($request,$handle);
    }
}