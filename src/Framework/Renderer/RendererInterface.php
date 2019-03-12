<?php
namespace Framework\Renderer;

interface RendererInterface
{
    public function addPath(string $namespace, ?string $path = null) : void;
        
        /**
         * Permet de rendre une vue
         * Le chemain peut être précisé avec des namespaces via le addPath();
         * $this->render('@blog/view')
         * @param string $view
         * @param array $params
         * @return string
         */
    public function render(string $view, array $params = []) : string;
    /**
     * Permet de Rajouter des variables Globals à toutes les vues
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function addGlobal(string $key, $value) : void;
}
