<?php

declare(strict_types=1);

namespace Phlix\SpectralDusk\Tests;

use Phlix\SpectralDusk\SpectralDuskPlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Contrast contract law for the shipped token palette (scoped: --text-subtle).
 *
 * `--text-subtle` carries form labels, placeholders and hints (phlix-ui
 * AuthField.vue renders labels at --text-2xs semibold with this token;
 * Input `::placeholder`, Combobox, CommandPalette and secondary metadata
 * consume it across ~247 sites) — body-text tier, so WCAG 1.4.3 demands
 * AA (>= 4.5:1) on every ground the theme actually paints. Both built-in
 * baselines hold that bar for the same token (nocturne 5.36, midnight 5.05
 * on their own bg); the shipped #7a6b8a measured 4.19/4.05/3.86/3.59 on
 * bg/surface/surface-2/surface-3 (review theme-spectral-dusk__webux.md M1),
 * dragging the secondary text system under AA whenever this theme is active.
 *
 * Values are parsed from providedThemes() so the law follows the palette;
 * it is not a duplicated constant table. Translucent layers are composited
 * source-over exactly as the browser paints them. The WCAG 2.x math is
 * recomputed here from the hexes themselves — no external fixture to drift.
 */
#[CoversClass(SpectralDuskPlugin::class)]
final class TokenContrastTest extends TestCase
{
    /** WCAG 1.4.3 AA floor for normal-size text. */
    private const AA_TEXT_RATIO = 4.5;

    private SpectralDuskPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->plugin = new SpectralDuskPlugin();
    }

    /**
     * @return array<string, string>
     */
    private function tokens(): array
    {
        $themes = $this->plugin->providedThemes();
        /** @var array<string, string> $tokens */
        $tokens = $themes[0]['tokens'];

        return $tokens;
    }

    /**
     * Every opaque or composited ground --text-subtle is painted on.
     *
     * @return array<string, string>
     */
    private function grounds(): array
    {
        $tokens = $this->tokens();
        $grounds = [];
        foreach (['--bg', '--surface', '--surface-2', '--surface-3'] as $key) {
            $grounds[$key] = $tokens[$key];
        }

        // Glass panels: rgba layers source-over the deepest background.
        $grounds['--surface-glass on --bg'] = $this->toHex(
            $this->compositeOver($this->parseRgba($tokens['--surface-glass']), $this->parseHex($tokens['--bg']))
        );
        $grounds['--surface-glass-strong on --bg'] = $this->toHex(
            $this->compositeOver(
                $this->parseRgba($tokens['--surface-glass-strong']),
                $this->parseHex($tokens['--bg'])
            )
        );
        // The AuthField input fill: color-mix(--surface 80%) over --bg.
        $surface = $this->parseHex($tokens['--surface']);
        $bg = $this->parseHex($tokens['--bg']);
        $grounds['input fill (surface 80% over bg)'] = $this->toHex([
            (int) round(0.8 * $surface[0] + 0.2 * $bg[0]),
            (int) round(0.8 * $surface[1] + 0.2 * $bg[1]),
            (int) round(0.8 * $surface[2] + 0.2 * $bg[2]),
        ]);

        return $grounds;
    }

    #[Test]
    public function testTextSubtleMeetsAaAsBodyTierOnEveryGround(): void
    {
        $ink = $this->tokens()['--text-subtle'];

        foreach ($this->grounds() as $name => $ground) {
            $ratio = $this->contrastRatio($ink, $ground);
            $this->assertGreaterThanOrEqual(
                self::AA_TEXT_RATIO,
                $ratio,
                sprintf(
                    '--text-subtle %s on %s (%s) is %.2f:1 — below the 4.5:1 AA floor',
                    $ink,
                    $name,
                    $ground,
                    $ratio
                )
            );
        }
    }

    #[Test]
    public function testTextSubtleSitsStrictlyBetweenMutedAndFaintInLuminance(): void
    {
        $tokens = $this->tokens();
        $muted = $this->relativeLuminance($this->parseHex($tokens['--text-muted']));
        $subtle = $this->relativeLuminance($this->parseHex($tokens['--text-subtle']));
        $faint = $this->relativeLuminance($this->parseHex($tokens['--text-faint']));

        $this->assertLessThan(
            $muted,
            $subtle,
            '--text-subtle must stay dimmer than --text-muted (ramp order)'
        );
        $this->assertGreaterThan(
            $faint,
            $subtle,
            '--text-subtle must stay brighter than --text-faint (ramp order)'
        );
    }

    /**
     * WCAG 2.x relative luminance of an #rrggbb triple.
     *
     * @param array{int, int, int} $rgb
     */
    private function relativeLuminance(array $rgb): float
    {
        $channels = [];
        foreach ($rgb as $channel) {
            $srgb = $channel / 255;
            $channels[] = $srgb <= 0.04045
                ? $srgb / 12.92
                : ((($srgb + 0.055) / 1.055) ** 2.4);
        }

        return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
    }

    private function contrastRatio(string $hexA, string $hexB): float
    {
        return $this->contrastRatioRgb($this->parseHex($hexA), $this->parseHex($hexB));
    }

    /**
     * @param array{int, int, int} $rgbA
     * @param array{int, int, int} $rgbB
     */
    private function contrastRatioRgb(array $rgbA, array $rgbB): float
    {
        $luminanceA = $this->relativeLuminance($rgbA);
        $luminanceB = $this->relativeLuminance($rgbB);
        $brighter = max($luminanceA, $luminanceB);
        $darker = min($luminanceA, $luminanceB);

        return ($brighter + 0.05) / ($darker + 0.05);
    }

    /**
     * @return array{int, int, int}
     */
    private function parseHex(string $hex): array
    {
        $matches = [];
        if (preg_match('/^#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/', $hex, $matches) !== 1) {
            throw new RuntimeException("Contrast law expects literal #rrggbb, got '$hex'");
        }

        return [
            hexdec($matches[1]),
            hexdec($matches[2]),
            hexdec($matches[3]),
        ];
    }

    /**
     * 8-bit source-over compositing of an rgba token onto an opaque ground.
     *
     * @param array{int, int, int, float} $rgba
     * @param array{int, int, int} $ground
     *
     * @return array{int, int, int}
     */
    private function compositeOver(array $rgba, array $ground): array
    {
        [$r, $g, $b, $alpha] = $rgba;

        return [
            (int) round($alpha * $r + (1 - $alpha) * $ground[0]),
            (int) round($alpha * $g + (1 - $alpha) * $ground[1]),
            (int) round($alpha * $b + (1 - $alpha) * $ground[2]),
        ];
    }

    /**
     * @return array{int, int, int, float}
     */
    private function parseRgba(string $value): array
    {
        $matches = [];
        if (
            preg_match('/^rgba\((\d{1,3}), (\d{1,3}), (\d{1,3}), (0?\.\d+|1|0)\)$/', $value, $matches)
            !== 1
        ) {
            throw new RuntimeException("Contrast law expects literal rgba(r, g, b, a), got '$value'");
        }

        return [
            (int) $matches[1],
            (int) $matches[2],
            (int) $matches[3],
            (float) $matches[4],
        ];
    }

    /**
     * @param array{int, int, int} $rgb
     */
    private function toHex(array $rgb): string
    {
        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }
}
