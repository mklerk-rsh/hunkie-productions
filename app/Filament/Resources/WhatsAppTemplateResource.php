<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsAppTemplateResource\Pages;
use App\Models\WhatsAppTemplate;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WhatsAppTemplateResource extends Resource
{
    protected static ?string $model = WhatsAppTemplate::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Communication';

    protected static ?string $slug = 'whatsapp-templates';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Template Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('template_id')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('content')
                            ->columnSpanFull(),
                        TextInput::make('variables')
                            ->helperText('Comma-separated variable names')
                            ->maxLength(255),
                        Toggle::make('is_active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('template_id')
                    ->searchable(),
                TextColumn::make('content')
                    ->limit(50),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (WhatsAppTemplate $record): string => WhatsAppTemplateResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (WhatsAppTemplate $record) => $record->delete()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsAppTemplates::route('/'),
        ];
    }
}
