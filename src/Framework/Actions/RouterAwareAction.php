<?php
namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Rajoute des méthodes liée a l'utilisation du Routeur
 */
trait RouterAwareAction
{
    /**
     * Renvoie une réponse de redirection
     *
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []) : ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
                ->withStatus(301)
                ->withHeader('Location', $redirectUri);
    }
}
