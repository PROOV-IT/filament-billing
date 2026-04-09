# Demo seeding

The plugin ships with a dedicated demo seeder that prepares a realistic billing dataset for Filament.

It seeds the core billing records and also adds a quote that is left unconverted so you can immediately test the **Convert to invoice** workflow in the panel.

## Run the demo seeder

```bash
php artisan db:seed --class=Proovit\\FilamentBilling\\Database\\Seeders\\FilamentBillingDemoSeeder --force
```

If you are using Sail:

```bash
./vendor/bin/sail artisan db:seed --class=Proovit\\FilamentBilling\\Database\\Seeders\\FilamentBillingDemoSeeder --force
```

## What it creates

- companies and establishments
- customers and addresses
- invoices, quotes, credit notes and payments
- invoice share links
- demo quote data that is ready to be converted from Filament

## Why it exists

This seeder is meant for local development and panel demos. It gives you enough data to verify:

- resource CRUD pages
- table row actions
- relation managers
- dashboard widgets
