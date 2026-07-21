<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Repair;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display report dashboard.
     */
    public function index(Request $request)
    {
        $timeframe = $request->input('timeframe', 'month'); // day, week, month, 3months, 6months, year

        // Set date filter
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();

        if ($timeframe === 'day') {
            $startDate = now()->toDateString();
            $endDate = now()->toDateString();
        } elseif ($timeframe === 'week') {
            $startDate = now()->startOfWeek()->toDateString();
            $endDate = now()->endOfWeek()->toDateString();
        } elseif ($timeframe === '3months') {
            $startDate = now()->subMonths(2)->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        } elseif ($timeframe === '6months') {
            $startDate = now()->subMonths(5)->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        } elseif ($timeframe === 'year') {
            $startDate = now()->startOfYear()->toDateString();
            $endDate = now()->endOfYear()->toDateString();
        }

        // 1. Service Income (Repairs actual_cost sum) — use completed_at if available, fallback to updated_at
        $completedRepairs = Repair::whereIn('status', ['completed', 'delivered'])
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->orWhere(function($q2) use ($startDate, $endDate) {
                      $q2->whereNull('completed_at')
                         ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                  });
            })
            ->get();

        $serviceIncome = $completedRepairs->sum('paid_amount');

        // Parts COGS — buying cost of spare parts used in completed repairs
        $partsCogs = $completedRepairs->sum(function($repair) {
            $parts = $repair->used_parts ?? [];
            $cost = 0;
            foreach ($parts as $part) {
                $cost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
            }
            return $cost;
        });

        // Technician commissions on completed repairs
        $commissionsTotal = $completedRepairs->sum('commission_amount');

        // 2. POS Sales Income (Sales paid_amount sum)
        $salesIncome = Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('paid_amount');
        $salesPaid = Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('paid_amount');
        $salesDue = Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('due_amount');

        $totalIncome = $serviceIncome + $salesIncome;

        // 3. Expenses Sum (excluding Purchase category and partner withdrawals)
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->where('category', '!=', 'Purchase')
            ->where(function($q) {
                $q->whereNull('register_type')
                  ->orWhere('register_type', '!=', 'withdraw');
            })
            ->sum('amount');

        // POS COGS — purchase price of accessories sold via POS
        $posSaleDetails = SaleDetail::whereHas('sale', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->get();
        $posCogs = $posSaleDetails->sum(function($detail) {
            return floatval($detail->purchase_price ?? 0) * intval($detail->quantity);
        });

        // Net Profit = Revenue - Parts COGS - POS COGS - Commissions - Expenses
        $netProfit = $totalIncome - $partsCogs - $posCogs - $commissionsTotal - $expenses;

        // 4. Repairs Stats in Timeframe
        $repairsCount = Repair::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $repairsCompleted = $completedRepairs->count();

        // 5. Product-wise Sales Breakdown
        $productSales = SaleDetail::select('inventory_item_id', DB::raw('SUM(quantity) as qty_sold'), DB::raw('SUM(quantity * sale_price) as revenue'))
            ->whereHas('sale', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->groupBy('inventory_item_id')
            ->with('item')
            ->orderBy('qty_sold', 'desc')
            ->get();

        // 6. Brand-wise Service Repairs
        $brandRepairs = Repair::select('device_brand', DB::raw('COUNT(*) as count'), DB::raw('SUM(actual_cost) as total_cost'))
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('device_brand')
            ->orderBy('count', 'desc')
            ->get();

        // 7. Top Technicians Performance & Commissions
        $topTechnicians = User::where('role', 'technician')
            ->withCount(['repairs as completed_jobs_count' => function($query) use ($startDate, $endDate) {
                $query->whereIn('status', ['completed', 'delivered'])
                      ->where(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->orWhere(function($q2) use ($startDate, $endDate) {
                                $q2->whereNull('completed_at')
                                   ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                            });
                      });
            }])
            ->withSum(['repairs as revenue_generated' => function($query) use ($startDate, $endDate) {
                $query->whereIn('status', ['completed', 'delivered'])
                      ->where(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->orWhere(function($q2) use ($startDate, $endDate) {
                                $q2->whereNull('completed_at')
                                   ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                            });
                      });
            }], 'actual_cost')
            ->withSum(['repairs as commission_earned' => function($query) use ($startDate, $endDate) {
                $query->whereIn('status', ['completed', 'delivered'])
                      ->where(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->orWhere(function($q2) use ($startDate, $endDate) {
                                $q2->whereNull('completed_at')
                                   ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                            });
                      });
            }], 'commission_amount')
            ->orderBy('completed_jobs_count', 'desc')
            ->get();

        // 8. Low Stock Alerts
        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'alert_quantity')->get();

        // 9. Payment Methods Cash Flow Breakdown
        $paymentLogsBreakdown = DB::table('payment_logs')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select('payment_method', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->get()
            ->pluck('total', 'payment_method')
            ->toArray();

        $paymentMethodsBreakdown = [
            'Cash' => floatval($paymentLogsBreakdown['Cash'] ?? 0),
            'bKash' => floatval($paymentLogsBreakdown['bKash'] ?? 0),
            'Nagad' => floatval($paymentLogsBreakdown['Nagad'] ?? 0),
            'Rocket' => floatval($paymentLogsBreakdown['Rocket'] ?? 0),
        ];

        return view('reports.index', compact(
            'timeframe',
            'startDate',
            'endDate',
            'serviceIncome',
            'salesIncome',
            'salesPaid',
            'salesDue',
            'totalIncome',
            'partsCogs',
            'posCogs',
            'commissionsTotal',
            'expenses',
            'netProfit',
            'repairsCount',
            'repairsCompleted',
            'productSales',
            'brandRepairs',
            'topTechnicians',
            'lowStockItems',
            'paymentMethodsBreakdown'
        ));
    }
}
