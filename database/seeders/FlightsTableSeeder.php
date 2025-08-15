<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Destination;
use App\Models\Airline;

class FlightsTableSeeder extends Seeder
{
    public function run(): void
    {
        $airline = Airline::inRandomOrder()->first();
        $departure = Destination::where('city', 'Beirut')->first();
        $arrival = Destination::where('city', 'Paris')->first();

        Flight::create([
            'flight_number' => 'MEA123',
            'airline_id' => $airline->id,
            'departure_id' => $departure->id,
            'arrival_id' => $arrival->id,
            'departure_time' => now()->addDays(3)->setTime(10, 0),
            'arrival_time' => now()->addDays(3)->setTime(14, 0),
            'base_price' => 350.00,
            'class' => 'economy',
        ]);
    }
}

