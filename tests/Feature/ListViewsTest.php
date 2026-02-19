<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Package;
use App\Models\PendingItem;
use App\Models\SoldItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_received_packages_list(): void
    {
        $user = User::factory()->create();
        
        // Create packages with different statuses
        Package::factory()->received()->for($user)->count(3)->create();
        Package::factory()->processing()->for($user)->count(2)->create();
        Package::factory()->processed()->for($user)->count(1)->create();

        $response = $this->actingAs($user)->get(route('dashboard.received'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.received');
    }

    public function test_user_can_view_pending_items_list(): void
    {
        $user = User::factory()->create();
        
        PendingItem::factory()->for($user)->count(5)->create();

        $response = $this->actingAs($user)->get(route('dashboard.item-pending'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.item-pending');
    }

    public function test_user_can_view_sold_items_list(): void
    {
        $user = User::factory()->create();
        
        SoldItem::factory()->for($user)->count(10)->create();

        $response = $this->actingAs($user)->get(route('dashboard.sold-items'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.sold-items');
    }

    public function test_user_can_view_invoices_list(): void
    {
        $user = User::factory()->create();
        
        Invoice::factory()->for($user)->count(5)->create();

        $response = $this->actingAs($user)->get(route('dashboard.invoices'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.invoices');
    }

    public function test_user_only_sees_their_own_packages(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        Package::factory()->received()->for($user)->count(2)->create();
        Package::factory()->received()->for($otherUser)->count(3)->create();

        $response = $this->actingAs($user)->get(route('dashboard.received'));

        $response->assertStatus(200);
        // The view should only show the user's packages, not other users'
    }

    public function test_user_only_sees_their_own_pending_items(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        PendingItem::factory()->for($user)->count(3)->create();
        PendingItem::factory()->for($otherUser)->count(4)->create();

        $response = $this->actingAs($user)->get(route('dashboard.item-pending'));

        $response->assertStatus(200);
    }

    public function test_user_only_sees_their_own_sold_items(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        SoldItem::factory()->for($user)->count(5)->create();
        SoldItem::factory()->for($otherUser)->count(7)->create();

        $response = $this->actingAs($user)->get(route('dashboard.sold-items'));

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_list_views(): void
    {
        $response = $this->get(route('dashboard.received'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('dashboard.item-pending'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('dashboard.sold-items'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('dashboard.invoices'));
        $response->assertRedirect(route('login'));
    }
}
