<?php
namespace Tests\Framework;


use PHPUnit\Framework\TestCase;
use Framework\Renderer\PHPRenderer;

class PHPRendererTest extends TestCase
{
    private $renderer;

    public function setUp() : void
    {
        $this->renderer = new PHPRenderer(dirname(__DIR__).DIRECTORY_SEPARATOR.'views');
        
    }
    public function testRenderTheRightPath()
    {
        $this->renderer->addPath('blog',__DIR__.'\views');
        $contenu = $this->renderer->render('@blog\demo');
        $this->assertEquals('salut les gens', $contenu);
    }
    
    public function testRenderTheDefaultPath()
    {
        $contenu = $this->renderer->render('@blog\demo');
        $this->assertEquals('salut les gens', $contenu);
    }


    public function testRenderWithParams()
    {
        $contenu = $this->renderer->render('demoparams',['nom' => 'Marc']);
        $this->assertEquals('salut Marc', $contenu);
    }
    
    public function testGlobalParameters()
    {
        $this->renderer->addGlobal('nom','Marc');
        $contenu = $this->renderer->render('demoparams');
        $this->assertEquals('salut Marc', $contenu);
    }
}
