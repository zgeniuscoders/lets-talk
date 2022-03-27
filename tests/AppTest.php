<?php
//
//namespace Test;
//
//use App\Controllers\MainController;
//use Zgeniuscoders\Zgeniuscoders\Module\App;
//use GuzzleHttp\Psr7\ServerRequest;
//use PHPUnit\Framework\TestCase;
//
//class AppTest extends TestCase
//{
//    public function testRedirectTraingingSlash()
//    {
//        $app = new App([]);
//        $request = new ServerRequest("GET", '/demo/');
//        $response = $app->run($request);
//        $this->assertContains('/demo/', $response->getHeader("Location"));
//        $this->assertEquals(301, $response->getStatusCode());
//    }
//
//    public function testblog()
//    {
//        $app = new App([
//            MainController::class
//        ]);
//
//        $request = new ServerRequest('GET', '/blog');
//        $response = $app->run($request);
//        $this->assertContains('<h1>Bienvenu sur le blog</h1>', (string)$response->getBody());
//        $this->assertEquals(200, $response->getStatusCode());
//
//        $request2 = new ServerRequest('GET', '/blog/article-de-test');
//        $response2 = $app->run($request2);
//        $this->assertContains('<h1>slug article-de-test</h1>', (string)$response2->getBody());
//    }
//}
