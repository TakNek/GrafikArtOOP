<?php

use Framework\Router;
use Framework\Renderer\RendererInterface;
use Framework\Router\RouterTwigExtension;
use Framework\Renderer\TwigRendererFactory;

return[

    'views.path' => dirname(__DIR__).DIRECTORY_SEPARATOR.'views',
    'twig.extensions' => [
        \DI\get( RouterTwigExtension::class)
    ],
    Router::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class)
];