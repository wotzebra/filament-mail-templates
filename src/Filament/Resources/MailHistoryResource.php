<?php

namespace Wotz\FilamentMailTemplates\Filament\Resources;

use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use UnitEnum;
use Wotz\FilamentMailTemplates\Filament\Resources\MailHistoryResource\Pages;
use Wotz\FilamentMailTemplates\Models\MailHistory;

class MailHistoryResource extends Resource
{
    protected static ?string $model = MailHistory::class;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return config(
            'filament-mail-templates.navigation.history.group',
            parent::getNavigationGroup()
        );
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return config(
            'filament-mail-templates.navigation.history.icon',
            parent::getNavigationIcon()
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config(
            'filament-mail-templates.navigation.history.shown',
            parent::shouldRegisterNavigation()
        );
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Recipients')->schema([
                    TextEntry::make('to_email')
                        ->label(__('filament-mail-templates::admin.to email'))
                        ->state(fn ($record) => implode(', ', $record->to_emails)),

                    TextEntry::make('cc_email')
                        ->label(__('filament-mail-templates::admin.cc email'))
                        ->state(fn ($record) => implode(', ', $record->cc_emails)),

                    TextEntry::make('bcc_email')
                        ->label(__('filament-mail-templates::admin.bcc email'))
                        ->state(fn ($record) => implode(', ', $record->bcc_emails)),
                ]),

                TextEntry::make('preview')
                    ->columnSpan(['lg' => 2])
                    ->label(__('filament-mail-templates::admin.email content'))
                    ->state(fn ($record) => view('filament-mail-templates::filament.forms.preview-column', [
                        'record' => $record,
                    ])),

                Section::make('Debug data')->schema([
                    Grid::make()->schema([
                        TextEntry::make('created_at')
                            ->label(__('filament-mail-templates::admin.created at'))
                            ->state(fn ($record) => $record->created_at->format('Y-m-d H:i:s')),

                        TextEntry::make('template')
                            ->label(__('filament-mail-templates::admin.template'))
                            ->state(fn ($record) => $record->template?->identifier),

                        TextEntry::make('mailed_resource_type')
                            ->label(__('filament-mail-templates::admin.resource type'))
                            ->state(fn ($record) => $record->mailed_resource_type),

                        TextEntry::make('mailed_resource_id')
                            ->label(__('filament-mail-templates::admin.resource id'))
                            ->state(fn ($record) => $record->mailed_resource_id),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('filament-mail-templates::admin.created at'))
                    ->sortable(),

                TextColumn::make('template')
                    ->label(__('filament-mail-templates::admin.template'))
                    ->getStateUsing(fn ($record) => $record->template?->identifier)
                    ->sortable(),

                TextColumn::make('to_emails')
                    ->label(__('filament-mail-templates::admin.to email'))
                    ->getStateUsing(fn ($record) => $record->to_emails)
                    ->html()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('to_email')
                    ->label(__('filament-mail-templates::admin.to email')),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMailHistories::route('/'),
            'view' => Pages\ViewMailHistory::route('/{record}/view'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-templates::admin.history resource label');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-templates::admin.history resource label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-templates::admin.history resource singular label');
    }
}
