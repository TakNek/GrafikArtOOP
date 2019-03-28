<?php
namespace Tests\Framework\Twig;

use PHPUnit\Framework\TestCase;
use Framework\Twig\FormExtension;


class FormExtensionTest extends TestCase
{
    /**
     * @var [type]
     */
    private $formExtension;

    public function setUp(): void
    {
        $this->formExtension = new FormExtension();
    }

    private function trim(string $string)
    {
        $lines = explode(PHP_EOL,$string);
        $lines = array_map('trim', $lines);
        return implode('', $lines);
    }

    public function assertSimilar(string $extected, string $acctual)
    {
        $this->assertEquals($this->trim($extected), $this->trim($acctual));
    }

    public function testField()
    {
        $html = $this->formExtension->field( [],'name', 'demo', 'Titre');
$this->assertSimilar("
<div class=\"form-group\">
<label for=\"name\">Titre</label>
<input class=\"form-control\" type=\"text\" name=\"name\" id=\"name\" value=\"demo\">
</div>"
        , $html);
    }

    public function testTextArea()
    {
        $html = $this->formExtension->field( [],
            'name', 
            'demo', 
            'Titre',
            ['type' => 'textarea']
        );
$this->assertSimilar("
<div class=\"form-group\">
<label for=\"name\">Titre</label>
<textarea class=\"form-control\" type=\"text\" name=\"name\" id=\"name\" >demo</textarea>
</div>"
        , $html);
    }
}