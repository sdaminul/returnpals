<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_download_their_invoice(): void
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->for($user)->create([
            'invoice_number' => 'INV-001',
        ]);

        $response = $this->actingAs($user)
            ->get(route('dashboard.invoices.download', $invoice));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
    }

    public function test_user_cannot_download_another_users_invoice(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $invoice = Invoice::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)
            ->get(route('dashboard.invoices.download', $invoice));

        $response->assertForbidden();
    }

    public function test_guest_cannot_download_invoices(): void
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->for($user)->create();

        $response = $this->get(route('dashboard.invoices.download', $invoice));

        $response->assertRedirect(route('login'));
    }
}
