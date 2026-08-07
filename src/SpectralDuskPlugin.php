<?php

declare(strict_types=1);

namespace Phlix\SpectralDusk;

use Phlix\Shared\Plugin\LifecycleInterface;

/**
 * Spectral Dusk UI theme plugin for Phlix.
 *
 * A bioluminescent teal-cyan aesthetic with deep purple undertones,
 * evoking the magical atmosphere of twilight in a mystical forest.
 */
final class SpectralDuskPlugin implements LifecycleInterface, ThemeSourceInterface
{
    public const SOURCE_NAME = 'spectral-dusk';

    /**
     * @return array<string, array{
     *     id: string,
     *     name: string,
     *     dark: bool,
     *     extends: string,
     *     tokens: array<string, string>
     * }>
     */
    public function providedThemes(): array
    {
        return [
            'spectral-dusk' => [
                'id'      => 'spectral-dusk',
                'name'    => 'Spectral Dusk',
                'dark'    => true,
                'extends' => 'midnight',
                'tokens'  => [
                    '--accent'            => '#00e5cc',
                    '--accent-hover'      => '#33ffe8',
                    '--accent-active'     => '#00b8a3',
                    '--accent-soft'       => 'rgba(0, 229, 204, 0.12)',
                    '--accent-ring'       => 'rgba(0, 229, 204, 0.45)',
                    '--accent-text'       => '#00ffe5',
                    '--bg'                => '#06030a',
                    '--surface'           => '#0d0812',
                    '--surface-2'         => '#170d1f',
                    '--surface-3'         => '#221428',
                    '--surface-glass'     => 'rgba(13, 8, 18, 0.68)',
                    '--surface-glass-strong' => 'rgba(6, 3, 10, 0.85)',
                    '--text'              => '#e8e0f0',
                    '--text-muted'        => '#a89bb8',
                    '--text-subtle'       => '#7a6b8a',
                    '--text-faint'        => '#4a3d5c',
                    '--text-on-accent'    => '#06030a',
                    '--border'            => '#1e1528',
                    '--border-subtle'     => '#140f1c',
                    '--border-strong'     => '#302640',
                    '--grain-opacity'     => '0.035',
                    '--vignette'          => 'rgba(30, 0, 40, 0.65)',
                    '--ambient'           => 'rgba(120, 60, 180, 0.18)',
                    '--color-bg'          => '#06030a',
                    '--color-surface'     => '#0d0812',
                    '--color-text'        => '#e8e0f0',
                    '--color-text-muted'  => '#a89bb8',
                    '--color-border'      => '#1e1528',
                ],
            ],
        ];
    }

    public function onEnable(): void
    {
        // No-op: theme registration is declarative via ThemeSourceInterface
    }

    public function onDisable(): void
    {
        // No-op: theme cleanup is handled by the host system
    }

    /**
     * @return class-string[]
     */
    public function subscribedEvents(): array
    {
        return [];
    }
}
