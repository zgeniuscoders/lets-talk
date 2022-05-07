<?php


namespace Zgeniuscoders\Zgeniuscoders\Twig;

use Twig\Extension\AbstractExtension;
use Zgeniuscoders\Zgeniuscoders\Session\Flash;

class FlashExtension extends AbstractExtension
{

    private Flash $flash;

    public function __construct(Flash $flash)
    {
        $this->flash = $flash;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('flash', [$this,'getFlash'])
        ];
    }

    /**
     * @return string|null
     */
    public function getFlash($type): ?string
    {
        return $this->flash->get($type);
    }
}
