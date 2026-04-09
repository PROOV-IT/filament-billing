# Installation

## Requirements

- PHP 8.3
- Laravel 13
- Filament 5
- `proovit/laravel-billing:^1.0`

## Install the package

```bash
composer require proovit/filament-billing
```

## Register the plugin

Add the plugin to one of your Filament panel providers:

```php
use Filament\Panel;
use Proovit\FilamentBilling\FilamentBillingPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentBillingPlugin::make());
}
```

## Publish configuration

```bash
php artisan vendor:publish --tag=filament-billing-config
```

## Publish views

```bash
php artisan vendor:publish --tag=filament-billing-views
```
