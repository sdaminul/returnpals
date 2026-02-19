<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    // Package validation tests
    
    public function test_package_reference_is_required(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => '',
            'items' => [
                ['product_name' => 'Test', 'quantity' => 1, 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('reference');
    }

    public function test_package_reference_max_length(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => str_repeat('A', 256),
            'items' => [
                ['product_name' => 'Test', 'quantity' => 1, 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('reference');
    }

    public function test_package_notes_max_length(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'notes' => str_repeat('A', 1001),
            'items' => [
                ['product_name' => 'Test', 'quantity' => 1, 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('notes');
    }

    public function test_package_requires_at_least_one_item(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'items' => []
        ]);

        $response->assertSessionHasErrors('items');
    }

    public function test_package_item_product_name_is_required(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'items' => [
                ['product_name' => '', 'quantity' => 1, 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('items.0.product_name');
    }

    public function test_package_item_quantity_is_required(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'items' => [
                ['product_name' => 'Test', 'quantity' => '', 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('items.0.quantity');
    }

    public function test_package_item_quantity_must_be_positive(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'items' => [
                ['product_name' => 'Test', 'quantity' => 0, 'condition' => 'New']
            ]
        ]);

        $response->assertSessionHasErrors('items.0.quantity');
    }

    public function test_package_item_condition_is_required(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.packages.store'), [
            'reference' => 'TEST',
            'items' => [
                ['product_name' => 'Test', 'quantity' => 1, 'condition' => '']
            ]
        ]);

        $response->assertSessionHasErrors('items.0.condition');
    }

    // Settings validation tests

    public function test_settings_vat_registered_must_be_boolean(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.settings.update'), [
            'vat_registered' => 'not-a-boolean',
        ]);

        $response->assertSessionHasErrors('vat_registered');
    }

    public function test_settings_discord_webhook_must_be_valid_url(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.settings.update'), [
            'discord_webhook_url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('discord_webhook_url');
    }

    public function test_settings_discord_webhook_max_length(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.settings.update'), [
            'discord_webhook_url' => 'https://example.com/' . str_repeat('a', 500),
        ]);

        $response->assertSessionHasErrors('discord_webhook_url');
    }

    public function test_settings_accepts_valid_data(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post(route('dashboard.settings.update'), [
            'vat_registered' => true,
            'discord_webhook_url' => 'https://discord.com/api/webhooks/123456/abcdef',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
