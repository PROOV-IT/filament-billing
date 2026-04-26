<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Proovit\FilamentBilling\Http\Controllers\Invoices\DownloadInvoicePdfController;

Route::middleware(['web', 'auth'])->group(function () {
    $prefix = trim((string) config('filament.path', 'admin'), '/');
    
    Route::get($prefix . '/billing/invoices/{record}/download-pdf', DownloadInvoicePdfController::class)
        ->name('filament-billing.invoices.download-pdf');
});
