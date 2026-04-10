# Settings page

`filament-billing` ships with a lightweight settings page for the dashboard.

## What it configures

- dashboard visibility
- navigation label
- navigation group
- recent invoices limit
- recent quotes limit

## Storage model

The page persists overrides in the application cache layer.
This keeps the package independent from a custom database table while still allowing runtime configuration.

The effective configuration is the merge of:

1. package defaults from `config/filament-billing.php`
2. saved overrides from the settings page

## Typical usage

Open the billing settings page in the panel, adjust the values, and save them.

The billing overview widgets and dashboard registration will pick up the stored overrides automatically.

## Notes

- if dashboard display is disabled, the overview widgets are not registered
- if the cache store is cleared, the package falls back to the published config defaults
- this page is intended for runtime tuning, not for editing the invoice data itself
