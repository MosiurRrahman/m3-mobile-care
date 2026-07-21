@extends('layouts/contentNavbarLayout')

@section('title', 'Expense Manager - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Expense Management</h4>
            <span class="text-muted small">Log shop rent, utility bills, employee salaries, and stock purchase costs</span>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="ti tabler-plus me-1"></i>Log New Expense
        </button>
    </div>

    <!-- Alert Notifications -->

    <!-- Category Summary Cards -->
    <div class="col-12 mb-4">
        <div class="row row-cols-1 row-cols-md-5 g-3">
            @foreach($categories as $cat)
            @php
                $colorMap = [
                    'Rent' => 'primary',
                    'Salary' => 'info',
                    'Utility' => 'warning',
                    'Purchase' => 'danger',
                    'Other' => 'secondary'
                ];
                $color = $colorMap[$cat] ?? 'secondary';
            @endphp
            <div class="col">
                <div class="card border-0 shadow-sm bg-label-{{ $color }} h-100">
                    <div class="card-body text-center p-3">
                        <span class="fw-semibold text-muted d-block small mb-1">{{ $cat }}</span>
                        <h4 class="fw-extrabold text-{{ $color }} mb-0">{{ number_format($sums[$cat] ?? 0, 0) }} BDT</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Main List Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pb-2">
                <h5 class="fw-bold mb-0">Expense Ledger Entries</h5>
                <span class="fw-bold text-danger">Total Outflow: {{ number_format($totalExpenses, 2) }} BDT</span>
            </div>

            <!-- Filter & Search Section -->
            <div class="card-body bg-light border-top border-bottom py-3">
                <form action="{{ route('admin.expenses.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search description..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="month" name="month" class="form-control form-control-sm" value="{{ request('month') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="per_page" class="form-select form-select-sm">
                            <option value="10" {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10 / Page</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 / Page</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 / Page</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 / Page</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti tabler-search me-0.5"></i>Filter</button>
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Expense Date</th>
                            <th class="text-end" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                        @php
                            $colors = [
                                'Rent' => 'bg-label-primary',
                                'Salary' => 'bg-label-info',
                                'Utility' => 'bg-label-warning',
                                'Purchase' => 'bg-label-danger',
                                'Other' => 'bg-label-secondary'
                            ];
                            $color = $colors[$expense->category] ?? 'bg-label-secondary';
                        @endphp
                        <tr>
                            <td><span class="badge {{ $color }} fs-6">{{ $expense->category }}</span></td>
                            <td><span class="text-dark">{{ $expense->description ?? 'N/A' }}</span></td>
                            <td><span class="fw-bold text-danger">{{ number_format($expense->amount, 2) }} BDT</span></td>
                            <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <button class="btn btn-icon btn-sm btn-outline-primary me-1 edit-expense-btn" 
                                            data-id="{{ $expense->id }}"
                                            data-category="{{ $expense->category }}"
                                            data-amount="{{ $expense->amount }}"
                                            data-description="{{ $expense->description }}"
                                            data-expense_date="{{ $expense->expense_date }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editExpenseModal" 
                                            title="Edit Ledger Entry">
                                        <i class="ti tabler-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No expenses recorded for this interval.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($expenses->hasPages())
            <div class="card-footer bg-transparent border-0 d-flex justify-content-end py-3">
                {{ $expenses->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Log Expense -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addExpenseModalLabel">Log New Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.expenses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_category">Expense Category <span class="text-danger">*</span></label>
                        <select name="category" id="add_category" class="form-select" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                            @if(auth()->user()->isSuperAdmin())
                            <option value="__custom__">+ Add Custom Category...</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="add_custom_category_wrapper">
                        <label class="form-label fw-semibold" for="add_custom_category">Custom Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="custom_category" id="add_custom_category" class="form-control" placeholder="e.g. Marketing / Travel">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="add_amount">Amount (BDT) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="add_amount" step="0.01" min="0" class="form-control" required placeholder="e.g. 5000">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="add_expense_date">Expense Date <span class="text-danger">*</span></label>
                            <input type="date" name="expense_date" id="add_expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="add_description">Description / Notes</label>
                        <textarea name="description" id="add_description" rows="3" class="form-control" placeholder="e.g. Shop rent for July 2026 / Utility bill Shop 14"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Expense -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editExpenseModalLabel">Edit Expense Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editExpenseForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_category">Expense Category <span class="text-danger">*</span></label>
                        <select name="category" id="edit_category" class="form-select" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                            @if(auth()->user()->isSuperAdmin())
                            <option value="__custom__">+ Add Custom Category...</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="edit_custom_category_wrapper">
                        <label class="form-label fw-semibold" for="edit_custom_category">Custom Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="custom_category" id="edit_custom_category" class="form-control" placeholder="e.g. Marketing / Travel">
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="edit_amount">Amount (BDT) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" id="edit_amount" step="0.01" min="0" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" for="edit_expense_date">Expense Date <span class="text-danger">*</span></label>
                            <input type="date" name="expense_date" id="edit_expense_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="edit_description">Description / Notes</label>
                        <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-expense-btn');
        const editForm = document.getElementById('editExpenseForm');
        const editCategory = document.getElementById('edit_category');
        const editAmount = document.getElementById('edit_amount');
        const editDescription = document.getElementById('edit_description');
        const editDate = document.getElementById('edit_expense_date');

        // Toggle Custom Category Name for Add Modal
        const addCategory = document.getElementById('add_category');
        const addCustomWrapper = document.getElementById('add_custom_category_wrapper');
        const addCustomInput = document.getElementById('add_custom_category');

        if (addCategory) {
            addCategory.addEventListener('change', function() {
                if (this.value === '__custom__') {
                    addCustomWrapper.classList.remove('d-none');
                    addCustomInput.setAttribute('required', 'required');
                } else {
                    addCustomWrapper.classList.add('d-none');
                    addCustomInput.removeAttribute('required');
                }
            });
        }

        // Toggle Custom Category Name for Edit Modal
        const editCustomWrapper = document.getElementById('edit_custom_category_wrapper');
        const editCustomInput = document.getElementById('edit_custom_category');

        if (editCategory) {
            editCategory.addEventListener('change', function() {
                if (this.value === '__custom__') {
                    editCustomWrapper.classList.remove('d-none');
                    editCustomInput.setAttribute('required', 'required');
                } else {
                    editCustomWrapper.classList.add('d-none');
                    editCustomInput.removeAttribute('required');
                }
            });
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const category = this.getAttribute('data-category');
                const amount = this.getAttribute('data-amount');
                const description = this.getAttribute('data-description');
                const date = this.getAttribute('data-expense_date');

                editForm.action = `/admin/expenses/${id}`;
                
                editCategory.value = category;
                editAmount.value = amount;
                editDescription.value = description === 'null' ? '' : description;
                editDate.value = date;

                // Reset custom category fields on opening
                editCustomWrapper.classList.add('d-none');
                editCustomInput.removeAttribute('required');
                editCustomInput.value = '';
            });
        });
    });
</script>
@endsection
