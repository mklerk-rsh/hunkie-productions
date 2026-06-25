<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessages extends BaseWidget
{
    protected int|string|array $columnSpan = 'half';

    protected static ?string $heading = 'Latest Messages';

    public function table(Table $table): Table
    {
        return $table
            ->query(Contact::latest()->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('subject')
                    ->limit(30),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Received'),
            ]);
    }
}
