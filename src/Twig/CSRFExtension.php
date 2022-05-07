<?php


namespace Zgeniuscoders\Zgeniuscoders\Twig;

use Twig\Extension\AbstractExtension;
use Zgeniuscoders\Zgeniuscoders\Middlewares\CSRFMiddleware;

class CSRFExtension extends AbstractExtension
{

    public function __construct(private CSRFMiddleware $middleware)
    {
    }

    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction(
                '__csrf',
                [$this, 'csrf'],
                ['is_safe' => ['html'],'needs_context' => true]
            )
        ];
    }

    public function csrf():string
    {
        $value = $this->middleware->generateToken();
        $name = $this->middleware->getFormKey();
        return '<input type="hidden" name="'. $name .'" value="'. $value . '"/>';
    }
}
