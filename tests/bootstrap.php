<?php

declare(strict_types=1);

/**
 * Bootstrap file for PHPUnit tests.
 *
 * Loads the autoloader and provides stub interfaces when the real
 * Phlix interfaces are not available via Composer.
 */

$autoloadPaths = [
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../../vendor/autoload.php',
];

$autoloaderFound = false;
foreach ($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require_once $autoloadPath;
        $autoloaderFound = true;
        break;
    }
}

if (!$autoloaderFound) {
    // Fallback: try to find composer autoload in ancestor directories
    $dir = __DIR__;
    for ($i = 0; $i < 10; $i++) {
        $dir = dirname($dir);
        $autoloadPath = $dir . '/vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            require_once $autoloadPath;
            $autoloaderFound = true;
            break;
        }
    }
}

// Load dev stubs if the real interfaces are not available
if (!interface_exists(\Phlix\Shared\Plugin\LifecycleInterface::class)) {
    require_once __DIR__ . '/../dev-stubs/LifecycleInterface.php';
}

if (!interface_exists(\Phlix\Theming\ThemeSourceInterface::class)) {
    require_once __DIR__ . '/../dev-stubs/ThemeSourceInterface.php';
}
