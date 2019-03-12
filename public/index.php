<?php



require '..\vendor\autoload.php';
$renderer = new Framework\Renderer\TwigRenderer(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');


//$renderer->addPath(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');
//$loader = new Twig_Loader_Filesystem(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');
//$twig = new Twig_Environement($loader, [

//]);

$app = new Framework\App([App\Blog\BlogModule::class], [
    'renderer' => $renderer
]);
$response = $app->run(GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
