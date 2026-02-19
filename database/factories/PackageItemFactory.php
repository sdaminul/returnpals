<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PackageItem>
 */
class PackageItemFactory extends Factory
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
            'Dell XPS 13', 'HP Envy x360', 'LG OLED TV', 'Samsung Monitor',
        ];

        $conditions = ['New', 'Like New', 'Good', 'Fair', 'Poor'];

        return [
            'package_id' => \App\Models\Package::factory(),
            'product_name' => fake()->randomElement($products),
            'quantity' => fake()->numberBetween(1, 5),
            'condition' => fake()->randomElement($conditions),
            'notes' => fake()->optional(0.4)->sentence(),
        ];
    }
}
