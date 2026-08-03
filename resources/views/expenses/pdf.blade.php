<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Statement - M3 Mobile Care</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 30px;
        }
        .report-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 1000px;
            margin: 0 auto;
        }
        .brand-title {
            color: #0f172a;
            font-weight: 800;
            font-size: 1.75rem;
            letter-spacing: -0.5px;
        }
        .brand-orange {
            color: #f37021;
        }
        .report-badge {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #ffedd5;
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            text-center;
        }
        .stat-box h6 {
            color: #64748b;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .stat-box h4 {
            color: #0f172a;
            font-weight: 700;
            margin: 0;
        }
        .table {
            border-color: #e2e8f0;
        }
        .table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 12px 16px;
        }
        .table tbody td {
            padding: 14px 16px;
            font-size: 0.9rem;
            color: #334155;
        }
        .total-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-radius: 12px;
            padding: 20px 24px;
        }
        .btn-print {
            background: #f37021;
            color: #ffffff;
            border: none;
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(243, 112, 33, 0.3);
            transition: all 0.2s ease;
        }
        .btn-print:hover {
            background: #e05300;
            color: #ffffff;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .report-card {
                box-shadow: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="report-card">
        <!-- Top Action Bar (Hide in Print) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">&larr; Back to Expenses</a>
            <div class="d-flex gap-2">
                <button class="btn btn-print btn-sm" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-1" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 7H4a1 1 0 0 1-1-1v-2h10v2a1 1 0 0 1-1 1z"/>
                    </svg> Download PDF / Print
                </button>
            </div>
        </div>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
            <div>
                <div class="brand-title">M3 <span class="brand-orange">MOBILE CARE</span></div>
                <div class="text-muted small fw-medium mt-1">Official Expense Ledger Statement</div>
            </div>
            <div class="text-end">
                <span class="report-badge d-inline-block mb-2">{{ $filterText }}</span>
                <div class="text-muted small">Generated: {{ date('M d, Y • h:i A') }}</div>
            </div>
        </div>

        <!-- Expense Table -->
        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Category</th>
                        <th>Description / Notes</th>
                        <th>Expense Date</th>
                        <th class="text-end">Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $index => $expense)
                    <tr>
                        <td class="fw-semibold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-semibold">{{ $expense->category }}</span>
                        </td>
                        <td>{{ $expense->description ?? 'N/A' }}</td>
                        <td class="fw-medium">{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                        <td class="text-end fw-bold text-danger">{{ number_format($expense->amount, 2) }} BDT</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No expenses found for the selected interval.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Total Outflow Banner -->
        <div class="total-banner d-flex justify-content-between align-items-center">
            <div>
                <span class="text-uppercase small tracking-wider text-slate-400 d-block" style="letter-spacing: 0.05em; font-weight: 600; color: #94a3b8;">Total Expense Outflow</span>
                <span class="small" style="color: #cbd5e1;">Count: {{ count($expenses) }} records</span>
            </div>
            <div class="text-end">
                <h2 class="fw-extrabold mb-0 text-white" style="font-size: 2rem;">{{ number_format($totalAmount, 2) }} BDT</h2>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-5 pt-3 border-top text-center text-muted small">
            This document is a computer-generated expense statement from <strong>M3 Mobile Care Management System</strong>.
        </div>
    </div>

</body>
</html>
