<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Proovit\FilamentBilling\Http\Controllers\Invoices\DownloadInvoicePdfController;

Route::middleware(['web', 'auth'])
    ->prefix(trim((string) config('filament.path', 'admin'), '/').'/billing')
    ->name('filament-billing.')
    ->group(static function (): void {
        Route::get('invoices/{record}/download-pdf', DownloadInvoicePdfController::class)
            ->name('invoices.download-pdf');
    });
