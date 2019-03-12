<?php

namespace Tests\Framework;

use \Framework\App;
use \App\Blog\BlogModule;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use tests\Framework\Modules\StringModule;
use tests\Framework\Modules\ErroredModule;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/demo/');
        $response = $app->run($request);
        $this->assertContains('/demo', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }
    public function testBlog()
    {
        $app = new App([BlogModule::class]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Welcome</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        //Single Article Page request Test
        $requestSingle = new ServerRequest('GET','/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertStringContainsString('<h1>Welcome to ', (string) $responseSingle->getBody());
    }
    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/sdf');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Error 404</h1>', (string) $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testThrowExceptionIfNoResponseSent()
    {
        $app = new App(
           [ErroredModule::class]
        );
        $request = new ServerRequest('GET','/demo');
        $this->expectException(\Exception::class);
        $app->run($request);

    }
   
    public function testStringModule()
    {
        $app = new App(
           [StringModule::class]
        );
        $request = new ServerRequest('GET','/demo');
        $response=  $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class,$response);
        $this->assertStringContainsString('DEMO',(string) $response->getBody());

    }
}
