# Configuration

The package ships with a minimal configuration file:

```php
return [
    'navigation_group' => 'Billing',
    'dashboard' => [
        'enabled' => true,
        'slug' => 'billing-overview',
        'title' => 'Billing Overview',
        'navigation_label' => 'Billing',
        'recent_invoices_limit' => 5,
    ],
];
```

## Options

- `navigation_group`: group used by the Filament page navigation
- `dashboard.enabled`: registers or skips the billing overview page
- `dashboard.slug`: route slug of the overview page
- `dashboard.title`: title displayed by the page
- `dashboard.navigation_label`: label displayed in the panel navigation
- `dashboard.recent_invoices_limit`: number of invoices shown in the overview table

## Panel customization

The plugin is intentionally lightweight so that it can be extended per panel later.
You can override the configuration values in your application config and the page will pick them up automatically.
