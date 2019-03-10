<?php

namespace Tests\Framework;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use \Framework\App;

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
        $app = new App();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Welcome</h1>', (string) $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/sdf');
        $response = $app->run($request);
        $this->assertStringContainsString('<h1>Error 404</h1>', (string) $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
