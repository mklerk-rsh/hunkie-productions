<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationLogResource\Pages;
use App\Models\NotificationLog;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NotificationLogResource extends Resource
{
    protected static ?string $model = NotificationLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bell';

    protected static string|\UnitEnum|null $navigationGroup = 'Communication';

    protected static ?string $slug = 'notification-logs';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Notification Details')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'email' => 'Email',
                                'sms' => 'SMS',
                                'whatsapp' => 'WhatsApp',
                                'push' => 'Push',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('recipient')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('subject')
                            ->maxLength(255),
                        Textarea::make('message')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'sent' => 'Sent',
                                'failed' => 'Failed',
                                'pending' => 'Pending',
                            ])
                            ->required()
                            ->native(false),
                        DateTimePicker::make('sent_at'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('recipient')
                    ->searchable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'sent' => 'success',
                        'failed' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('sent_at')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'email' => 'Email',
                        'sms' => 'SMS',
                        'whatsapp' => 'WhatsApp',
                        'push' => 'Push',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'sent' => 'Sent',
                        'failed' => 'Failed',
                        'pending' => 'Pending',
                    ]),
                Filter::make('sent_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn (Builder $q, array $data) => $q
                        ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('sent_at', '>=', $date))
                        ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('sent_at', '<=', $date))
                    ),
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (NotificationLog $record): string => NotificationLogResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (NotificationLog $record) => $record->delete()),
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
            'index' => Pages\ListNotificationLogs::route('/'),
        ];
    }
}
