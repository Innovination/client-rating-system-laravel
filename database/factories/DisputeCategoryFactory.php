<?php

namespace Database\Factories;

use App\Models\DisputeCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DisputeCategoryFactory extends Factory
{
    protected $model = DisputeCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(10, 9999),
            'is_active' => true,
        ];
    }
}
