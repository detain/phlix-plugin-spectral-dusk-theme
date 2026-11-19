---
description: Quality tooling and test conventions for the Spectral Dusk Phlix theme plugin
globs:
  - "src/**/*.php"
  - "tests/**/*.php"
  - "dev-stubs/**/*.php"
---

# Quality Tooling & Tests

- The host interfaces `Phlix\Shared\Plugin\LifecycleInterface` and `Phlix\Theming\ThemeSourceInterface` are not shipped via Composer. Development copies live in `dev-stubs/` and are loaded by `tests/bootstrap.php` only when the real interface is missing from the autoloader.
- When a stub in `dev-stubs/` gains or changes a method, mirror it in `src/SpectralDuskPlugin.php` — e.g. `themeSourceName()` returns `self::SOURCE_NAME`.
- Run static analysis through the config file so `scanDirectories` picks up `dev-stubs/`: `vendor/bin/phpstan analyse -c phpstan.neon` (level `9`, analyses `src` only). Do not run `phpstan analyse src`.
- Run style checks through the ruleset so `tests/` and `dev-stubs/` are covered: `vendor/bin/phpcs --standard=phpcs.xml` (single `PSR12` rule). Do not run `phpcs src`.
- The `Unit` suite in `phpunit.xml` points at the `tests` directory; add new tests under `tests/` using PHP 8 attributes (`#[Test]`, `#[CoversClass]`).
- `.github/workflows/test.yml` runs the same three checks on PHP `8.3` and `8.4`.

```bash
composer phpstan
composer phpcs
composer test
```
