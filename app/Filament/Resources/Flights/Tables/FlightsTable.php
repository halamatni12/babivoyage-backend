<?php

namespace App\Filament\Resources\Flights\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FlightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('flight_number')
                    ->searchable(),
                TextColumn::make('airline_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('departure_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('arrival_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('departure_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('arrival_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('base_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('class')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
