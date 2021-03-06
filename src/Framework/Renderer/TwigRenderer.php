<?php
namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {

        $this->twig = $twig;
    }

    public function addPath(string $namespace, ?string $path = null) : void
    {
        $this->twig->getLoader()->addPath($path, $namespace);
    }
        
        /**
         * Permet de rendre une vue
         * Le chemain peut être précisé avec des namespaces via le addPath();
         * $this->render('@blog/view')
         * @param string $view
         * @param array $params
         * @return string
         */
    public function render(string $view, array $params = []) : string
    {
        return $this->twig->render($view.'.twig', $params);
    }
    /**
     * Permet de Rajouter des variables Globals à toutes les vues
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value) : void
    {
        $this->twig->addGlobal($key, $value);
    }
}
