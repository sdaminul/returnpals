<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'reference' => 'PKG-' . fake()->unique()->numerify('######'),
            'status' => fake()->randomElement(['In Transit', 'Received', 'Processing', 'Processed']),
            'notes' => fake()->optional(0.6)->sentence(),
            'shipped_at' => fake()->dateTimeBetween('-60 days', '-1 days'),
            'received_at' => fn (array $attributes) => 
                in_array($attributes['status'], ['Received', 'Processing', 'Processed']) 
                    ? fake()->dateTimeBetween($attributes['shipped_at'], 'now')
                    : null,
        ];
    }

    /**
     * Indicate that the package is in transit.
     */
    public function inTransit(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'In Transit',
            'received_at' => null,
        ]);
    }

    /**
     * Indicate that the package has been received.
     */
    public function received(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Received',
            'received_at' => fake()->dateTimeBetween($attributes['shipped_at'] ?? '-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the package is being processed.
     */
    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Processing',
            'received_at' => fake()->dateTimeBetween($attributes['shipped_at'] ?? '-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the package has been processed.
     */
    public function processed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Processed',
            'received_at' => fake()->dateTimeBetween($attributes['shipped_at'] ?? '-30 days', 'now'),
        ]);
    }
}
