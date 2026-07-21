<?php

namespace App\Http\Controllers;

use App\Models\PartnerBalance;
use App\Models\PartnerLedgerEntry;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartnerLedgerController extends Controller
{
    /**
     * Display partner ledger dashboard.
     */
    public function index(Request $request)
    {
        $this->checkAndInitializeBalances();
        $balances = PartnerBalance::all();
        
        $query = PartnerLedgerEntry::with('creator');
        
        if ($request->filled('partner')) {
            $query->where('partner_name', $request->input('partner'));
        }
        if ($request->filled('account_type')) {
            $query->where('account_type', $request->input('account_type'));
        }
        
        $entries = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();
        
        // Active month for closing widget
        $selectedMonth = $request->input('month', date('Y-m'));
        $monthProfit = $this->calculateMonthProfit($selectedMonth);
        
        // Check if profit for selected month is already distributed
        $isAlreadyDistributed = PartnerLedgerEntry::where('month', $selectedMonth)
            ->where('account_type', 'profit')
            ->exists();

        // Calculate current ratios based on dynamic capital model
        $monowar = $balances->where('partner_name', 'Monowar Munna')->first();
        $raihanRatio = 0.40; // Fixed
        
        $monowarRatio = 0.00;
        if ($monowar) {
            if ($monowar->capital_balance > 0) {
                $monowarRatio = ($monowar->capital_balance / 550000.0) * 0.50;
            } else {
                if ($monowar->payback_completed_at) {
                    $targetDate = Carbon::parse($selectedMonth . '-01');
                    $paybackDate = Carbon::parse($monowar->payback_completed_at->format('Y-m-d'));
                    $monthsDiff = $paybackDate->diffInMonths($targetDate, false);
                    if ($monthsDiff >= 0 && $monthsDiff < 36) {
                        $monowarRatio = 0.10;
                    }
                }
            }
        }
        
        $mosiurRatio = 0.60 - $monowarRatio;

        return view('partner_ledger.index', compact(
            'balances',
            'entries',
            'selectedMonth',
            'monthProfit',
            'isAlreadyDistributed',
            'monowarRatio',
            'raihanRatio',
            'mosiurRatio'
        ));
    }

    /**
     * Distribute profit for a selected month.
     */
    public function distributeProfit(Request $request)
    {
        $this->checkAndInitializeBalances();
        $request->validate([
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
        ]);

        $month = $request->input('month');

        $exists = PartnerLedgerEntry::where('month', $month)
            ->where('account_type', 'profit')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', "Profit for month {$month} has already been distributed!");
        }

        $netProfit = $this->calculateMonthProfit($month);

        $monowar = PartnerBalance::where('partner_name', 'Monowar Munna')->first();
        $raihan = PartnerBalance::where('partner_name', 'Munna Raihan')->first();
        $mosiur = PartnerBalance::where('partner_name', 'Mosiur')->first();

        if (!$monowar || !$raihan || !$mosiur) {
            return redirect()->back()->with('error', "Partner balances not initialized in database!");
        }

        // Calculate dynamic ratios
        $raihanRatio = 0.40;
        
        if ($monowar->capital_balance > 0) {
            $monowarRatio = ($monowar->capital_balance / 550000.0) * 0.50;
        } else {
            if ($monowar->payback_completed_at) {
                $targetDate = Carbon::parse($month . '-01');
                $paybackDate = Carbon::parse($monowar->payback_completed_at->format('Y-m-d'));
                $monthsDiff = $paybackDate->diffInMonths($targetDate, false);
                if ($monthsDiff >= 0 && $monthsDiff < 36) {
                    $monowarRatio = 0.10;
                } else {
                    $monowarRatio = 0.00;
                }
            } else {
                $monowarRatio = 0.00;
            }
        }
        
        $mosiurRatio = 0.60 - $monowarRatio;

        $monowarAmount = $netProfit * $monowarRatio;
        $raihanAmount = $netProfit * $raihanRatio;
        $mosiurAmount = $netProfit * $mosiurRatio;

        DB::transaction(function() use ($month, $netProfit, $monowar, $raihan, $mosiur, $monowarRatio, $raihanRatio, $mosiurRatio, $monowarAmount, $raihanAmount, $mosiurAmount) {
            // 1. Monowar Munna
            $monowar->accumulated_profit += $monowarAmount;
            $monowar->save();
            PartnerLedgerEntry::create([
                'partner_name' => 'Monowar Munna',
                'account_type' => 'profit',
                'type' => $monowarAmount >= 0 ? 'credit' : 'debit',
                'amount' => abs($monowarAmount),
                'balance_after' => $monowar->accumulated_profit,
                'month' => $month,
                'description' => "Profit distribution for month {$month} at ratio " . number_format($monowarRatio * 100, 2) . "%",
                'created_by' => auth()->id(),
            ]);

            // 2. Munna Raihan
            $raihan->accumulated_profit += $raihanAmount;
            $raihan->save();
            PartnerLedgerEntry::create([
                'partner_name' => 'Munna Raihan',
                'account_type' => 'profit',
                'type' => $raihanAmount >= 0 ? 'credit' : 'debit',
                'amount' => abs($raihanAmount),
                'balance_after' => $raihan->accumulated_profit,
                'month' => $month,
                'description' => "Profit distribution for month {$month} at ratio " . number_format($raihanRatio * 100, 2) . "%",
                'created_by' => auth()->id(),
            ]);

            // 3. Mosiur
            $mosiur->accumulated_profit += $mosiurAmount;
            $mosiur->save();
            PartnerLedgerEntry::create([
                'partner_name' => 'Mosiur',
                'account_type' => 'profit',
                'type' => $mosiurAmount >= 0 ? 'credit' : 'debit',
                'amount' => abs($mosiurAmount),
                'balance_after' => $mosiur->accumulated_profit,
                'month' => $month,
                'description' => "Profit distribution for month {$month} at ratio " . number_format($mosiurRatio * 100, 2) . "%",
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', "Profit for month {$month} distributed successfully!");
    }

    /**
     * Rollback profit distribution for a selected month.
     */
    public function rollbackDistribution(Request $request)
    {
        $request->validate([
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
        ]);

        $month = $request->input('month');

        $entries = PartnerLedgerEntry::where('month', $month)
            ->where('account_type', 'profit')
            ->get();

        if ($entries->isEmpty()) {
            return redirect()->back()->with('error', "No profit distribution found for month {$month} to rollback.");
        }

        DB::transaction(function() use ($entries, $month) {
            foreach ($entries as $entry) {
                $balance = PartnerBalance::where('partner_name', $entry->partner_name)->first();
                if ($balance) {
                    if ($entry->type === 'credit') {
                        $balance->accumulated_profit -= $entry->amount;
                    } else {
                        // It was a debit (loss distribution), so to reverse we add it back
                        $balance->accumulated_profit += $entry->amount;
                    }
                    $balance->save();
                }
                $entry->delete();
            }
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', "Profit distribution for month {$month} has been successfully rolled back and unlocked!");
    }

    /**
     * Store a partner investment / deposit entry.
     */
    public function storeDeposit(Request $request)
    {
        $this->checkAndInitializeBalances();
        $request->validate([
            'partner_name' => 'required|string|in:Monowar Munna,Munna Raihan,Mosiur',
            'account_type' => 'required|string|in:capital,profit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ]);

        $partnerName = $request->input('partner_name');
        $accountType = $request->input('account_type');
        $amount = floatval($request->input('amount'));
        $desc = $request->input('description') ?: 'Investment / Deposit';

        $balance = PartnerBalance::where('partner_name', $partnerName)->first();
        if (!$balance) {
            return redirect()->back()->with('error', 'Partner account not found.');
        }

        DB::transaction(function() use ($balance, $partnerName, $accountType, $amount, $desc) {
            if ($accountType === 'capital') {
                $balance->capital_balance += $amount;
                
                // Reset payback_completed_at if capital increases above 0
                if ($partnerName === 'Monowar Munna' && $balance->capital_balance > 0.00 && !is_null($balance->payback_completed_at)) {
                    $balance->payback_completed_at = null;
                }
                
                $balance->save();
                
                PartnerLedgerEntry::create([
                    'partner_name' => $partnerName,
                    'account_type' => 'capital',
                    'type' => 'credit',
                    'amount' => $amount,
                    'balance_after' => $balance->capital_balance,
                    'description' => $desc,
                    'created_by' => auth()->id(),
                ]);
            } else {
                $balance->accumulated_profit += $amount;
                $balance->save();
                
                PartnerLedgerEntry::create([
                    'partner_name' => $partnerName,
                    'account_type' => 'profit',
                    'type' => 'credit',
                    'amount' => $amount,
                    'balance_after' => $balance->accumulated_profit,
                    'description' => $desc,
                    'created_by' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', "Investment / Deposit of " . number_format($amount, 2) . " BDT processed successfully!");
    }

    /**
     * Store a partner cash withdrawal entry.
     */
    public function storeWithdrawal(Request $request)
    {
        $this->checkAndInitializeBalances();
        $request->validate([
            'partner_name' => 'required|string|in:Monowar Munna,Munna Raihan,Mosiur',
            'account_type' => 'required|string|in:capital,profit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ]);

        $partnerName = $request->input('partner_name');
        $accountType = $request->input('account_type');
        $amount = floatval($request->input('amount'));
        $desc = $request->input('description') ?: 'Cash withdrawal';

        $balance = PartnerBalance::where('partner_name', $partnerName)->first();
        if (!$balance) {
            return redirect()->back()->with('error', 'Partner account not found.');
        }

        if ($accountType === 'capital') {
            if ($balance->capital_balance < $amount) {
                return redirect()->back()->with('error', "Insufficient capital balance! Available: " . number_format($balance->capital_balance, 2) . " BDT");
            }
        }

        DB::transaction(function() use ($balance, $partnerName, $accountType, $amount, $desc) {
            if ($accountType === 'capital') {
                $balance->capital_balance -= $amount;
                
                // Track payback completed date if capital reaches 0
                if ($partnerName === 'Monowar Munna' && $balance->capital_balance <= 0.00 && is_null($balance->payback_completed_at)) {
                    $balance->payback_completed_at = now();
                }
                
                $balance->save();
                
                PartnerLedgerEntry::create([
                    'partner_name' => $partnerName,
                    'account_type' => 'capital',
                    'type' => 'debit',
                    'amount' => $amount,
                    'balance_after' => $balance->capital_balance,
                    'description' => $desc,
                    'created_by' => auth()->id(),
                ]);
            } else {
                $balance->accumulated_profit -= $amount;
                $balance->save();
                
                PartnerLedgerEntry::create([
                    'partner_name' => $partnerName,
                    'account_type' => 'profit',
                    'type' => 'debit',
                    'amount' => $amount,
                    'balance_after' => $balance->accumulated_profit,
                    'description' => $desc,
                    'created_by' => auth()->id(),
                ]);
            }

            // Log general outflow in the shop's cash register ledger
            Expense::create([
                'category' => 'Other',
                'amount' => $amount,
                'description' => "Partner " . ucfirst($accountType) . " Withdrawal: {$partnerName}. Note: {$desc}",
                'expense_date' => now()->toDateString(),
                'register_type' => 'withdraw',
            ]);
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', "Withdrawal of " . number_format($amount, 2) . " BDT processed successfully!");
    }

    /**
     * Update a partner ledger entry.
     */
    public function update(Request $request, $id)
    {
        $this->checkAndInitializeBalances();
        
        $entry = PartnerLedgerEntry::findOrFail($id);

        $request->validate([
            'partner_name' => 'required|string|in:Monowar Munna,Munna Raihan,Mosiur',
            'account_type' => 'required|string|in:capital,profit',
            'type' => 'required|string|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ]);

        $newPartner = $request->input('partner_name');
        $newAccount = $request->input('account_type');
        $newType = $request->input('type');
        $newAmount = floatval($request->input('amount'));
        $newDesc = $request->input('description');

        DB::transaction(function() use ($entry, $newPartner, $newAccount, $newType, $newAmount, $newDesc) {
            // 1. Reverse old entry from old partner balance
            $oldBalance = PartnerBalance::where('partner_name', $entry->partner_name)->first();
            if ($oldBalance) {
                if ($entry->account_type === 'capital') {
                    if ($entry->type === 'credit') {
                        $oldBalance->capital_balance -= $entry->amount;
                    } else {
                        $oldBalance->capital_balance += $entry->amount;
                    }
                } else {
                    if ($entry->type === 'credit') {
                        $oldBalance->accumulated_profit -= $entry->amount;
                    } else {
                        $oldBalance->accumulated_profit += $entry->amount;
                    }
                }
                
                if ($entry->partner_name === 'Monowar Munna') {
                    if ($oldBalance->capital_balance <= 0.00) {
                        if (is_null($oldBalance->payback_completed_at)) {
                            $oldBalance->payback_completed_at = now();
                        }
                    } else {
                        $oldBalance->payback_completed_at = null;
                    }
                }
                
                $oldBalance->save();
            }

            // 2. Apply new entry to new partner balance
            $newBalance = PartnerBalance::where('partner_name', $newPartner)->first();
            if (!$newBalance) {
                throw new \Exception("Partner account not found.");
            }

            if ($newAccount === 'capital') {
                if ($newType === 'credit') {
                    $newBalance->capital_balance += $newAmount;
                } else {
                    $newBalance->capital_balance -= $newAmount;
                }
            } else {
                if ($newType === 'credit') {
                    $newBalance->accumulated_profit += $newAmount;
                } else {
                    $newBalance->accumulated_profit -= $newAmount;
                }
            }

            if ($newPartner === 'Monowar Munna') {
                if ($newBalance->capital_balance <= 0.00) {
                    if (is_null($newBalance->payback_completed_at)) {
                        $newBalance->payback_completed_at = now();
                    }
                } else {
                    $newBalance->payback_completed_at = null;
                }
            }

            $newBalance->save();

            // 3. Update entry details
            $entry->update([
                'partner_name' => $newPartner,
                'account_type' => $newAccount,
                'type' => $newType,
                'amount' => $newAmount,
                'balance_after' => ($newAccount === 'capital') ? $newBalance->capital_balance : $newBalance->accumulated_profit,
                'description' => $newDesc,
            ]);
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', 'Partner ledger entry updated successfully!');
    }

    /**
     * Delete a partner ledger entry.
     */
    public function destroy($id)
    {
        $this->checkAndInitializeBalances();
        
        $entry = PartnerLedgerEntry::findOrFail($id);

        DB::transaction(function() use ($entry) {
            $balance = PartnerBalance::where('partner_name', $entry->partner_name)->first();
            if ($balance) {
                if ($entry->account_type === 'capital') {
                    if ($entry->type === 'credit') {
                        $balance->capital_balance -= $entry->amount;
                    } else {
                        $balance->capital_balance += $entry->amount;
                    }
                } else {
                    if ($entry->type === 'credit') {
                        $balance->accumulated_profit -= $entry->amount;
                    } else {
                        $balance->accumulated_profit += $entry->amount;
                    }
                }

                if ($entry->partner_name === 'Monowar Munna') {
                    if ($balance->capital_balance <= 0.00) {
                        if (is_null($balance->payback_completed_at)) {
                            $balance->payback_completed_at = now();
                        }
                    } else {
                        $balance->payback_completed_at = null;
                    }
                }

                $balance->save();
            }

            $entry->delete();
        });

        return redirect()->route('admin.partner-ledger.index')->with('success', 'Partner ledger entry deleted successfully!');
    }

    /**
     * Helper: calculate net profit for a selected year-month timeframe.
     */
    private function calculateMonthProfit($yearMonth)
    {
        $parts = explode('-', $yearMonth);
        if (count($parts) !== 2) {
            return 0.00;
        }

        $year = $parts[0];
        $month = $parts[1];

        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        // 1. Service Income
        $completedRepairs = \App\Models\Repair::whereIn('status', ['completed', 'delivered'])
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('completed_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                  ->orWhere(function($q2) use ($startDate, $endDate) {
                      $q2->whereNull('completed_at')
                         ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                  });
            })
            ->get();

        $serviceIncome = $completedRepairs->sum('paid_amount');

        // Parts COGS
        $partsCogs = $completedRepairs->sum(function($repair) {
            $parts = $repair->used_parts ?? [];
            $cost = 0;
            foreach ($parts as $part) {
                $cost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
            }
            return $cost;
        });

        // Technician commissions
        $commissionsTotal = $completedRepairs->sum('commission_amount');

        // 2. POS Sales Income
        $salesIncome = \App\Models\Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('paid_amount');

        $totalIncome = $serviceIncome + $salesIncome;

        // 3. Expenses Sum (excluding Purchase category and partner withdrawals)
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->where('category', '!=', 'Purchase')
            ->where(function($q) {
                $q->whereNull('register_type')
                  ->orWhere('register_type', '!=', 'withdraw');
            })
            ->sum('amount');

        // POS COGS
        $posSaleDetails = \App\Models\SaleDetail::whereHas('sale', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->get();
        $posCogs = $posSaleDetails->sum(function($detail) {
            return floatval($detail->purchase_price ?? 0) * intval($detail->quantity);
        });

        $netProfit = $totalIncome - $partsCogs - $posCogs - $commissionsTotal - $expenses;

        return floatval($netProfit);
    }

    /**
     * Helper: self-healing initialization of partner balances.
     */
    private function checkAndInitializeBalances()
    {
        if (PartnerBalance::count() === 0) {
            PartnerBalance::insert([
                [
                    'partner_name' => 'Monowar Munna',
                    'capital_balance' => 0.00,
                    'accumulated_profit' => 0.00,
                    'payback_completed_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'partner_name' => 'Munna Raihan',
                    'capital_balance' => 0.00,
                    'accumulated_profit' => 0.00,
                    'payback_completed_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'partner_name' => 'Mosiur',
                    'capital_balance' => 0.00,
                    'accumulated_profit' => 0.00,
                    'payback_completed_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
