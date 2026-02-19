<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customers = [
            'Acme Corp', 'TechStart Inc', 'Global Solutions Ltd', 'Digital Ventures',
            'Innovation Labs', 'Smart Systems Co', 'Future Tech', 'Alpha Trading',
        ];

        $invoiceDate = fake()->dateTimeBetween('-60 days', '-1 days');
        $dueDate = fake()->dateTimeBetween($invoiceDate, '+30 days');

        return [
            'user_id' => \App\Models\User::factory(),
            'invoice_number' => 'INV-' . fake()->unique()->numerify('####'),
            'customer' => fake()->randomElement($customers),
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'amount' => fake()->randomFloat(2, 500, 5000),
            'items' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['Paid', 'Pending', 'Overdue']),
        ];
    }
}
