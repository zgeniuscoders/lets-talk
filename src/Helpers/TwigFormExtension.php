<?php


namespace Zgeniuscoders\Zgeniuscoders\Helpers;


use Twig\Extension\AbstractExtension;

class TwigFormExtension extends AbstractExtension
{

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
          new \Twig\TwigFunction('input',[$this,'input'],['is_safe' => ['html']]),
            new \Twig\TwigFunction('textArea',[$this, 'textArea'],['is_safe' => ['html']]),
            new \Twig\TwigFunction('button',[$this, 'button'],['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string $key
     * @param string $label
     * @param string $type
     * @param string $class
     * @return string
     */
    public function input(string $key, string $label, string $type, string $class = ''): string
    {
        return "<label for=\"{$type}\">{$label}</label>
                <input type=\"{$type}\" name=\"{$key}\" id=\"{$key}\" class=\"{$class}\">";
    }

    /**
     * @param string $key
     * @param string $label
     * @param string $class
     * @return string
     */
    public function textArea(string $key, string $label, string $class = ''): string
    {
        return "<label for='{$key}'>{$label}</label>
                <textarea name=\"{$key}\" id=\"{$key}\" class=\"{$class}\"></textarea>";
    }

    /**
     * @param string $key
     * @param string $label
     * @param string $class
     * @return string
     */
    public function button(string $key, string $label, string $class = ''): string
    {
        return "<button type=\"submit\" name=\"{$key}\" class=\"{$class}\">$label</button>";
    }
}