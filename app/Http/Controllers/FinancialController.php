<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    /**
     * Build filtered expenses query.
     */
    private function buildExpenseQuery(Request $request)
    {
        $query = Expense::query();

        // Exclude partner withdrawals from shop operational expenses ledger
        $query->where(function($q) {
            $q->whereNull('register_type')
              ->orWhere('register_type', '!=', 'withdraw');
        });

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('description', 'like', "%{$search}%");
        }

        // Specific Month filter (e.g. 2026-05)
        if ($request->filled('month')) {
            $month = $request->input('month');
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('expense_date', $parts[0])
                      ->whereMonth('expense_date', $parts[1]);
            }
        } elseif ($request->filled('period')) {
            $period = $request->input('period');
            if ($period === 'this_week') {
                $query->whereBetween('expense_date', [
                    now()->startOfWeek()->format('Y-m-d'),
                    now()->endOfWeek()->format('Y-m-d')
                ]);
            } elseif ($period === 'last_week') {
                $query->whereBetween('expense_date', [
                    now()->subWeek()->startOfWeek()->format('Y-m-d'),
                    now()->subWeek()->endOfWeek()->format('Y-m-d')
                ]);
            } elseif ($period === 'this_month') {
                $query->whereYear('expense_date', now()->year)
                      ->whereMonth('expense_date', now()->month);
            } elseif ($period === 'last_month') {
                $query->whereYear('expense_date', now()->subMonth()->year)
                      ->whereMonth('expense_date', now()->subMonth()->month);
            }
        } elseif ($request->filled('date_from') || $request->filled('date_to')) {
            if ($request->filled('date_from')) {
                $query->whereDate('expense_date', '>=', $request->input('date_from'));
            }
            if ($request->filled('date_to')) {
                $query->whereDate('expense_date', '<=', $request->input('date_to'));
            }
        }

        return $query->orderBy('expense_date', 'desc');
    }

    /**
     * Display a listing of expenses.
     */
    public function indexExpenses(Request $request)
    {
        $query = $this->buildExpenseQuery($request);

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $expenses = $query->paginate($perPage)->withQueryString();
        
        // Sums by Category (Excluding partner withdrawals)
        $sums = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->where(function($q) {
                $q->whereNull('register_type')
                  ->orWhere('register_type', '!=', 'withdraw');
            })
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();
            
        $dbCategories = Expense::select('category')
            ->where(function($q) {
                $q->whereNull('register_type')
                  ->orWhere('register_type', '!=', 'withdraw');
            })
            ->distinct()
            ->pluck('category')
            ->toArray();
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
     * Export expenses to Excel / CSV format.
     */
    public function exportExcel(Request $request)
    {
        $expenses = $this->buildExpenseQuery($request)->get();
        
        $prefix = 'expenses_report';
        if ($request->filled('period')) {
            $prefix = 'expenses_' . $request->input('period');
        } elseif ($request->filled('month')) {
            $prefix = 'expenses_month_' . $request->input('month');
        }
        $fileName = $prefix . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($expenses) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, ['ID', 'Category', 'Description', 'Amount (BDT)', 'Expense Date', 'Logged Date']);

            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->id,
                    $expense->category,
                    $expense->description ?? 'N/A',
                    number_format($expense->amount, 2, '.', ''),
                    $expense->expense_date,
                    $expense->created_at ? $expense->created_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export expenses to printable PDF view.
     */
    public function exportPdf(Request $request)
    {
        $expenses = $this->buildExpenseQuery($request)->get();
        $totalAmount = $expenses->sum('amount');

        $sums = $expenses->groupBy('category')->map(function ($group) {
            return $group->sum('amount');
        })->toArray();

        $filterInfo = [];
        if ($request->filled('period')) {
            $labels = [
                'this_week'  => 'This Week',
                'last_week'  => 'Last Week',
                'this_month' => 'This Month',
                'last_month' => 'Last Month',
            ];
            $filterInfo[] = 'Period: ' . ($labels[$request->input('period')] ?? $request->input('period'));
        } elseif ($request->filled('date_from') || $request->filled('date_to')) {
            $from = $request->input('date_from', 'Start');
            $to = $request->input('date_to', 'End');
            $filterInfo[] = "Date Range: $from to $to";
        } elseif ($request->filled('month')) {
            $filterInfo[] = 'Month: ' . $request->input('month');
        }

        if ($request->filled('category')) {
            $filterInfo[] = 'Category: ' . $request->input('category');
        }
        if ($request->filled('search')) {
            $filterInfo[] = 'Search: "' . $request->input('search') . '"';
        }

        $filterText = count($filterInfo) > 0 ? implode(' | ', $filterInfo) : 'All Time Records';

        return view('expenses.pdf', compact('expenses', 'totalAmount', 'sums', 'filterText'));
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
