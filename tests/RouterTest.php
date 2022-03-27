<?php
//
//use Zgeniuscoders\Zgeniuscoders\Router\Router;
//use GuzzleHttp\Psr7\ServerRequest;
//use PHPUnit\Framework\TestCase;
//
//class RouterTest extends TestCase
//{
//
//    private $router;
//
//    protected function setUp(): void
//    {
//        $this->router = new Router();
//    }
//
//    public function testGetMethod()
//    {
//        $request = new ServerRequest('GET', '/blog');
//        $this->router->get('/blog', function () { return 'hello';}, 'blog');
//        $route = $this->router->matches($request);
//        $this->assertEquals('blog', $route->getName());
//        $this->assertEquals('Hello', call_user_func_array($route->getCallback(), [$request]));
//    }
//
//    public function testGetMethodIfurlDoesNotExist()
//    {
//        $request = new ServerRequest('GET', '/blog');
//        $this->router->get('/blogaze', function () { return 'hello';}, 'blog');
//        $route = $this->router->matches($request);
//        $this->assertEquals(null, $route);
//    }
//
//    public function testGetMethodWithParameters()
//    {
//        $request = new ServerRequest('GET', '/blog/mon-slug-10');
//        $this->router->get('/blog', function () { return 'ssdsff';}, 'posts');
//        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
//            return 'hello';
//        }, 'post.show');
//        $route = $this->router->matches($request);
//        $this->assertEquals('post.show', $route->getName());
//        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
//        $this->assertEquals(['slug' => 'mon-slug', 'id' => '10'], $route->getParams());
//    }
//
//    public function testGenerateUri()
//    {
//        $this->router->get('/blog', function () {
//            return 'ssdsff';
//        }, 'posts');
//        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function () {
//            return 'hello';
//        }, 'post.show');
//        $uri = $this->router->getUri('post.show', ['slug' => 'mon-slug', 'id' => '10']);
//        $this->assertEquals('/blog/mon-slug-10', $uri);
//    }
//}
