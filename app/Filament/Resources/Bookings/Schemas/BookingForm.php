<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components;
use Illuminate\Validation\Rules\Unique;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Components\Select::make('user_id')
                ->label('Customer')
                ->relationship('user', 'name')
                ->required()
                ->searchable()
                ->preload(),

            Components\Select::make('flight_id')
                ->label('Flight')
                ->relationship('flight', 'flight_number')
                ->required()
                ->searchable()
                ->preload()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $price = \App\Models\Flight::query()->whereKey($state)->value('base_price');
                        if ($price !== null) {
                            $set('total_amount', $price);
                        }
                    }
                }),

            Components\DateTimePicker::make('booking_date')->required(),

            Components\TextInput::make('seat_number')
                ->maxLength(10)
                ->helperText('Seat must be unique per flight.')
                ->unique(
                    ignoreRecord: true,
                    modifyRuleUsing: function (Unique $rule, callable $get) {
                        $flightId = $get('flight_id');
                        if ($flightId) {
                            $rule->where('flight_id', $flightId);
                        }
                        return $rule;
                    }
                ),

            Components\Select::make('status')
                ->options([
                    'pending'   => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),

            Components\TextInput::make('total_amount')
                ->numeric()
                ->required()
                ->suffix('USD'),
        ])->columns(2);
    }
}
