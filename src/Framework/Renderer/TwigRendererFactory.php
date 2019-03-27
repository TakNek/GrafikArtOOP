<?php
namespace Framework\Renderer;

use Twig\Extension\DebugExtension;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Framework\Router\RouterTwigExtension;

class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container) : TwigRenderer
    {
        $viewPath = $container->get('views.path');
        $loader = new \Twig_Loader_Filesystem($viewPath);
        $twig = new \Twig_Environment($loader, ['debug' => true]);
        $twig->addExtension(new DebugExtension);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extention) {
                $twig->addExtension($extention);
            }
        }
        return new TwigRenderer($twig);
    }
}
