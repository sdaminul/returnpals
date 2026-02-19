<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackageCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_packages_sent_list(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get(route('dashboard.overview'));
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.overview');
    }

    public function test_user_can_create_package(): void
    {
        $user = User::factory()->create();
        
        $packageData = [
            'reference' => 'TEST-001',
            'notes' => 'Test package notes',
            'items' => [
                [
                    'product_name' => 'iPhone 13',
                    'quantity' => 2,
                    'condition' => 'New',
                    'notes' => 'Item notes',
                ]
            ]
        ];

        $response = $this->actingAs($user)
            ->post(route('dashboard.packages.store'), $packageData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Package added successfully.');

        $this->assertDatabaseHas('packages', [
            'user_id' => $user->id,
            'reference' => 'TEST-001',
            'status' => 'In Transit',
        ]);

        $this->assertDatabaseHas('package_items', [
            'product_name' => 'iPhone 13',
            'quantity' => 2,
            'condition' => 'New',
        ]);
    }

    public function test_user_can_update_their_package(): void
    {
        $user = User::factory()->create();
        $package = Package::factory()->for($user)->create([
            'reference' => 'PKG-001',
        ]);

        $updateData = [
            'reference' => 'PKG-001-UPDATED',
            'notes' => 'Updated notes',
            'items' => [
                [
                    'product_name' => 'MacBook Air',
                    'quantity' => 1,
                    'condition' => 'Like New',
                    'notes' => null,
                ]
            ]
        ];

        $response = $this->actingAs($user)
            ->put(route('dashboard.packages.update', $package), $updateData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Package updated successfully.');

        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'reference' => 'PKG-001-UPDATED',
        ]);
    }

    public function test_user_cannot_update_another_users_package(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $package = Package::factory()->for($otherUser)->create();

        $updateData = [
            'reference' => 'HACKED',
            'notes' => 'Hacked',
            'items' => [
                [
                    'product_name' => 'Test',
                    'quantity' => 1,
                    'condition' => 'New',
                    'notes' => null,
                ]
            ]
        ];

        $response = $this->actingAs($user)
            ->put(route('dashboard.packages.update', $package), $updateData);

        $response->assertForbidden();
    }

    public function test_admin_can_update_any_package(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'operator']);
        $package = Package::factory()->for($user)->create([
            'reference' => 'PKG-002',
        ]);

        $updateData = [
            'reference' => 'PKG-002-ADMIN',
            'notes' => 'Admin update',
            'items' => [
                [
                    'product_name' => 'Test Product',
                    'quantity' => 1,
                    'condition' => 'New',
                    'notes' => null,
                ]
            ]
        ];

        $response = $this->actingAs($admin)
            ->put(route('dashboard.packages.update', $package), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'reference' => 'PKG-002-ADMIN',
        ]);
    }

    public function test_user_can_delete_their_package(): void
    {
        $user = User::factory()->create();
        $package = Package::factory()->for($user)->create();

        $response = $this->actingAs($user)
            ->delete(route('dashboard.packages.destroy', $package));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Package deleted successfully.');
        $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    }

    public function test_user_cannot_delete_another_users_package(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $package = Package::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)
            ->delete(route('dashboard.packages.destroy', $package));

        $response->assertForbidden();
        $this->assertDatabaseHas('packages', ['id' => $package->id]);
    }

    public function test_package_creation_requires_reference(): void
    {
        $user = User::factory()->create();
        
        $packageData = [
            'reference' => '',
            'items' => [
                [
                    'product_name' => 'iPhone 13',
                    'quantity' => 2,
                    'condition' => 'New',
                ]
            ]
        ];

        $response = $this->actingAs($user)
            ->post(route('dashboard.packages.store'), $packageData);

        $response->assertSessionHasErrors('reference');
    }

    public function test_package_creation_requires_at_least_one_item(): void
    {
        $user = User::factory()->create();
        
        $packageData = [
            'reference' => 'TEST-003',
            'items' => []
        ];

        $response = $this->actingAs($user)
            ->post(route('dashboard.packages.store'), $packageData);

        $response->assertSessionHasErrors('items');
    }
}
