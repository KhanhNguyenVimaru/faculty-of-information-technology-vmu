<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\professor>
 */
class ProfessorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'professor_id' => User::factory()->professor()->create()->id,
            'position' => $this->faker->randomElement(['Giảng viên', 'Trợ giảng', 'Giáo sư', 'Phó giáo sư']),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-30 years')->format('Y-m-d'),
            'education_level' => $this->faker->randomElement(['Thạc sĩ', 'Tiến sĩ', 'Phó giáo sư', 'Giáo sư']),
        ];
    }
    
    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (\App\Models\professor $professor) {
            // Thực hiện các thao tác sau khi tạo model nhưng trước khi lưu
        })->afterCreating(function (\App\Models\professor $professor) {
            // Thực hiện các thao tác sau khi tạo và lưu model
        });
    }
    
    /**
     * Indicate that the professor has a specific user ID.
     */
    public function forUser(User $user): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'professor_id' => $user->id,
            ];
        });
    }
}
