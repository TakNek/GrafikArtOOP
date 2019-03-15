<?php
namespace Framework;

use Framework\Router\Route;
use Zend\Expressive\Router\FastRouteRouter;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Register and matches Routes
 */
class Router
{
    /**
     *
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     *
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return void
     */
    public function get(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     *
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return void
     */
    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }


    /**
     *
     * @param string $path
     * @param callable $callable
     * @param string $name
     * @return void
     */
    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }

    /**
     * Genère les routes du crud
     *
     * @param string $prefixPath
     * @param callable $callable
     * @param string|null $prefixName
     * @return void
     */
    public function crud(string $prefixPath, $callable, ?string $prefixName)
    {
            $this->get("$prefixPath", $callable, "$prefixName.index");
            $this->get("$prefixPath/new", $callable, "$prefixName.create");
            $this->post("$prefixPath/new", $callable);
            $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
            $this->post("$prefixPath/{id:\d+}", $callable);
            $this->delete("$prefixPath/{id:\d+}", $callable, "$prefixName.delete");
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result =  $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUri(string $name, array $params = [], array $queryparams = []) :string
    {

        $uri =  $this->router->generateUri($name, $params);
        if (!empty($queryparams)) {
            return  $uri.'?'.http_build_query($queryparams);
        }
        return $uri;
    }
}
