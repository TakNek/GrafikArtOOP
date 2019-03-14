<?php

namespace App\Blog;

use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule extends Module
{
    const DEFINITIONS = __DIR__.'\config.php';
    
    const MIGRATIONS = __DIR__.'\DB\Migrations';

    const SEEDS = __DIR__.'\DB\seeds';
    
    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__.'\views');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix.'/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    }
}
