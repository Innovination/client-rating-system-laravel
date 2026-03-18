<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Dispute;
use App\Models\DisputeCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisputeFactory extends Factory
{
    protected $model = Dispute::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'agency_user_id' => User::factory(),
            'dispute_category_id' => DisputeCategory::factory(),
            'project_type' => fake()->randomElement(['Web Development', 'SEO', 'Branding', 'Performance Marketing']),
            'dispute_type' => fake()->randomElement(['payment_delay', 'scope_creep', 'non_payment', 'communication_issue']),
            'issue_description' => fake()->paragraphs(2, true),
            'supporting_notes' => fake()->boolean(70) ? fake()->sentence() : null,
            'status' => Dispute::STATUS_VISIBLE,
            'moderated_by' => null,
            'moderated_at' => null,
        ];
    }

    public function hidden(): static
    {
        return $this->state(fn () => [
            'status' => Dispute::STATUS_HIDDEN,
            'moderated_by' => User::factory(),
            'moderated_at' => now(),
        ]);
    }
}
