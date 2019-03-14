<?php
namespace App\Blog\Actions;

use Framework\Router;
use App\Blog\Table\PostTable;
use GuzzleHttp\Psr7\Response;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{
    private $render;
    private $postTable;
    private $router;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, PostTable $postTable, Router $router)
    {
         $this->renderer=$renderer;
         $this->postTable=$postTable;
         $this->router=$router;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }

    public function index()
    {
        $posts = $this->postTable->findPaginated();
        return $this->renderer->render('@blog\index', compact('posts'));
    }
    

    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }
        return $this->renderer->render('@blog\show', [
            'post' => $post
        ]);
    }
}
