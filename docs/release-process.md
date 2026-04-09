# Release Process

This plugin follows the same release convention as `proovit/laravel-billing`:

1. Development happens on the `dev` branch.
2. Merge `dev` into `main` for a release.
3. Tag `main` only.
4. When the core and plugin are released together, use the same version tag on both packages.
5. If only the plugin changes, use a fourth numeric segment on the tag, such as `1.0.0.1`.

Rules:

- Do not hardcode a `version` in `composer.json`.
- Use `dev-dev@dev` in the sandbox when testing the `dev` branch.
- Keep release tags immutable.
