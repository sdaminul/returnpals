<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PendingItem>
 */
class PendingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'iPhone 13', 'Samsung Galaxy S21', 'iPad Pro', 'MacBook Air',
            'Sony WH-1000XM4', 'AirPods Pro', 'Nintendo Switch', 'PS5 Controller',
            'Apple Watch Series 7', 'Fitbit Charge 5', 'Kindle Paperwhite',
            'Canon EOS R6', 'GoPro Hero 11', 'DJI Mini 3', 'Dyson V15',
        ];

        $stages = ['Inspection', 'Cleaning', 'Testing', 'Packaging', 'Photography'];

        $receivedAt = fake()->dateTimeBetween('-30 days', '-1 days');

        return [
            'user_id' => \App\Models\User::factory(),
            'reference' => 'PEND-' . fake()->unique()->numerify('######'),
            'product_name' => fake()->randomElement($products),
            'quantity' => fake()->numberBetween(1, 3),
            'received_at' => $receivedAt,
            'stage' => fake()->randomElement($stages),
            'est_completion' => fake()->dateTimeBetween('now', '+14 days'),
            'note' => fake()->optional(0.5)->sentence(),
        ];
    }
}
