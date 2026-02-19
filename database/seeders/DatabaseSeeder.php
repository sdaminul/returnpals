<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@returnpals.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create operator users
        $operator1 = \App\Models\User::factory()->create([
            'name' => 'Operator One',
            'email' => 'operator1@returnpals.com',
            'password' => bcrypt('password'),
            'role' => 'operator',
        ]);

        $operator2 = \App\Models\User::factory()->create([
            'name' => 'Operator Two',
            'email' => 'operator2@returnpals.com',
            'password' => bcrypt('password'),
            'role' => 'operator',
        ]);

        // Create packages for admin
        // In Transit packages
        \App\Models\Package::factory(3)
            ->inTransit()
            ->for($admin)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(1, 4))
                    ->for($package)
                    ->create();
            });

        // Received packages
        \App\Models\Package::factory(5)
            ->received()
            ->for($admin)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(2, 5))
                    ->for($package)
                    ->create();
            });

        // Processing packages
        \App\Models\Package::factory(4)
            ->processing()
            ->for($admin)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(1, 3))
                    ->for($package)
                    ->create();
            });

        // Processed packages
        \App\Models\Package::factory(6)
            ->processed()
            ->for($admin)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(2, 4))
                    ->for($package)
                    ->create();
            });

        // Create packages for operators
        \App\Models\Package::factory(3)
            ->inTransit()
            ->for($operator1)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(1, 3))
                    ->for($package)
                    ->create();
            });

        \App\Models\Package::factory(4)
            ->received()
            ->for($operator2)
            ->create()
            ->each(function ($package) {
                \App\Models\PackageItem::factory(rand(1, 4))
                    ->for($package)
                    ->create();
            });

        // Create pending items
        \App\Models\PendingItem::factory(8)->for($admin)->create();
        \App\Models\PendingItem::factory(5)->for($operator1)->create();
        \App\Models\PendingItem::factory(6)->for($operator2)->create();

        // Create sold items
        \App\Models\SoldItem::factory(15)->for($admin)->create();
        \App\Models\SoldItem::factory(8)->for($operator1)->create();
        \App\Models\SoldItem::factory(10)->for($operator2)->create();

        // Create invoices
        \App\Models\Invoice::factory(10)->for($admin)->create();
        \App\Models\Invoice::factory(5)->for($operator1)->create();
        \App\Models\Invoice::factory(7)->for($operator2)->create();
    }
}
