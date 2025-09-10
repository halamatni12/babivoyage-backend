<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('city')
                    ->required(),
                TextInput::make('country')
                    ->required(),
            ]);
    }
}
