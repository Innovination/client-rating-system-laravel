<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class UsaStatesTableSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
            'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia',
            'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa',
            'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland',
            'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri',
            'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey',
            'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio',
            'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina',
            'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
            'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming',
            // Federal district & territories
            'District of Columbia', 'Puerto Rico', 'Guam',
            'U.S. Virgin Islands', 'American Samoa', 'Northern Mariana Islands',
        ];

        foreach ($states as $name) {
            State::firstOrCreate(['name' => $name, 'country_id' => 229]);
        }
    }
}
