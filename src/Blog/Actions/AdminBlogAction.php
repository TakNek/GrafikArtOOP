<?php
namespace App\Blog\Actions;

use Framework\Router;
use App\Blog\Table\PostTable;
use GuzzleHttp\Psr7\Response;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;

class AdminBlogAction
{
    private $renderer;
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
        $string = (string) $request->getUri();

        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr($string, -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        } else {
            return $this->index($request);
        }
    }

    public function index(Request $request)
    {
        $params = $request->getQueryParams();
        $items = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog\admin\index', compact('items'));
    }
    
    /**
     * Edit un article
     *
     * @param Request $request
     * @return Request
     */
    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y/m/d H:i:s');
            $params['created_at'] = date('Y/m/d H:i:s');
            $this->postTable->update($item->id, $params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog\admin\edit', compact('item'));
    }

    public function create(Request $request)
    {
        
        if ($request->getMethod($request) === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y/m/d H:i:s');
            $params['created_at'] = date('Y/m/d H:i:s');
            $this->postTable->insert($params);
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog\admin\create');
    }


    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }
    private function getParams(Request $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name','content', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
