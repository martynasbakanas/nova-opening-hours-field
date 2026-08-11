# Nova Opening Hours Field

[Laravel](https://laravel.com) [Nova](https://nova.laravel.com) custom field for [Spatie Opening Hours](https://github.com/spatie/opening-hours)

This fork preserves the Composer package name and PHP namespace of the original package while providing compatibility with Nova 5 and Spatie Opening Hours 4.

## Compatibility

| Package version | PHP | Laravel Nova | Spatie Opening Hours |
| --- | --- | --- | --- |
| `^4.0` | `^8.2` | `^5.0` | `^4.2` |
| `^3.0` | `^7.2 \| ^8.0` | `^4.13` | `^2.0 \| ^3.0` |

### Index

![Screenshot Index](screenshot-index.png)

### Form

![Screenshot Form](screenshot-form.png)

### Detail

![Screenshot Detail](screenshot-detail.png)

## Installation

Add this fork as a VCS repository, then install it using the original Composer package name:

```bash
composer config repositories.nova-opening-hours-field vcs https://github.com/martynasbakanas/nova-opening-hours-field
composer require sadekd/nova-opening-hours-field:^4.0
```

Version 4 is a breaking release that requires Nova 5, PHP 8.2 or newer, and Spatie Opening Hours 4.

## Usage

Laravel Migration

```php
$table->json('opening_hours');  // can be ->nullable()
```

Laravel Model

```php
protected $casts = [
    'opening_hours' => 'array',
];
```

Nova Resource

```php
NovaOpeningHoursField::make(__('Opening Hours'), 'opening_hours'),
// ->allowExceptions(FALSE)    // TRUE by default
// ->allowOverflowMidnight(TRUE)  // FALSE by default
// ->useTextInputs(TRUE)  // FALSE by default
```

## Known issues

- Lazy validation on time field - losing focus when live(help needed)
- Editing date in exceptions causes row jumping - key from date(help needed)
- Browser time input does not support 24:00
- Browser date input does not support recurring format

## TODO

- [x] Explode interval input => time fields
- [x] Validation
- [x] Localization
- [x] Exceptions
- [ ] Tests

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
