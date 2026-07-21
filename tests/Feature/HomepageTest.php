<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Repair;
use App\Models\Customer;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_homepage_and_see_service_board_and_tracker()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Live Service');
        $response->assertSee('Ticket Tracker');
        $response->assertSee('Last 3 Days Activity Tracker');
        $response->assertSee('Staff Login');
    }

    public function test_logged_in_user_is_redirected_to_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_tracking_non_existent_ticket_shows_not_found()
    {
        $response = $this->post(route('track.search'), [
            'ticket_id' => 'M3-INVALID-TICKET'
        ]);

        // Route: track.search POST redirects to track.form GET with ticket_id param
        $response->assertRedirect(route('track.form', ['ticket_id' => 'M3-INVALID-TICKET']));

        $followResponse = $this->followingRedirects()->post(route('track.search'), [
            'ticket_id' => 'M3-INVALID-TICKET'
        ]);
        
        $followResponse->assertStatus(200);
        $followResponse->assertSee('Ticket ID Not Found');
    }

    public function test_tracking_existent_ticket_shows_details()
    {
        $customer = Customer::create([
            'name' => 'Fahim Ahmed',
            'phone' => '01999888777',
        ]);

        $repair = Repair::create([
            'ticket_id' => 'M3-202607-TEST',
            'customer_id' => $customer->id,
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 13',
            'issue_description' => 'Battery replacement',
            'estimated_cost' => 3500.00,
            'status' => 'repairing',
        ]);

        $response = $this->followingRedirects()->post(route('track.search'), [
            'ticket_id' => 'M3-202607-TEST'
        ]);

        $response->assertStatus(200);
        $response->assertSee('Fahim Ahmed');
        $response->assertSee('iPhone 13');
        $response->assertSee('Battery replacement');
        $response->assertSee('Active Repair Room'); // timeline status label for 'repairing'
    }

    public function test_logged_in_user_with_ticket_id_is_not_redirected_to_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/track?ticket_id=M3-202607-TEST');

        // It should return 200, NOT redirect
        $response->assertStatus(200);
        $response->assertSee('Live Service');
        $response->assertSee('Ticket Tracker');
    }

    public function test_dashboard_pages_contain_ticket_tracker()
    {
        // 1. Admin
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Live Repair Ticket Tracker');

        // 2. Technician
        $tech = User::factory()->create([
            'role' => 'technician',
        ]);
        $response = $this->actingAs($tech)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Live Repair Ticket Tracker');

        // 3. Salesman
        $sales = User::factory()->create([
            'role' => 'salesman',
        ]);
        $response = $this->actingAs($sales)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Live Repair Ticket Tracker');
    }

    public function test_ajax_tracking_returns_partial_html_successfully()
    {
        $customer = Customer::create([
            'name' => 'Kamil Hasan',
            'phone' => '01555444333',
        ]);

        $repair = Repair::create([
            'ticket_id' => 'M3-202607-AJAX',
            'customer_id' => $customer->id,
            'device_brand' => 'Samsung',
            'device_model' => 'Galaxy S22',
            'issue_description' => 'Charging port replacement',
            'estimated_cost' => 1800.00,
            'status' => 'pending',
        ]);

        $response = $this->get('/track-ajax?ticket_id=M3-202607-AJAX');

        $response->assertStatus(200);
        $response->assertSee('Kamil Hasan');
        $response->assertSee('Galaxy S22');
        $response->assertSee('Awaiting Review'); // timeline status label for 'pending'
    }

    public function test_super_admin_sees_leaderboard_and_activities()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
        ]);

        $response = $this->actingAs($superAdmin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Top Technicians Performance');
        $response->assertSee('Recent Staff Activities');
    }

    public function test_regular_admin_does_not_see_leaderboard_and_activities()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('Top Technicians Performance');
        $response->assertDontSee('Recent Staff Activities');
    }

    public function test_dashboard_displays_low_stock_items_when_available()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create a low stock inventory item
        InventoryItem::create([
            'name' => 'iPhone 13 Display OLED',
            'sku' => 'PART-IP13-DISP',
            'type' => 'part',
            'category' => 'Screens',
            'quantity' => 1,
            'alert_quantity' => 3,
            'cost_price' => 4500.00,
            'sale_price' => 6000.00,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Low Stock Inventory Warnings');
        $response->assertSee('iPhone 13 Display OLED');
        $response->assertSee('PART-IP13-DISP');
    }
}
