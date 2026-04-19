<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class CanadaStatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $provinces = [
            // 10 Provinces
            'Alberta', 'British Columbia', 'Manitoba', 'New Brunswick',
            'Newfoundland and Labrador', 'Nova Scotia', 'Ontario',
            'Prince Edward Island', 'Quebec', 'Saskatchewan',
            // 3 Territories
            'Northwest Territories', 'Nunavut', 'Yukon',
        ];

        foreach ($provinces as $name) {
            State::firstOrCreate(['name' => $name, 'country_id' => 38]);
        }
    }
}
