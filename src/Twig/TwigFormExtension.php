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
          new \Twig\TwigFunction('input',
              [$this,'input'],
              ['is_safe' => ['html'],'needs_context' => true]
          ),
            new \Twig\TwigFunction('textArea',
                [$this, 'textArea'],
                ['is_safe' => ['html'],'needs_context' => true]
            ),
            new \Twig\TwigFunction('button',
                [$this, 'button'],
                ['is_safe' => ['html'],'needs_context' => true]
            ),
        ];
    }

    /**
     * @param array $context
     * @param string $key
     * @return string
     */
    private function getErrorsHtml(array $context, string $key): string
    {
        $errors = $context['errors'][$key] ?? false;
        if($errors)
        {
            return "<small class=\"error\">{$errors}}</small>";
        }
    }

    /**
     * @param array $context
     * @param string $key
     * @return array
     */
    private function errorFields(array $context, string $key,array &$class): array
    {
        $errors = $context['errors'][$key] ?? false;
        $error = "";
        if($errors)
        {
            $error = $this->getErrorsHtml($context,$key);
            $class[] = "has-error";
        }

        return [
            "class" => implode(' ',$class),
            "error" => $error
        ];
    }

    /**
     * @param array $context
     * @param string $key
     * @param string|null $label
     * @param string $type
     * @param array $class
     * @return string
     */
    public function input(array $context,string $key, string $label = null, string $type = "text", array $class = []): string
    {
        $html = $this->errorFields($context,$key,$class);
        $error = $html["error"];
        $getClass = $html["class"];

        return "<label for=\"{$type}\">{$label}</label>
                <input type=\"{$type}\" name=\"{$key}\" id=\"{$key}\" class=\"{$getClass}\">
                {$error}";
    }

    /**
     * @param array $context
     * @param string $key
     * @param string $label
     * @param string $class
     * @return string
     */
    public function textArea(array $context,string $key, string $label, string $class = ''): string
    {
        $error = $this->errorFields($context,$key);

        return "<label for='{$key}'>{$label}</label>
                <textarea name=\"{$key}\" id=\"{$key}\" class=\"{$class}\"></textarea>
                {$error}";
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