<?php

namespace Database\Factories;

use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminActionLogFactory extends Factory
{
    protected $model = AdminActionLog::class;

    public function definition(): array
    {
        $targetType = fake()->randomElement(['dispute', 'feedback', 'user', 'category']);

        return [
            'admin_user_id' => User::factory(),
            'action_type' => fake()->randomElement(['hide', 'restore', 'delete', 'suspend', 'unsuspend', 'update_category']),
            'target_type' => $targetType,
            'target_id' => fake()->numberBetween(1, 1000),
            'metadata' => [
                'reason' => fake()->sentence(),
                'ip' => fake()->ipv4(),
            ],
        ];
    }
}
