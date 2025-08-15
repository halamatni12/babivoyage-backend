<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlinesTableSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            ['name' => 'Middle East Airlines', 'code' => 'MEA', 'logo_url' => null],
            ['name' => 'Air France', 'code' => 'AF', 'logo_url' => null],
            ['name' => 'Emirates', 'code' => 'EK', 'logo_url' => null],
            ['name' => 'British Airways', 'code' => 'BA', 'logo_url' => null],
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}
