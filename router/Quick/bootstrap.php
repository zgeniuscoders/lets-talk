<?php

namespace Router\Quick;

require __DIR__ . '/functions.php';

spl_autoload_register(function ($class) {
    if (strpos($class, 'EcstacyRouter\\') === 0) {
        $name = substr($class, strlen('EcstacyRouter'));
        require __DIR__ . strtr($name, '\\', DIRECTORY_SEPARATOR) . '.php';
    }
});
