<?php

namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule
{
    public function __construct(Router $router)
    {
        
        $router->get('/blog',function(){return '<h1>Welcome</h1>';}, 'blog.index');
        $router->get('/blog/{slug:[a-z\-]+}',[$this,'show'],'blog.show');
    }

    public function index(Request $request) 
    {
        return '<h1>Welcome</h1>';
    }
    

    public function show(Request $request)
    {
        return'<h1>Welcome to '.$request->getAttribute('slug').'</h1>';
    }
}
