<?php

namespace Database\Factories;

use App\Enums\TicketPriorityLevel;
use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdBy = User::factory()->create();
        $assignedTo = User::factory()->create();
        $category = Category::factory()->create();
        $team = Team::factory()->create();

        return [
            'ticket_number' => 'TKT-' . str_pad($this->faker->unique()->randomNumber(5), 5, '0', STR_PAD_LEFT),
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement(TicketStatus::cases()),
            'category_id' => $category,
            'priority_level' => $this->faker->randomElement(TicketPriorityLevel::cases()),
            'team_id' => $team,
            'created_by' => $createdBy,
            'assigned_to' => $this->faker->boolean(70) ? $assignedTo : null,
            'parent_id' => null,
            'due_at' => $this->faker->optional(0.6)->dateTimeBetween('+1 day', '+2 weeks'),
            'resolved_at' => null,
            'closed_at' => null,
            'created_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'updated_at' => fn(array $attributes) => $attributes['created_at'],
        ];
    }

    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
           'status' => TicketStatus::OPEN,
           'resolved_at' => null,
           'closed_at' => null,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn(array $attributes)=>[
            'status' => TicketStatus::IN_PROGRESS,
            'resolved_at' => null,
            'closed_at' => null,
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => TicketStatus::RESOLVED,
            'resolved_at'=> now(),
            'closed_at' => null,
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => TicketStatus::CLOSED,
            'resolved_at'=> now()->subDay(rand(1, 7)),
            'closed_at' => now(),
        ]);
    }

    public function critical(): static
    {
        return $this->state(fn(array $attributes) =>[
            'priority_level' => TicketPriorityLevel::CRITICAL,
        ]);
    }

    public function high(): static
    {
        return $this->state(fn(array $attributes) =>[
            'priority_level' => TicketPriorityLevel::HIGH,
        ]);
    }
}
