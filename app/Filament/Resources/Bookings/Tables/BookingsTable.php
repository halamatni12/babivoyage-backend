<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
                Columns\TextColumn::make('flight.flight_number')->label('Flight'),
                Columns\TextColumn::make('booking_date')->dateTime(),
                Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => [
                        'pending'   => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                    ][$state] ?? 'gray'),
                Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('USD')   // Filament built-in formatting
                    ->sortable(),
            ])
            ->filters([
                Filters\SelectFilter::make('status')->options([
                    'pending'   => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ]),
            ])
            ->recordActions([
                Action::make('addPayment')
                    ->label('Add Payment')
                    ->icon('heroicon-o-banknotes')
                    ->url(fn ($record) => \App\Filament\Resources\Payments\PaymentResource::getUrl('create', [
                        'booking' => $record->getKey(),
                    ]))
                    ->openUrlInNewTab(),

                Action::make('confirm')
                    ->icon('heroicon-o-check')
                    ->visible(fn ($record) => $record->status === 'pending' && $record->payments()->exists())
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'confirmed'])),

                Action::make('cancel')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== 'cancelled')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'cancelled'])),

                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
