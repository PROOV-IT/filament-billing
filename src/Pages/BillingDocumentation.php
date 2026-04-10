<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Route;

final class BillingDocumentation extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $slug = 'billing/documentation';

    protected static ?int $navigationSort = 8;

    public function getView(): string
    {
        return 'filament-billing::pages.billing-documentation';
    }

    public function getTitle(): string
    {
        return __('filament-billing::filament-billing.documentation.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-billing::filament-billing.documentation.navigation');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.documentation.sections.overview'))
                ->description(__('filament-billing::filament-billing.documentation.description')),
            Section::make(__('filament-billing::filament-billing.documentation.sections.paths'))
                ->description($this->pathsDescription()),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open_ui')
                ->label(__('filament-billing::filament-billing.documentation.actions.open_ui'))
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url($this->uiUrl())
                ->openUrlInNewTab(),
            Action::make('open_json')
                ->label(__('filament-billing::filament-billing.documentation.actions.open_json'))
                ->icon('heroicon-o-code-bracket-square')
                ->url($this->jsonUrl())
                ->openUrlInNewTab(),
        ];
    }

    private function uiUrl(): string
    {
        if (Route::has('billing.docs.ui')) {
            return route('billing.docs.ui');
        }

        return url((string) config('billing.docs.ui_path', 'docs/api/billing'));
    }

    private function jsonUrl(): string
    {
        if (Route::has('billing.docs.json')) {
            return route('billing.docs.json');
        }

        return url((string) config('billing.docs.json_path', 'docs/api/billing.json'));
    }

    private function pathsDescription(): string
    {
        return implode("\n\n", [
            (string) __('filament-billing::filament-billing.documentation.paths.description'),
            sprintf(
                '%s: `%s`',
                (string) __('filament-billing::filament-billing.documentation.paths.ui'),
                (string) config('billing.docs.ui_path', 'docs/api/billing'),
            ),
            sprintf(
                '%s: `%s`',
                (string) __('filament-billing::filament-billing.documentation.paths.json'),
                (string) config('billing.docs.json_path', 'docs/api/billing.json'),
            ),
        ]);
    }
}
