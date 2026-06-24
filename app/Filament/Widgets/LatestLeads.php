<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeads extends BaseWidget
{
    protected int | string | array $columnSpan = 'half';

    protected static ?string $heading = 'Latest Leads';

    public function table(Table $table): Table
    {
        return $table
            ->query(Lead::latest()->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Received'),
            ]);
    }
}
