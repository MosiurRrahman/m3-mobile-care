<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Service;
use App\Models\User;
use App\Models\Expense;
use App\Models\Sale;
use App\Models\InventoryItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the role-specific dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isTechnician()) {
            return $this->technicianDashboard($user);
        } elseif ($user->isSalesman()) {
            return $this->salesmanDashboard($user);
        }

        abort(403, 'Unauthorized role.');
    }

    /**
     * Super Admin Dashboard.
     */
    private function adminDashboard()
    {
        // 1. Basic counts
        $totalRepairs = Repair::count();
        $pendingRepairs = Repair::where('status', 'pending')->count();
        $inProgressRepairs = Repair::whereIn('status', ['diagnosing', 'repairing', 'quality_check'])->count();
        $completedRepairs = Repair::whereIn('status', ['completed', 'delivered'])->count();

        // 2. Main Metrics (Total revenues & expenses in last 30 days)
        $serviceRevenue = Repair::whereIn('status', ['completed', 'delivered'])->sum('actual_cost');
        $posRevenue = Sale::sum('payable_amount');
        $totalRevenue = $serviceRevenue + $posRevenue;
        $totalSalesDues = Sale::sum('due_amount');
        
        $totalExpenses = Expense::sum('amount');

        // 3. Stock warning alerts
        $stockAlertsCount = InventoryItem::whereColumn('quantity', '<=', 'alert_quantity')->count();
        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'alert_quantity')
            ->orderBy('quantity', 'asc')
            ->limit(10)
            ->get();

        // 4. Status breakdown
        $statusCounts = Repair::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = ['pending', 'diagnosing', 'waiting_for_approval', 'repairing', 'quality_check', 'completed', 'delivered', 'cancelled'];
        foreach ($statuses as $status) {
            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
        }

        // 5. Recent repair jobs
        $recentRepairs = Repair::with(['customer', 'technician'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 6. Top Technicians Performance
        $topTechnicians = User::where('role', 'technician')
            ->withCount(['repairs as jobs_count' => function($q) {
                $q->whereIn('status', ['completed', 'delivered']);
            }])
            ->withSum(['repairs as revenue_generated' => function($q) {
                $q->whereIn('status', ['completed', 'delivered']);
            }], 'actual_cost')
            ->orderBy('jobs_count', 'desc')
            ->limit(3)
            ->get();

        $showFinancials = auth()->user()->isSuperAdmin();

        // 7. Chart.js Data
        $chartMonths = [];
        $chartRevenues = [];
        $chartExpenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $chartMonths[] = $date->format('M Y');

            $repRevenue = Repair::whereIn('status', ['completed', 'delivered'])
                ->where(function($q) use ($year, $month) {
                    $q->whereYear('completed_at', $year)->whereMonth('completed_at', $month)
                      ->orWhere(function($q2) use ($year, $month) {
                          $q2->whereNull('completed_at')
                             ->whereYear('updated_at', $year)
                             ->whereMonth('updated_at', $month);
                      });
                })
                ->sum('actual_cost');

            $slsRevenue = Sale::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('payable_amount');

            $chartRevenues[] = $repRevenue + $slsRevenue;

            $expSum = Expense::whereYear('expense_date', $year)
                ->whereMonth('expense_date', $month)
                ->sum('amount');

            $chartExpenses[] = $expSum;
        }

        $brandRepairs = Repair::select('device_brand', DB::raw('count(*) as count'))
            ->groupBy('device_brand')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $chartBrands = [];
        $chartBrandCounts = [];

        foreach ($brandRepairs as $br) {
            $chartBrands[] = $br->device_brand;
            $chartBrandCounts[] = $br->count;
        }

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalRepairs',
            'pendingRepairs',
            'inProgressRepairs',
            'completedRepairs',
            'totalRevenue',
            'totalSalesDues',
            'totalExpenses',
            'stockAlertsCount',
            'statusCounts',
            'recentRepairs',
            'topTechnicians',
            'showFinancials',
            'chartMonths',
            'chartRevenues',
            'chartExpenses',
            'chartBrands',
            'chartBrandCounts',
            'recentActivities',
            'lowStockItems'
        ));
    }

    /**
     * Technician Dashboard.
     */
    private function technicianDashboard($user)
    {
        // 1. My statistics
        $myTotalRepairs = Repair::where('assigned_technician_id', $user->id)->count();
        $myPendingRepairs = Repair::where('assigned_technician_id', $user->id)->where('status', 'pending')->count();
        $myActiveRepairs = Repair::where('assigned_technician_id', $user->id)
            ->whereIn('status', ['diagnosing', 'repairing', 'quality_check'])
            ->count();
        $myCompletedRepairs = Repair::where('assigned_technician_id', $user->id)->whereIn('status', ['completed', 'delivered'])->count();

        // 2. Recent assigned jobs
        $myRecentRepairs = Repair::where('assigned_technician_id', $user->id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.technician', compact(
            'myTotalRepairs',
            'myPendingRepairs',
            'myActiveRepairs',
            'myCompletedRepairs',
            'myRecentRepairs'
        ));
    }

    /**
     * Salesman Dashboard.
     */
    private function salesmanDashboard($user)
    {
        // 1. POS statistics
        $mySalesTodayCount = Sale::where('salesman_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();
            
        $mySalesTodayRevenue = Sale::where('salesman_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->sum('payable_amount');

        $activeAccessoriesCount = InventoryItem::where('type', 'accessory')->where('quantity', '>', 0)->count();
        $accessoriesAlertCount = InventoryItem::where('type', 'accessory')->whereColumn('quantity', '<=', 'alert_quantity')->count();

        // 2. Recent sales invoices
        $recentSales = Sale::where('salesman_id', $user->id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.salesman', compact(
            'mySalesTodayCount',
            'mySalesTodayRevenue',
            'activeAccessoriesCount',
            'accessoriesAlertCount',
            'recentSales'
        ));
    }
}
