<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Repair;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CashController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isStaff = !$user->isSuperAdmin() && !$user->isAdmin();

        // Default to today if no date range is set
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $paymentMethod = $request->input('payment_method', 'Cash');
        
        $registerType = $request->input('register_type', 'combined'); // pos, service, combined
        
        // Staff role constraint: Force date to TODAY ONLY and lock register type
        if ($isStaff) {
            $startDate = Carbon::today()->toDateString();
            $endDate = Carbon::today()->toDateString();
            if ($user->isSalesman()) {
                $registerType = 'pos';
            } elseif ($user->isTechnician()) {
                $registerType = 'service';
            }
        }
        
        // Expenses toggle - default false so general shop expenses don't subtract from counter cash
        $includeExpenses = $request->has('include_expenses') 
            ? $request->boolean('include_expenses') 
            : false;

        // Calculate opening balance (cumulative inflow - outflow before start_date)
        $posInflowBefore = 0;
        $repairAdvanceBefore = 0;
        $repairFinalBefore = 0;
        $expensesBefore = 0;

        if ($registerType === 'pos' || $registerType === 'combined') {
            $posInflowBefore = Sale::where('payment_method', $paymentMethod)
                ->where('created_at', '<', $startDate . ' 00:00:00')
                ->sum('paid_amount');
        }

        if ($registerType === 'service' || $registerType === 'combined') {
            $repairAdvanceBefore = Repair::where('advance_payment_method', $paymentMethod)
                ->where('created_at', '<', $startDate . ' 00:00:00')
                ->sum('advance_payment');

            $repairFinalBefore = Repair::where('payment_method', $paymentMethod)
                ->whereIn('status', ['completed', 'delivered'])
                ->where('completed_at', '<', $startDate . ' 00:00:00')
                ->get()
                ->sum(function($r) {
                    return floatval($r->actual_cost) - floatval($r->advance_payment);
                });
        }

        if ($paymentMethod === 'Cash') {
            $expensesQuery = Expense::where('expense_date', '<', $startDate);
            if ($registerType === 'pos') {
                $expensesQuery->where('register_type', 'pos');
            } elseif ($registerType === 'service') {
                $expensesQuery->where('register_type', 'service');
            }

            if (!$includeExpenses) {
                $expensesQuery->where(function($q) {
                    $q->where('amount', '<', 0)
                      ->orWhereIn('category', ['Cash Deposit', 'Opening Float']);
                });
            }

            $expensesList = $expensesQuery->get();
            foreach ($expensesList as $exp) {
                if ($exp->amount < 0 || in_array($exp->category, ['Cash Deposit', 'Opening Float'])) {
                    $expensesBefore -= abs($exp->amount); // Increases opening balance
                } else {
                    $expensesBefore += abs($exp->amount); // Decreases opening balance
                }
            }
        }

        $openingBalance = ($posInflowBefore + $repairAdvanceBefore + $repairFinalBefore) - $expensesBefore;

        // Fetch details for the selected period
        $posSales = collect();
        if ($registerType === 'pos' || $registerType === 'combined') {
            $posSales = Sale::where('payment_method', $paymentMethod)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->get()
                ->map(function($sale) {
                    return [
                        'date' => $sale->created_at,
                        'type' => 'POS Sale',
                        'ref' => $sale->invoice_no,
                        'customer' => $sale->customer->name ?? 'Walk-in Customer',
                        'inflow' => $sale->paid_amount,
                        'outflow' => 0,
                        'payment_method' => $sale->payment_method
                    ];
                });
        }

        $repairAdvances = collect();
        $repairFinals = collect();
        if ($registerType === 'service' || $registerType === 'combined') {
            $repairAdvances = Repair::where('advance_payment_method', $paymentMethod)
                ->where('advance_payment', '>', 0)
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->get()
                ->map(function($repair) use ($paymentMethod) {
                    return [
                        'date' => $repair->created_at,
                        'type' => 'Repair Advance',
                        'ref' => $repair->ticket_id,
                        'customer' => $repair->customer->name ?? 'Walk-in Customer',
                        'inflow' => $repair->advance_payment,
                        'outflow' => 0,
                        'payment_method' => $paymentMethod
                    ];
                });

            $repairFinals = Repair::where('payment_method', $paymentMethod)
                ->where('actual_cost', '>', 0)
                ->whereIn('status', ['completed', 'delivered'])
                ->where(function($q) use ($startDate, $endDate) {
                    $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                      ->orWhere(function($q2) use ($startDate, $endDate) {
                          $q2->whereNull('completed_at')
                             ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                      });
                })
                ->get()
                ->map(function($repair) use ($paymentMethod) {
                    $finalPayment = floatval($repair->actual_cost) - floatval($repair->advance_payment);
                    return [
                        'date'           => $repair->completed_at ?? $repair->updated_at,
                        'type'           => 'Repair Final Payment',
                        'ref'            => $repair->ticket_id,
                        'customer'       => $repair->customer->name ?? 'Walk-in Customer',
                        'inflow'         => $finalPayment,
                        'outflow'        => 0,
                        'payment_method' => $paymentMethod
                    ];
                });
        }

        $expenses = collect();
        if ($paymentMethod === 'Cash') {
            $expensesQuery = Expense::whereBetween('expense_date', [$startDate, $endDate]);
            if ($registerType === 'pos') {
                $expensesQuery->where('register_type', 'pos');
            } elseif ($registerType === 'service') {
                $expensesQuery->where('register_type', 'service');
            }

            if (!$includeExpenses) {
                $expensesQuery->where(function($q) {
                    $q->where('amount', '<', 0)
                      ->orWhereIn('category', ['Cash Deposit', 'Opening Float']);
                });
            }
            
            $expenses = $expensesQuery->get()
                ->map(function($expense) {
                    $isInflow = $expense->amount < 0 || in_array($expense->category, ['Cash Deposit', 'Opening Float']);
                    $absAmount = abs($expense->amount);
                    return [
                        'date' => Carbon::parse($expense->expense_date)->startOfDay(),
                        'type' => $isInflow ? 'Cash Deposit (' . $expense->category . ')' : 'Expense (' . $expense->category . ')',
                        'ref' => 'EXP-' . $expense->id,
                        'customer' => ($expense->register_type ? '[' . strtoupper($expense->register_type) . ' Cash] ' : '') . ($expense->description ?? 'No Description'),
                        'inflow' => $isInflow ? $absAmount : 0,
                        'outflow' => $isInflow ? 0 : $absAmount,
                        'payment_method' => 'Cash'
                    ];
                });
        }

        // Merge all and sort by date descending
        $transactions = collect()
            ->concat($posSales)
            ->concat($repairAdvances)
            ->concat($repairFinals)
            ->concat($expenses)
            ->sortByDesc('date');

        // Sum current period inflows & outflows
        $totalInflow = $transactions->sum('inflow');
        $totalOutflow = $transactions->sum('outflow');
        $closingBalance = $openingBalance + $totalInflow - $totalOutflow;

        return view('cash.index', compact(
            'startDate',
            'endDate',
            'paymentMethod',
            'registerType',
            'includeExpenses',
            'openingBalance',
            'totalInflow',
            'totalOutflow',
            'closingBalance',
            'transactions'
        ));
    }

    public function storeOutflow(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'expense_date' => 'required|date',
            'register_type' => 'required|string|in:pos,service,general',
        ]);

        $registerType = $request->input('register_type');
        
        // Salesman constraint: Outflows must originate from POS cash register only
        if (auth()->user()->isSalesman()) {
            $registerType = 'pos';
        }

        Expense::create([
            'category' => $request->input('category'),
            'amount' => $request->input('amount'),
            'description' => $request->input('description'),
            'expense_date' => $request->input('expense_date'),
            'register_type' => $registerType === 'general' ? null : $registerType,
        ]);

        return redirect()->back()->with('success', 'Cash outflow recorded successfully.');
    }

    public function storeInflow(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin() && !$user->isAdmin()) {
            return redirect()->back()->with('error', 'Only Admins can record cash deposits.');
        }

        $request->validate([
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'expense_date' => 'required|date',
            'register_type' => 'required|string|in:pos,service,general',
        ]);

        $registerType = $request->input('register_type');

        Expense::create([
            'category' => $request->input('category'),
            'amount' => -abs($request->input('amount')), // Negative amount represents Cash Deposit / Inflow
            'description' => $request->input('description'),
            'expense_date' => $request->input('expense_date'),
            'register_type' => $registerType === 'general' ? null : $registerType,
        ]);

        return redirect()->back()->with('success', 'Cash deposit/inflow recorded successfully.');
    }
}
