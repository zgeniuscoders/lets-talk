<?php


use PHPUnit\Framework\TestCase;
use Zgeniuscoders\Zgeniuscoders\Helpers\TwigFormExtension;

class FormExtensionTest extends TestCase
{
    /**
     * @var TwigFormExtension
     */
    private TwigFormExtension $form;

    protected function setUp(): void
    {
        $this->form = new TwigFormExtension();
    }

    /**
     * @param string $string
     * @return string
     */
    private function trim(string $string): string
    {
        $lines = explode('\n', $string);
        $lines = array_map('trim', $lines);
        return implode('',$lines);
    }

    public function assertSimilar(string $expected, string $actual)
    {
        $this->assertEquals($this->trim($expected),$this->trim($actual));
    }

    public function testInput()
    {
        $html = $this->form->input('name','Nom','text','form-control');
        $this->assertSimilar("
            <label for=\"name\">Nom</label>
            <input type=\"text\" name=\"name\" id=\"name\" class=\"form-control\">
        ",$html);
    }

//    public function testArea()
//    {
//        $html = $this->form->textArea('content','Content','form-control');
//        $this->assertSimilar("
//            <label for=\"name\">Content</label>
//            <textarea name=\"content\" id=\"content\" class=\"form-control\"></textarea>
//        ",$html);
//    }
}