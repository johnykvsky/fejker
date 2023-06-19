# Fejker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-github-actions]][link-github-actions]


This is slim (~9Mb less) version of [fakerphp.github.io](https://fakerphp.github.io).

Only following languages are available: `en_GB`, `en_US`, `pl_PL`

Changes:
 1) replaced custom DI container with `phpwatch/simple-container`
 2) added typehintint (removed phpdoc params)
 3) added `declare(strict_types=1);`
 4) removed all languages except `en_GB`, `en_US`, `pl_PL`
 5) removed ORM support
 6) removed deprecated code (since this is already BC break from original Faker)
 7) removed File, Image, HtmlLorem providers
 8) removed Barcode provider (there still is Barcode Extension)

### Basic Usage

Use `Fejker\Factory::create()` to create and initialize a Fejker generator, which can generate data by accessing methods named after the type of data you want.

```php
<?php

// use the factory to create a Fejker\Generator instance
$faker = Fejker\Factory::create();
// generate data by calling methods
echo $faker->name();
// 'Vince Sporer'
echo $faker->email();
// 'walter.sophia@hotmail.com'
echo $faker->text();
// 'Numquam ut mollitia at consequuntur inventore dolorem.'
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/johnykvsky/fejker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/johnykvsky/fejker.svg?style=flat-square
[ico-github-actions]: https://github.com/johnykvsky/fejker/actions/workflows/php.yml/badge.svg

[link-packagist]: https://packagist.org/packages/johnykvsky/fejker
[link-downloads]: https://packagist.org/packages/johnykvsky/fejker
[link-author]: https://github.com/johnykvsky
[link-github-actions]: https://github.com/johnykvsky/fejker/actions
