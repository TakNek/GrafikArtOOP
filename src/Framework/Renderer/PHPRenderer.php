<?php

namespace Framework\Renderer;

class PHPRenderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = 'blog';

    private $paths = [];
    
    /**
     * Variable Globalement Accecible pour toutes les vue
     *
     * @var array
     */
    private $globals = [];
    
    /**
     * Permet de rajouter un chemin pour charger les vues
     *
     * @param string $namespace
     * @param string|null $path
     * @return void
     */


    public function __construct(?string $defaultpath = null)
    {
        if (!is_null($defaultpath)) {
            $this->addPath($defaultpath);
        }
    }

    public function addPath(string $namespace, ?string $path = null) : void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
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
        if ($this->hasNameSpace($view)) {
            $path = $this->replaceNameSpace($view).'.php';
        } else {
            $path=$this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
        }
        ob_start();
        extract($this->globals);
        extract($params);
        $renderer = $this;
        require($path);
        return ob_get_clean();
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
        $this->globals[$key] = $value;
    }

    private function hasNameSpace(string $view) : bool
    {
        return $view[0] === '@';
    }

    private function getNameSpace(string $view) : string
    {
        return substr($view, 1, strpos($view, DIRECTORY_SEPARATOR)-1);
    }

    private function replaceNameSpace(string $view) : string
    {
        $namespace = $this->getNameSpace($view);
        return str_replace('@'.$namespace, $this->paths[$namespace], $view);
    }
}
