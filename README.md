# Tracking of referrals in laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yormy/referral-system.svg?style=flat-square)](https://packagist.org/packages/yormy/referral-system)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/yormy/referral-system/run-tests?label=tests)](https://github.com/yormy/referral-system/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/yormy/referral-system.svg?style=flat-square)](https://packagist.org/packages/yormy/referral-system)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require yormy/referral-system
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Yormy\ReferralSystem\ReferralSystemServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Yormy\ReferralSystem\ReferralSystemServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$referral-system = new Yormy\ReferralSystem();
echo $referral-system->echoPhrase('Hello, Yormy!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Yormy](https://github.com/yormy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
