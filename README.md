# Playground Stub

[![Playground CI Workflow](https://github.com/gammamatrix/playground-stub/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-stub/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-stub/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground tool for building out [Laravel](https://laravel.com/docs/11.x) applications.

## Installation

**NOTE:** This is a development took and not meant for normal installations.

## `artisan about`

Playground Stub provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-stub.png" alt="screenshot of artisan about command with Playground Stub."> -->

## Configuration

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Playground\Stub\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground-stub.php](config/playground-stub.php)

## Commands

This application utilizes Laravel make commands.

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
- `lang/`
- `resources/views/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
