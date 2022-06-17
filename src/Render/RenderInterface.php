<?php

namespace Legacy\Legacy\Render;

interface RenderInterface
{

    public function render(string $view, array $params = []);

    public function addGlobal(string $key, $value);

    public function addPath(string $namespace, $path = null);
}
