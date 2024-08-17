<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(Status::getValues()),
            'priority' => $this->faker->randomElement(TaskPriority::getValues()),
            'user_id' => $this->faker->randomElement(\App\Models\User::pluck('id')->toArray()),
            'project_id' => \App\Models\Project::factory(),
        ];
    }
}
