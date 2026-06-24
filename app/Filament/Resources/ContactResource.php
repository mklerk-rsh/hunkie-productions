<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use App\Models\ContactReply;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Leads';

    protected static ?string $slug = 'contacts';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Contact Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(40),
                IconColumn::make('is_read')
                    ->boolean()
                    ->label('Read')
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Replies')
                    ->sortable(),
                IconColumn::make('has_quotation')
                    ->label('Quote')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-arrow-down')
                    ->falseIcon('')
                    ->trueColor('success'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('unread')
                    ->query(fn (Builder $q) => $q->where('is_read', false))
                    ->label('Unread Only'),
                Filter::make('has_replies')
                    ->query(fn (Builder $q) => $q->has('replies'))
                    ->label('Replied'),
            ])
            ->actions([
                Action::make('view')
                    ->label('Read')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Contact $record): string => static::getUrl('view', ['record' => $record])),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-reply')
                    ->color('primary')
                    ->action(function (Contact $record, array $data): void {
                        ContactReply::create([
                            'contact_id' => $record->id,
                            'admin_id' => Auth::id(),
                            'message' => $data['message'],
                        ]);

                        $record->markAsReplied();

                        Notification::make()
                            ->title('Reply sent')
                            ->body('Your reply has been sent to ' . $record->name)
                            ->success()
                            ->send();
                    })
                    ->form([
                        Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->modalHeading(fn (Contact $record) => 'Reply to ' . $record->name)
                    ->modalWidth('lg')
                    ->modalIcon('heroicon-o-reply'),
                Action::make('mark_read')
                    ->label('Mark Read')
                    ->icon('heroicon-o-check')
                    ->action(fn (Contact $record) => $record->markAsRead())
                    ->hidden(fn (Contact $record) => $record->is_read),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
