<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class AustraliaStatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            // 6 States
            'New South Wales', 'Victoria', 'Queensland',
            'Western Australia', 'South Australia', 'Tasmania',
            // 2 Territories
            'Australian Capital Territory', 'Northern Territory',
        ];

        foreach ($states as $name) {
            State::firstOrCreate(['name' => $name, 'country_id' => 13]);
        }
    }
}
