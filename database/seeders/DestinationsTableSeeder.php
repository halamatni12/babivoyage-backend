<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationsTableSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            ['city' => 'Beirut', 'country' => 'Lebanon'],
            ['city' => 'Paris', 'country' => 'France'],
            ['city' => 'Dubai', 'country' => 'UAE'],
            ['city' => 'London', 'country' => 'UK'],
            ['city' => 'Rome', 'country' => 'Italy'],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
