@extends('layouts/contentNavbarLayout')

@section('title', 'Job Cards - M3 Mobile Care')

@section('page-style')
<style>
    .repair-table {
        font-size: 0.8125rem;
    }
    .repair-table thead th {
        font-size: 0.72rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
        white-space: nowrap !important;
    }
    .repair-table tbody td {
        padding-top: 0.6rem !important;
        padding-bottom: 0.6rem !important;
        vertical-align: middle;
    }
    .repair-ticket-link {
        font-size: 0.8125rem !important;
        white-space: nowrap !important;
        display: inline-block;
        letter-spacing: -0.2px;
        font-family: inherit;
    }
    #repairsTableContainer {
        position: relative;
        transition: opacity 0.2s ease;
    }
</style>
@endsection

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h4 class="fw-bold mb-0">Repair Job Cards</h4>
        @if(auth()->user()->canCreateJobCard())
        <a href="{{ route('admin.repairs.create') }}" class="btn btn-primary"><i class="ti tabler-plus me-1"></i>Create Job Card</a>
        @endif
    </div>



    <!-- Filter & Search Section -->
    <div class="card-body bg-light border-top border-bottom py-3">
        <form id="repairFilterForm" action="{{ route('admin.repairs.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <div class="position-relative">
                    <input type="text" name="search" id="repairSearchInput" class="form-control pe-5" placeholder="Search by Ticket ID, Phone, IMEI..." value="{{ request('search') }}" autocomplete="off">
                    <div id="searchSpinner" class="spinner-border spinner-border-sm text-primary position-absolute end-0 top-50 translate-middle-y me-3 d-none" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" id="repairStatusSelect" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diagnosing" {{ request('status') == 'diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                    <option value="waiting_for_approval" {{ request('status') == 'waiting_for_approval' ? 'selected' : '' }}>Waiting Approval</option>
                    <option value="waiting_for_parts" {{ request('status') == 'waiting_for_parts' ? 'selected' : '' }}> Waiting for Parts</option>
                    <option value="repairing" {{ request('status') == 'repairing' ? 'selected' : '' }}>Repairing</option>
                    <option value="quality_check" {{ request('status') == 'quality_check' ? 'selected' : '' }}>Quality Check</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed (Ready)</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted px-2"><i class="ti tabler-calendar fs-6"></i></span>
                    <input type="{{ request('month') ? 'month' : 'text' }}" name="month" id="repairMonthInput" class="form-control" value="{{ request('month') }}" placeholder="Filter Month" title="Pick Any Specific Month" onfocus="(this.type='month')" onblur="if(!this.value)this.type='text'">
                </div>
            </div>
            <div class="col-md-2">
                <select name="per_page" id="repairPerPageSelect" class="form-select">
                    <option value="10" {{ request('per_page', '10') == '10' ? 'selected' : '' }}>10 / Page</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 / Page</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 / Page</option>
                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 / Page</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 px-2" id="filterBtn"><i class="ti tabler-search me-1"></i>Filter</button>
                <button type="button" class="btn btn-outline-secondary w-100 px-2" id="resetFilterBtn">Reset</button>
            </div>
        </form>
    </div>

    <!-- Live Table Container -->
    <div id="repairsTableContainer">
        @include('repairs._table')
    </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('repairFilterForm');
    const searchInput = document.getElementById('repairSearchInput');
    const statusSelect = document.getElementById('repairStatusSelect');
    const monthInput = document.getElementById('repairMonthInput');
    const perPageSelect = document.getElementById('repairPerPageSelect');
    const resetBtn = document.getElementById('resetFilterBtn');
    const tableContainer = document.getElementById('repairsTableContainer');
    const searchSpinner = document.getElementById('searchSpinner');

    let debounceTimer = null;
    let currentAbortCtrl = null;

    function buildUrl(overrideUrl = null) {
        if (overrideUrl) return overrideUrl;

        const formData = new FormData(filterForm);
        const params = new URLSearchParams();

        for (const [key, val] of formData.entries()) {
            if (val !== null && val.trim() !== '') {
                params.set(key, val.trim());
            }
        }

        const baseUrl = filterForm.getAttribute('action') || window.location.pathname;
        const queryString = params.toString();
        return queryString ? `${baseUrl}?${queryString}` : baseUrl;
    }

    function fetchRepairs(targetUrl = null) {
        if (currentAbortCtrl) {
            currentAbortCtrl.abort();
        }
        currentAbortCtrl = new AbortController();

        const url = buildUrl(targetUrl);

        if (searchSpinner) searchSpinner.classList.remove('d-none');
        if (tableContainer) {
            tableContainer.style.opacity = '0.55';
            tableContainer.style.pointerEvents = 'none';
        }

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            },
            signal: currentAbortCtrl.signal
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response error: ' + response.status);
            return response.text();
        })
        .then(html => {
            if (tableContainer) {
                tableContainer.innerHTML = html;
            }
            window.history.replaceState(null, '', url);
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                console.error('Real-time filter error:', err);
            }
        })
        .finally(() => {
            if (searchSpinner) searchSpinner.classList.add('d-none');
            if (tableContainer) {
                tableContainer.style.opacity = '1';
                tableContainer.style.pointerEvents = 'auto';
            }
        });
    }

    // 1. Real-time Search: live typing with 250ms debounce
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchRepairs();
            }, 250);
        });
    }

    // 2. Real-time Status dropdown change
    if (statusSelect) {
        statusSelect.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            fetchRepairs();
        });
    }

    // 3. Real-time Month change
    if (monthInput) {
        monthInput.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            fetchRepairs();
        });
        monthInput.addEventListener('input', function () {
            if (!this.value) {
                clearTimeout(debounceTimer);
                fetchRepairs();
            }
        });
    }

    // 4. Real-time Per Page change
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function () {
            clearTimeout(debounceTimer);
            fetchRepairs();
        });
    }

    // 5. Prevent full page reload on submit / Enter key press
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            clearTimeout(debounceTimer);
            fetchRepairs();
        });
    }

    // 6. Reset button: clears all fields and live refreshes
    if (resetBtn) {
        resetBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            if (statusSelect) statusSelect.value = '';
            if (monthInput) {
                monthInput.value = '';
                if (monthInput.type === 'month') monthInput.type = 'text';
            }
            if (perPageSelect) perPageSelect.value = '10';
            clearTimeout(debounceTimer);
            fetchRepairs();
        });
    }

    // 7. Real-time AJAX pagination clicks
    if (tableContainer) {
        tableContainer.addEventListener('click', function (e) {
            const pageLink = e.target.closest('#repairsPagination a.page-link');
            if (pageLink && pageLink.href) {
                e.preventDefault();
                fetchRepairs(pageLink.href);
            }
        });
    }

    // 8. Handle browser back / forward buttons
    window.addEventListener('popstate', function () {
        const params = new URLSearchParams(window.location.search);
        if (searchInput) searchInput.value = params.get('search') || '';
        if (statusSelect) statusSelect.value = params.get('status') || '';
        if (monthInput) monthInput.value = params.get('month') || '';
        if (perPageSelect) perPageSelect.value = params.get('per_page') || '10';
        fetchRepairs(window.location.href);
    });
});
</script>
@endsection
