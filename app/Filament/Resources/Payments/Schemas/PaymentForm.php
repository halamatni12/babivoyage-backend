<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('booking_id')
                ->label('Booking')
                ->relationship('booking', 'id') // You can replace 'id' with flight_number or user.name
                ->required()
                ->searchable()
                ->preload(),

            Select::make('method')
                ->options([
                    'credit_card'   => 'Credit Card',
                    'paypal'        => 'PayPal',
                    'bank_transfer' => 'Bank Transfer',
                    'cash'          => 'Cash',
                ])
                ->required(),

            TextInput::make('amount_paid')
                ->numeric()
                ->required()
                ->prefix('$'),

            TextInput::make('transaction_reference')
                ->maxLength(191),

            DateTimePicker::make('paid_at')
                ->default(now()),
        ])->columns(2);
    }
}
