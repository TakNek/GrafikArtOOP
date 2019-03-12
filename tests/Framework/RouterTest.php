<?php
namespace Tests\Framework;

use PHPUnit\Framework\TestCase;
use Framework\Router as MonRouter;
use GuzzleHttp\Psr7\ServerRequest;


class RouterTest extends TestCase
{
    private $router;

     function setUp() : void
    {
        $this->router = new MonRouter();

    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET','/blog');
        $this->router->get('/blog',function(){return 'salut';},'blog');
        $route= $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('salut', call_user_func($route->getCallback(), [$request]));
    }

    public function testGetMethodIfUrlDoesNotExist()
    {
        $request = new ServerRequest('GET','/blog');
        $this->router->get('/bloqsdqsdg',function(){return "salut";}, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET','/blog/mon-slug-8');
        $this->router->get('/blog',function(){return "salsssut";}, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}',function() {return "salut";}, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('salut', call_user_func($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());
        //Invalid Route
        $route2=$this->router->match(new ServerRequest('GET','/blog/mon_slug_8'));
        $this->assertEquals(null, $route2);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog',function(){return "salsssut";}, 'posts');
        $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}',function() {return "salut";}, 'post.show');
        $uri = $this->router->generateUri('post.show',['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18',$uri);
    }
}
?>