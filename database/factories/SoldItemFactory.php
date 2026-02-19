<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoldItem>
 */
class SoldItemFactory extends Factory
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

        $quantity = fake()->numberBetween(1, 3);
        $unitPrice = fake()->randomFloat(2, 50, 1500);
        $totalRevenue = $quantity * $unitPrice;
        $profit = $totalRevenue * fake()->randomFloat(2, 0.15, 0.45);
        $margin = ($profit / $totalRevenue) * 100;

        return [
            'user_id' => \App\Models\User::factory(),
            'reference' => 'SOLD-' . fake()->unique()->numerify('######'),
            'product_name' => fake()->randomElement($products),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_revenue' => $totalRevenue,
            'profit' => $profit,
            'margin' => $margin,
            'sold_at' => fake()->dateTimeBetween('-60 days', 'now'),
            'status' => fake()->randomElement(['Completed', 'Pending', 'Shipped']),
        ];
    }
}
