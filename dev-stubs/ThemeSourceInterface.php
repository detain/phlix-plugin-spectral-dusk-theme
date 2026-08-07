<?php

declare(strict_types=1);

namespace Phlix\Theming;

/**
 * Stub of ThemeSourceInterface for development-time type checking.
 *
 * This interface is declared by the Phlix server host and is not available
 * via Composer. It is loaded by tests/bootstrap.php when the real interface
 * is absent from the autoloader.
 */
interface ThemeSourceInterface
{
    /**
     * Return the unique source name for this theme provider.
     */
    public function themeSourceName(): string;

    /**
     * Returns a map of theme-id => theme-descriptor for all themes provided
     * by this plugin.
     *
     * @return array<string, array{
     *     id: string,
     *     name: string,
     *     dark: bool,
     *     extends: string,
     *     tokens: array<string, string>
     * }>
     */
    public function providedThemes(): array;
}
