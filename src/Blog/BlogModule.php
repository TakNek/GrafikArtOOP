<?php

namespace App\Blog;

use DI\Container;
use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use App\Blog\Actions\AdminBlogAction;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogModule extends Module
{
    const DEFINITIONS = __DIR__.'\config.php';
    
    const MIGRATIONS = __DIR__.'\DB\Migrations';

    const SEEDS = __DIR__.'\DB\seeds';
    
    public function __construct(Container $container)
    {
        $blogPrefix = $container->get('blog.prefix');
        $container->get(RendererInterface::class)->addPath('blog', __DIR__.'\views');
        $router =  $container->get(Router::class);
        $router->get($container->get('blog.prefix'), BlogAction::class, 'blog.index');
        $router->get($container->get('blog.prefix').'/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/posts", AdminBlogAction::class, 'blog.admin');
        }
    }
}
