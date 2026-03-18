<?php

namespace Database\Factories;

use App\Models\AgencyProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgencyProfileFactory extends Factory
{
    protected $model = AgencyProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => fake()->company(),
            'contact_person' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'company_info' => fake()->paragraph(),
        ];
    }
}
