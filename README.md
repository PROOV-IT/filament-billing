# ProovIT Filament Billing

Filament 5 panel plugin for the ProovIT billing core.

## What it provides

- a Filament panel plugin entry point
- a billing overview page powered by `proovit/laravel-billing`
- package configuration and publishable views

## Documentation

- [Installation](docs/install.md)
- [Configuration](docs/configuration.md)
- [Billing dashboard](docs/use-cases/dashboard.md)
- [Docs index](docs/index.md)

## Installation

```bash
composer require proovit/filament-billing
```

Then register the plugin in your Filament panel provider:

```php
use Proovit\FilamentBilling\FilamentBillingPlugin;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FilamentBillingPlugin::make());
}
```

## Development

When developing against the `dev` branch of this repository, require it explicitly:

```json
"proovit/filament-billing": "dev-dev@dev"
```

## Notes

- Requires `proovit/laravel-billing:^1.0`
- Requires Filament 5
- The initial release focuses on the billing overview entry point; more resources can be added later without breaking the plugin contract
