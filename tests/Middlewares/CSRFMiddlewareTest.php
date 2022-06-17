<?php


namespace Middlewares;


use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Legacy\Legacy\Middlewares\CSRFMiddleware;
use Legacy\Legacy\Middlewares\Exceptions\CSRFException;

class CSRFMiddlewareTest  extends TestCase
{
    private CSRFMiddleware $middleware;
    private array $session;

    protected function setUp(): void
    {
        $this->session = [];
        $this->middleware = new CSRFMiddleware($this->session);
    }

    public function testGetRequestPass()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->once())
            ->method('handle');

        $request = (new ServerRequest("GET","/posts"));
        $this->middleware->process($request, $handle);

    }

    public function testPostRequestBlockWithoutCsrf()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->never())
            ->method('handle');

        $request = (new ServerRequest("POST","/posts"));
        $this->expectException(CSRFException::class);
        $this->middleware->process($request,$handle);

    }

    public function testPostRequestBlockWithoutInvalidCsrf()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->never())
            ->method('handle');

        $this->middleware->generateToken();
        $request = (new ServerRequest("POST","/posts"));
        $request = $request->withParsedBody(['__csrf' => 'foo']);

        $this->expectException(CSRFException::class);
        $this->middleware->process($request,$handle);

    }

    public function testLetPostRequestPass()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->once())
            ->method('handle');

        $request = (new ServerRequest("POST","/posts"));
        $token = $this->middleware->generateToken();
        $request = $request->withParsedBody(['__csrf' => $token]);
        $this->middleware->process($request,$handle);

    }

    public function testLetPostRequestPassOnce()
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handle->expects($this->once())
            ->method('handle');

        $request = (new ServerRequest("POST","/posts"));
        $token = $this->middleware->generateToken();
        $request = $request->withParsedBody(['__csrf' => $token]);
        $this->middleware->process($request,$handle);
        $this->expectException(CSRFException::class);
        $this->middleware->process($request,$handle);


    }
}