<?php
namespace Tests\Framework\Twig;

use PHPUnit\Framework\TestCase;
use Framework\Twig\TextExtension;

class TextExtensionTest extends TestCase
{
    private $textExtension;

    public function setUp() :void
    {
        $this->textExtension = new TextExtension;
    }

    public function testExcerptWithShortText()
    {
        $text = "bonsoir";
        $this->assertEquals($text,$this->textExtension->excerpt($text,10));
    }

    public function testExcerptWithLongText()
    {
        $text = "bonsoir les gens qsdqsd qsdq qsdqsddddd";
        $this->assertEquals(" ...",$this->textExtension->excerpt($text,5));
    }
}