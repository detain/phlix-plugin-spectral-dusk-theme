<?php

declare(strict_types=1);

namespace Phlix\Shared\Plugin;

use Psr\Container\ContainerInterface;

/**
 * Stub of LifecycleInterface for development-time type checking.
 *
 * This interface is declared by the Phlix server host and is not available
 * via Composer in all environments. It is loaded by tests/bootstrap.php
 * when the real interface is absent from the autoloader.
 */
interface LifecycleInterface
{
    /**
     * Called when the plugin is enabled.
     */
    public function onEnable(ContainerInterface $container): void;

    /**
     * Called when the plugin is disabled.
     */
    public function onDisable(): void;

    /**
     * Returns the list of event listener tags this plugin subscribes to.
     *
     * @return class-string[]
     */
    public function subscribedEvents(): array;
}
