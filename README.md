# Spectral Dusk Theme

A bioluminescent teal-cyan UI theme for Phlix with deep purple undertones, evoking the magical atmosphere of twilight in a mystical forest.

## Theme Details

- **Theme ID:** spectral-dusk
- **Theme Name:** Spectral Dusk
- **Extends:** midnight
- **Type:** Dark UI Theme
- **Category:** phlix-plugins, phlix, phlix-plugin, ui-theme, theme, phlix-theme, spectral-dusk, teal-theme, dark-theme, purple-theme, bioluminescent, twilight, mystical

## Color Palette

### Primary Accent
| Token | Value | Usage |
|-------|-------|-------|
| `--accent` | `#00e5cc` | Primary teal-cyan accent |
| `--accent-hover` | `#33ffe8` | Hover state for accent |
| `--accent-active` | `#00b8a3` | Active/pressed state |
| `--accent-soft` | `rgba(0, 229, 204, 0.12)` | Soft accent for backgrounds |
| `--accent-ring` | `rgba(0, 229, 204, 0.45)` | Focus rings and outlines |
| `--accent-text` | `#00ffe5` | Text overlaid on dark backgrounds |

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
| `--text-subtle` | `#7a6b8a` | Subtle/hint text |
| `--text-faint` | `#4a3d5c` | Faintest text |
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

## Installation

```json
"require": {
    "detain/phlix-plugin-spectral-dusk-theme": "^1.0.0"
}
```

## Usage

Enable the theme in your Phlix configuration:

```json
{
    "plugins": {
        "phlix-plugin-spectral-dusk-theme": {
            "enabled": true
        }
    },
    "theme": {
        "id": "spectral-dusk"
    }
}
```

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

MIT License - see [LICENSE](LICENSE) file for details.
