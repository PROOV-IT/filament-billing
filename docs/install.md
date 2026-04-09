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

The plugin does not require `php artisan billing:install` to be run first.

You only need the core package installed and configured. If the core package is still using defaults, the plugin will continue to work with those defaults.

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

## Publish translations

```bash
php artisan vendor:publish --tag=filament-billing-translations
```

## Publish views

```bash
php artisan vendor:publish --tag=filament-billing-views
```

## Seed demo data

For a demo-ready panel, seed the Filament billing dataset:

```bash
php artisan db:seed --class=Proovit\\FilamentBilling\\Database\\Seeders\\FilamentBillingDemoSeeder --force
```

If you are using Sail:

```bash
./vendor/bin/sail artisan db:seed --class=Proovit\\FilamentBilling\\Database\\Seeders\\FilamentBillingDemoSeeder --force
```
