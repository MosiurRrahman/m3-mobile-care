<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    /**
     * Display a listing of expenses.
     */
    public function indexExpenses(Request $request)
    {
        $query = Expense::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('description', 'like', "%{$search}%");
        }

        if ($request->filled('month')) {
            $month = $request->input('month');
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('expense_date', $parts[0])
                      ->whereMonth('expense_date', $parts[1]);
            }
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $expenses = $query->orderBy('expense_date', 'desc')->paginate($perPage)->withQueryString();
        
        // Sums by Category
        $sums = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();
            
        $dbCategories = Expense::select('category')->distinct()->pluck('category')->toArray();
        $defaultCategories = ['Rent', 'Salary', 'Utility', 'Purchase', 'Other'];
        $categories = array_values(array_unique(array_merge($defaultCategories, $dbCategories)));

        foreach ($categories as $cat) {
            if (!isset($sums[$cat])) {
                $sums[$cat] = 0;
            }
        }
        
        $totalExpenses = array_sum($sums);

        return view('expenses.index', compact('expenses', 'sums', 'totalExpenses', 'categories'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function storeExpense(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'custom_category' => 'required_if:category,__custom__|nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expense_date' => 'required|date',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            if (!auth()->user()->isSuperAdmin()) {
                return redirect()->back()->withErrors(['category' => 'Only Super Admin can create custom expense categories.'])->withInput();
            }
            $category = trim($request->input('custom_category'));
        }

        Expense::create([
            'category'      => $category,
            'amount'        => $request->input('amount'),
            'description'   => $request->input('description'),
            'expense_date'  => $request->input('expense_date'),
            'register_type' => null, // Explicitly null for general shop expenses
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense logged successfully!');
    }

    /**
     * Update the specified expense in storage.
     */
    public function updateExpense(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'category' => 'required|string|max:100',
            'custom_category' => 'required_if:category,__custom__|nullable|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'expense_date' => 'required|date',
        ]);

        $category = $request->input('category');
        if ($category === '__custom__') {
            if (!auth()->user()->isSuperAdmin()) {
                return redirect()->back()->withErrors(['category' => 'Only Super Admin can create custom expense categories.'])->withInput();
            }
            $category = trim($request->input('custom_category'));
        }

        $expense->update([
            'category'     => $category,
            'amount'       => $request->input('amount'),
            'description'  => $request->input('description'),
            'expense_date' => $request->input('expense_date'),
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense record updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroyExpense($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('admin.expenses.index')->with('success', 'Expense record removed successfully!');
    }
}
