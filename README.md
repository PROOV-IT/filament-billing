# ProovIT Filament Billing

Filament 5 panel plugin for the ProovIT billing core.

## What it provides

- a Filament panel plugin entry point
- native Filament resources for billing models
- dashboard widgets powered by `proovit/laravel-billing`
- package configuration
- publishable English and French translations

## Documentation

- [Installation](docs/install.md)
- [Configuration](docs/configuration.md)
- [Billing dashboard](docs/use-cases/dashboard.md)
- [Settings page](docs/use-cases/settings-page.md)
- [Business actions](docs/use-cases/business-actions.md)
- [Demo seeding](docs/use-cases/demo-seeding.md)
- [Release process](docs/release-process.md)
- [Docs index](docs/index.md)

## Installation

```bash
composer require proovit/filament-billing
```

You do not need to run `php artisan billing:install` for the plugin to function.
That command is part of the core package and is only needed when you want to explicitly
publish or customize the core package configuration.

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
- The package is organized around native Filament resources, relation managers, and widgets instead of custom Blade screens
- The demo seeder is designed for local testing and panel walkthroughs
- Most user-facing strings are translatable through `filament-billing-translations`
- `dev` is the integration branch; tags are cut from `main`
- Keep plugin-only releases on the fourth numeric segment when the billing core does not change
- The plugin can run against the core package defaults; the core installer is optional
