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
The 17 aliases the midnight family declares beyond those five are omitted
from this payload — deliberately, but their omission is uniform only in the
payload, not in effect, because the theme resolves along two paths. In the
browser, `data-theme` carries the midnight base and only this payload's
tokens are inlined on top; midnight's aliases are all `var()` references
(`phlix-tokens` `src/css/colors.css`, midnight block), so each resolves at
computed-value time against the element's own twin. The 8 status aliases
(`--color-success`/`-warning`/`-error`/`-info` and their `-bg` forms) point
at twins this theme leaves midnight's and follow midnight. The other 9 —
`--color-surface-hover`/`-elevated`/`-active`, `--color-text-secondary`,
`--color-text-subtle`, `--color-primary`, `--color-primary-hover`,
`--color-primary-active`, `--color-border-subtle` — point at twins the
tables above *do* override, and so show Spectral's values. The server-side
path splits from the browser on those same 9: `ThemeSourceRegistry::resolveTokens`
array-merges `BuiltInThemes`' literal transcription (`var()` resolved at
authoring time; the map `GET /api/v1/themes` serves and non-CSS clients
read), where alias and twin are independent values and the 9 stay
midnight's hex. That is precisely the one-half drift the pairing law above
exists to prevent — disclosed here rather than cured, because closing it
means adding nine alias values to the payload, and token values are
owner-watermark.

Only 5 of the 17 have any live `var()` reader in `phlix-ui`: the diverging
`--color-text-secondary` (8 reads — the SyncPlay and ParentalControls pages
and the admin UpdateAvailableBanner) and the four non-`-bg` status aliases
(5 reads, consistent on both paths); the remaining 12 measure zero. Read
counts re-measured 2026-11-06 at `phlix-ui` origin/master `eb9e991c`, the
same method as the stamped set above.

### Inheritance

The tables above are the theme's complete override set: 28 of the 53
allowlisted tokens (23 modern + the 5 aliases). Spectral Dusk extends the
built-in **midnight** base (`extends: midnight` in the payload), so the
remaining 25 tokens — the 8 modern status tokens and the 17 omitted
`--color-*` aliases — are never written by this theme: the status family is
midnight's unchanged on every path, while the 9 aliases whose modern twins
are overridden follow the split browser/payload resolution described
above.

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
