<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Service;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Show landing page. If ticket_id is provided, show tracking details.
     */
    public function index(Request $request)
    {
        if (auth()->check() && !$request->filled('ticket_id')) {
            return redirect()->route('dashboard');
        }

        $repair = null;
        $searched = false;

        if ($request->filled('ticket_id')) {
            $searched = true;
            $repair = Repair::with('technician')
                ->where('ticket_id', trim($request->input('ticket_id')))
                ->first();
        }

        // Last 3 days data lookup
        $threeDaysAgo = now()->subDays(3)->startOfDay();
        
        $recentRepairs = Repair::where('created_at', '>=', $threeDaysAgo)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $repairsByStatus = Repair::where('created_at', '>=', $threeDaysAgo)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('home', compact('repair', 'searched', 'recentRepairs', 'repairsByStatus'));
    }

    /**
     * Handle track form submission (POST) and redirect to GET route.
     */
    public function track(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string',
        ]);

        return redirect()->route('track.form', ['ticket_id' => trim($request->input('ticket_id'))]);
    }

    /**
     * Show booking form.
     */
    public function showBookingForm()
    {
        $services = Service::all();
        return view('book-repair', compact('services'));
    }

    /**
     * Handle online repair booking submission.
     */
    public function book(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'device_brand' => 'required|string|max:100',
            'device_model' => 'required|string|max:100',
            'serial_imei' => 'nullable|string|max:100',
            'issue_description' => 'required|string',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        // Generate unique Ticket ID
        do {
            $ticketId = 'M3-' . date('Ym') . '-' . strtoupper(Str::random(4));
        } while (Repair::where('ticket_id', $ticketId)->exists());

        // Calculate estimated cost: if a service was specified, we can auto-fill or use a default
        $estimatedCost = $request->input('estimated_cost', 0);
        if (!$estimatedCost) {
            // Check if service name is standard and get price from DB
            $matchedService = Service::where('name', 'like', '%' . $request->input('device_model') . '%')->first();
            $estimatedCost = $matchedService ? $matchedService->price : 0;
        }

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['phone' => trim($request->input('customer_phone'))],
            [
                'name' => trim($request->input('customer_name')),
                'email' => trim($request->input('customer_email')),
            ]
        );

        $repair = Repair::create([
            'ticket_id' => $ticketId,
            'customer_id' => $customer->id,
            'device_brand' => $request->input('device_brand'),
            'device_model' => $request->input('device_model'),
            'serial_imei' => $request->input('serial_imei'),
            'issue_description' => $request->input('issue_description'),
            'estimated_cost' => $estimatedCost,
            'status' => 'pending',
        ]);

        return redirect()->route('book.success', ['ticket_id' => $repair->ticket_id])
            ->with('success', 'Repair request booked successfully!');
    }

    /**
     * Show booking success page.
     */
    public function bookingSuccess($ticket_id)
    {
        $repair = Repair::where('ticket_id', $ticket_id)->firstOrFail();
        return view('booking-success', compact('repair'));
    }

    /**
     * AJAX route for live ticket tracking.
     */
    public function trackAjax(Request $request)
    {
        $repair = Repair::with(['technician', 'customer'])
            ->where('ticket_id', trim($request->input('ticket_id')))
            ->first();
            
        return view('_partials.track-modal-body', compact('repair'))->render();
    }
}
