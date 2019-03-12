<?php

use Framework\App;
use Framework\Router;
use Framework\Renderer;
use App\Blog\BlogModule;
use GuzzleHttp\Psr7\ServerRequest;

require '..\vendor\autoload.php';
$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');
//dump(dirname(__DIR__).DIRECTORY_SEPARATOR.'views'); die();
$app = new App([BlogModule::class], [
    'renderer' => $renderer
]);
$response = $app->run(ServerRequest::fromGlobals());
\Http\Response\send($response);
