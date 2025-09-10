<?php

namespace App\Filament\Resources\Flights\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('flight_number')
                    ->required(),
                TextInput::make('airline_id')
                    ->required()
                    ->numeric(),
                TextInput::make('departure_id')
                    ->required()
                    ->numeric(),
                TextInput::make('arrival_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('departure_time')
                    ->required(),
                DateTimePicker::make('arrival_time')
                    ->required(),
                TextInput::make('base_price')
                    ->required()
                    ->numeric(),
                Select::make('class')
                    ->options(['economy' => 'Economy', 'business' => 'Business', 'first' => 'First'])
                    ->default('economy')
                    ->required(),
            ]);
    }
}
