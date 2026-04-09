# Business actions

`filament-billing` exposes the main billing workflows directly in Filament table actions.

## Invoice actions

Invoices can expose the following actions from the list view:

- finalize a draft invoice
- generate a public share link
- revoke a public share link
- create a credit note from an invoice

## Quote actions

Quotes can expose the following actions from the list view:

- convert a quote into an invoice

## Design goal

These actions are thin wrappers around the billing core actions. The plugin does not reimplement the workflow logic. It only exposes the workflows in a Filament-native way.
