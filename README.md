# Spectral Dusk Theme

A bioluminescent teal-cyan UI theme for Phlix with deep purple undertones.

## Theme Details

- **Theme ID:** spectral-dusk
- **Theme Name:** Spectral Dusk
- **Extends:** midnight
- **Type:** Dark UI Theme

## Color Palette

### Primary Accent
| Token | Value | Usage |
|-------|-------|-------|
| `--accent` | `#00e5cc` | Primary teal-cyan accent |
| `--accent-hover` | `#33ffe8` | Hover state for accent |
| `--accent-active` | `#00b8a3` | Active/pressed state |
| `--accent-soft` | `rgba(0, 229, 204, 0.12)` | Soft accent for backgrounds |
| `--accent-ring` | `rgba(0, 229, 204, 0.45)` | Focus rings and outlines |
| `--accent-text` | `#00ffe5` | The accent color as foreground text/icon — AA (≥4.5:1) on bg/surface (not the general text role; that is `--text`) |

### Backgrounds & Surfaces
| Token | Value | Usage |
|-------|-------|-------|
| `--bg` | `#06030a` | Deepest background |
| `--surface` | `#0d0812` | Primary surface |
| `--surface-2` | `#170d1f` | Elevated surface |
| `--surface-3` | `#221428` | Higher elevation surface |
| `--surface-glass` | `rgba(13, 8, 18, 0.68)` | Glass effect background |
| `--surface-glass-strong` | `rgba(6, 3, 10, 0.85)` | Strong glass effect |

### Text
| Token | Value | Usage |
|-------|-------|-------|
| `--text` | `#e8e0f0` | Primary text (lavender white) |
| `--text-muted` | `#a89bb8` | Muted text |
| `--text-subtle` | `#8d7ea4` | Subtle/hint text — placeholders/labels (AA on all surfaces) |
| `--text-faint` | `#4a3d5c` | Faintest text (below AA — owner-parked; see src docblock) |
| `--text-on-accent` | `#06030a` | Text on accent color |

### Borders
| Token | Value | Usage |
|-------|-------|-------|
| `--border` | `#1e1528` | Default border |
| `--border-subtle` | `#140f1c` | Subtle border |
| `--border-strong` | `#302640` | Strong/emphasis border |

### Atmospheric Effects
| Token | Value | Usage |
|-------|-------|-------|
| `--ambient` | `rgba(120, 60, 180, 0.18)` | Ambient glow effect |
| `--vignette` | `rgba(30, 0, 40, 0.65)` | Vignette overlay |
| `--grain-opacity` | `0.035` | Film grain intensity |

### Legacy `--color-*` aliases

Five of the tokens above are deliberately duplicated under their deprecated
`--color-*` alias names. The alias family predates the modern tokens and the
shipped SPA still reads it — live `var()` consumers in `phlix-ui`
(PhotoView/PhotoAlbum pages and the admin WebhookLogs page): `--color-bg`
(4 reads), `--color-surface` (11), `--color-text` (2), `--color-text-muted`
(7), `--color-border` (13); read counts measured 2026-11-06 at `phlix-ui`
origin/master `eb9e991c`.

| Alias | Value | Modern twin |
|-------|-------|-------------|
| `--color-bg` | `#06030a` | `--bg` |
| `--color-surface` | `#0d0812` | `--surface` |
| `--color-text` | `#e8e0f0` | `--text` |
| `--color-text-muted` | `#a89bb8` | `--text-muted` |
| `--color-border` | `#1e1528` | `--border` |

Pairing law: a theme that overrides a modern token also sets its legacy alias
to the same bytes — "such a theme should set both, which is why both halves
are on the allowlist" (`phlix-server` `src/Theming/BuiltInThemes.php` class
docblock) — so alias and twin cannot drift while both live in one payload.
The 17 aliases whose modern twins are *not* overridden here are omitted
deliberately: the midnight base declares them as `var()` references, which
resolve against the element's own computed value at runtime.

### Inheritance

The tables above are the theme's complete override set: 28 of the 53
allowlisted tokens (23 modern + the 5 aliases). Spectral Dusk extends the
built-in **midnight** base (`extends: midnight` in the payload), so the
remaining 25 tokens — the whole 8-token status family and the 17
un-overridden `--color-*` aliases — inherit midnight's values unchanged.

## Installation

The theme ships as a Phlix plugin. The server installs plugins from its
**catalog** (`plugins.json`): each entry pins an exact commit (`ref`) and the
sha256 of that commit's tarball (`artifactSha256`), and the server verifies
those bytes before extracting anything. An un-pinned source is refused
outright — a deliberate default-deny, not a bug to work around. There is no
supported route that installs this plugin by adding it to the server's
`composer.json`.

**Admin UI** — *Admin → Plugins* (`/app/admin/plugins`), find **Spectral Dusk
Theme**, press **Install**, then flip its switch to enable it.

**CLI** — the same thing, from the server root. Pass the repository URL, not
the plugin name:

```bash
php bin/phlix plugin:install https://github.com/detain/phlix-plugin-spectral-dusk-theme
php bin/phlix plugin:enable  phlix-plugin-spectral-dusk-theme
```

## Usage

Install and enable are separate steps: a fresh install lands **disabled**,
and enabling is a database flag flipped by `PluginLoader::enable()` — there is
no per-plugin `enabled` key in any server config file. If installing changed
nothing, the plugin was installed but never enabled.

Theme choice is **per user**: open *Settings → Appearance* and pick **Spectral
Dusk**. The selection is stored in `user_profiles.active_theme_id` and applies
to your account only; there is no global theme config key.

## Development

### Requirements
- PHP >= 8.3
- Phlix Server >= 0.44.0

### Quality Checks

```bash
# Run PHPStan static analysis
composer phpstan

# Run PHPCS code style check
composer phpcs

# Run PHPUnit tests
composer test
```

## License

MIT License — see [LICENSE](LICENSE) file for details.
