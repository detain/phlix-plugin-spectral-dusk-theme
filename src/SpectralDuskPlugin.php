<?php

/**
 * Phlix Spectral Dusk theme plugin: a twilight theme provider.
 *
 * @copyright 2026 Joe Huss <detain@interserver.net>
 * @license   MIT
 */

declare(strict_types=1);

namespace Phlix\SpectralDusk;

use Phlix\Shared\Plugin\LifecycleInterface;
use Phlix\Theming\ThemeSourceInterface;
use Psr\Container\ContainerInterface;

/**
 * Spectral Dusk UI theme plugin for Phlix.
 *
 * A bioluminescent teal-cyan aesthetic with deep purple undertones,
 * evoking the luminous hush of deep twilight.
 */
final class SpectralDuskPlugin implements LifecycleInterface, ThemeSourceInterface
{
    public const SOURCE_NAME = 'spectral-dusk';

    public function themeSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    /**
     * @inheritDoc
     *
     * @return list<array<array-key, mixed>>
     */
    public function providedThemes(): array
    {
        return [
            [
                'id'      => 'spectral-dusk',
                'name'    => 'Spectral Dusk',
                'dark'    => true,
                'extends' => 'midnight',
                'tokens'  => [
                    '--accent'            => '#00e5cc',
                    '--accent-hover'      => '#33ffe8',
                    '--accent-active'     => '#00b8a3',
                    // KNOWN LIMITATION (owner-gated values; do not silently
                    // re-tune here — W-min157 ask-quote). Measured at this tip
                    // via WCAG relative luminance: the .45 ring composites to
                    // #036961 = 3.12:1 on --bg — the estate's thinnest honest
                    // pass (midnight's .60 ring composites to 4.04:1 on its
                    // own bg) — and only 2.68:1 against --border, so the
                    // normal→focus transition barely shifts; the .12 soft halo
                    // is 1.18:1 (effectively invisible; midnight uses .16).
                    // The review's lift — ring to ~.55–.60 (4.19–4.87:1),
                    // soft to ~.16 — fits the budget (teal as pure fill is
                    // 12.76:1), but token VALUES are owner-watermark.
                    // [review webux m1]
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
                    '--text-subtle'       => '#8d7ea4',
                    // KNOWN LIMITATION (owner-gated value; do not silently
                    // re-tune here — W-min157 ask-quote). The faintest ramp
                    // rung reproduces the family tell at 1.99–2.06:1:
                    // measured 2.06 on --bg, 1.99 on --surface, 1.90/1.76 on
                    // --surface-2/-3, 2.01 on the color-mix'd input ground
                    // phlix-ui paints ::placeholder with (AuthField.vue),
                    // plus the login/signup footnote rows — all far below
                    // the 4.5:1 body floor and under even WCAG 3:1. Root
                    // cause is estate-side (every built-in's faint sits
                    // ~2:1 and the UI loads this rung with hint copy), but
                    // the theme owns the value: a lift to ≥3:1 (~#6a5b7d
                    // mauve-consistent) is parked for the owner's family
                    // decision. [review webux m2]
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

    public function onEnable(ContainerInterface $container): void
    {
        // No-op: theme registration is declarative via ThemeSourceInterface
    }

    public function onDisable(): void
    {
        // No-op: theme cleanup is handled by the host system
    }

    /**
     * A theme plugin subscribes to no events.
     *
     * @return array<class-string, string|callable> Always empty.
     */
    public function subscribedEvents(): array
    {
        return [];
    }
}
