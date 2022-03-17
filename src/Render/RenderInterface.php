<?php

namespace Zgeniuscoders\Zgeniuscoders\Render;

interface RenderInterface{

    public function render(string $path, ?array $params);

}