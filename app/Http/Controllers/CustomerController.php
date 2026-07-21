<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Repair;
use App\Models\Sale;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Eager load sum of POS dues
        $query->withSum('sales as total_sales_due', 'due_amount');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter only customers who have outstanding dues
        if ($request->boolean('due_only')) {
            $query->whereHas('sales', function($q) {
                $q->where('due_amount', '>', 0);
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $perPage = in_array($perPage, [15, 30, 50, 100]) ? $perPage : 15;

        $customers = $query->orderBy('name', 'asc')->paginate($perPage)->withQueryString();
        return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'district' => 'nullable|string|max:100',
        ]);

        $customer = Customer::create($request->all());

        // Check if AJAX request (from POS terminal checkout)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
                'message' => 'Customer registered successfully!'
            ]);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer registered successfully!');
    }

    /**
     * Display the customer profile with repair and sales history.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        
        // Eager load previous repairs
        $repairs = Repair::where('customer_id', $customer->id)
            ->with('technician')
            ->orderBy('created_at', 'desc')
            ->get();

        // Eager load POS purchases
        $sales = Sale::where('customer_id', $customer->id)
            ->with('details.item')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customers.show', compact('customer', 'repairs', 'sales'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'district' => 'nullable|string|max:100',
        ]);

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer profile updated successfully!');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
    }

    /**
     * Lookup customer by phone number.
     */
    public function lookup(Request $request)
    {
        $phone = trim($request->query('phone'));
        if (empty($phone)) {
            return response()->json(['found' => false]);
        }
        $customer = Customer::where('phone', $phone)->first();
        if ($customer) {
            return response()->json([
                'found' => true,
                'customer' => $customer
            ]);
        }
        return response()->json(['found' => false]);
    }
}
