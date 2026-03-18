<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFeedbackFactory extends Factory
{
    protected $model = ClientFeedback::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'agency_user_id' => User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'feedback_text' => fake()->paragraph(),
            'status' => ClientFeedback::STATUS_VISIBLE,
            'moderated_by' => null,
            'moderated_at' => null,
        ];
    }

    public function hidden(): static
    {
        return $this->state(fn () => [
            'status' => ClientFeedback::STATUS_HIDDEN,
            'moderated_by' => User::factory(),
            'moderated_at' => now(),
        ]);
    }
}
