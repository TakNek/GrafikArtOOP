<?php
namespace Framework\Twig;

use Framework\Session\FlashService;

class FlashExtension extends \Twig_Extension
{
    protected $flashService;

    public function __construct(FlashService $flashService)
    {
        
        $this->flashService = $flashService;
    }

    public function getFunctions() : array
    {
        return [
            new \Twig_SimpleFunction('flash', [$this, 'getflashService'])
        ];
    }

    public function getflashService($type) : ?string
    {
        return $this->flashService->get($type);
    }
}
