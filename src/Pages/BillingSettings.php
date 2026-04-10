<?php

declare(strict_types=1);

namespace Proovit\FilamentBilling\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Proovit\FilamentBilling\Support\BillingSettingsRepository;
use Proovit\FilamentBilling\Support\Filament\Schemas\BillingSettingsFormSchema;

final class BillingSettings extends Page
{
    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public function getView(): string
    {
        return 'filament-billing::pages.billing-settings';
    }

    public function getTitle(): string
    {
        return __('filament-billing::filament-billing.settings.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-billing::filament-billing.settings.navigation');
    }

    public static function getNavigationGroup(): string
    {
        return (string) config('filament-billing.navigation_group', 'Billing');
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 9;

    protected static ?string $slug = 'billing/settings';

    public function mount(): void
    {
        $this->data = $this->payloadFromState();
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components(BillingSettingsFormSchema::schema());
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('filament-billing::filament-billing.settings.note.heading'))
                ->description(__('filament-billing::filament-billing.settings.note.body')),
            $this->getFormContentComponent(),
        ]);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('filament-billing::filament-billing.settings.actions.save'))
            ->icon('heroicon-o-check')
            ->submit('save');
    }

    public function save(): void
    {
        try {
            $payload = $this->payloadFromState();

            if (! app(BillingSettingsRepository::class)->save($payload)) {
                Notification::make()
                    ->title(__('filament-billing::filament-billing.settings.notifications.save_failed_title'))
                    ->body(__('filament-billing::filament-billing.settings.notifications.save_failed_body'))
                    ->danger()
                    ->send();

                return;
            }

            $this->data = $this->payloadFromState();

            Notification::make()
                ->title(__('filament-billing::filament-billing.settings.notifications.saved_title'))
                ->body(__('filament-billing::filament-billing.settings.notifications.saved_body'))
                ->success()
                ->send();
        } catch (Halt) {
            return;
        }
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                SchemaActions::make($this->getFormActions())
                    ->fullWidth(true)
                    ->sticky(true)
                    ->key('form-actions'),
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function payloadFromState(): array
    {
        return array_replace_recursive(
            config('filament-billing', []),
            app(BillingSettingsRepository::class)->all(),
            $this->data,
        );
    }
}
