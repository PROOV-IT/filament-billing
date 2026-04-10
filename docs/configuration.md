# Configuration

The package ships with a minimal configuration file:

```php
return [
    'dashboard' => [
        'enabled' => true,
        'recent_invoices_limit' => 5,
        'recent_quotes_limit' => 5,
    ],
];
```

## Options

- `dashboard.enabled`: registers or skips the billing widgets
- `dashboard.recent_invoices_limit`: number of invoices shown in the recent invoices widget
- `dashboard.recent_quotes_limit`: number of quotes shown in the recent quotes widget

## Panel customization

The plugin is intentionally lightweight so that it can be extended per panel later.
You can override the configuration values in your application config and the widgets will pick them up automatically.

## Runtime settings page

The package also ships with a panel settings page that persists dashboard overrides at runtime.

That page lets you adjust:

- dashboard visibility
- navigation label and group
- recent invoices limit
- recent quotes limit

The saved overrides are stored in the application cache layer and merged on top of the published config values.

All user-facing labels live in the package translation files and can be published with `filament-billing-translations`.
