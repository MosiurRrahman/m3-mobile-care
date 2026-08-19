@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Inquiries & Messages - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Customer Inquiries & Messages</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer Inquiries</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if($unreadCount > 0)
            <form action="{{ route('admin.contact-messages.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="ti tabler-checks me-1"></i>Mark All as Read
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Session Alerts -->
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success border-0 py-2 d-flex align-items-center shadow-xs">
                <i class="ti tabler-circle-check fs-4 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 py-2 d-flex align-items-center shadow-xs">
                <i class="ti tabler-alert-circle fs-4 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- KPI Summary Cards -->
    <div class="col-12 mb-4">
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('admin.contact-messages.index') }}" class="card border-0 shadow-sm text-decoration-none h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block mb-1">Total Inquiries</span>
                            <h4 class="fw-bold text-dark mb-0">{{ $totalCount }}</h4>
                        </div>
                        <div class="p-3 bg-label-primary rounded-3 text-primary">
                            <i class="ti tabler-messages fs-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" class="card border-0 shadow-sm text-decoration-none h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-danger small fw-bold d-block mb-1">Unread / New</span>
                            <h4 class="fw-bold text-danger mb-0">{{ $unreadCount }}</h4>
                        </div>
                        <div class="p-3 bg-label-danger rounded-3 text-danger">
                            <i class="ti tabler-mail-filled fs-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('admin.contact-messages.index', ['status' => 'replied']) }}" class="card border-0 shadow-sm text-decoration-none h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-success small fw-bold d-block mb-1">Replied</span>
                            <h4 class="fw-bold text-success mb-0">{{ $repliedCount }}</h4>
                        </div>
                        <div class="p-3 bg-label-success rounded-3 text-success">
                            <i class="ti tabler-send fs-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" class="card border-0 shadow-sm text-decoration-none h-100">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-info small fw-bold d-block mb-1">Read / Archived</span>
                            <h4 class="fw-bold text-info mb-0">{{ $readCount }}</h4>
                        </div>
                        <div class="p-3 bg-label-info rounded-3 text-info">
                            <i class="ti tabler-mail-opened fs-2"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter & Search Box -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body bg-light py-3 rounded-3">
                <form action="{{ route('admin.contact-messages.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search by customer name, phone, message..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread Only</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read Only</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied Only</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti tabler-search me-1"></i>Search</button>
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Messages List Table -->
    <div class="col-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Message / Inquiry</th>
                                <th class="text-center" style="width: 110px;">Status</th>
                                <th style="width: 140px;">Received At</th>
                                <th class="text-center" style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $index => $msg)
                            <tr class="{{ $msg->status === 'unread' ? 'table-warning bg-opacity-25 fw-semibold' : '' }}">
                                <td class="text-muted small">{{ $messages->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $msg->name }}</div>
                                    @if($msg->email)
                                        <small class="text-muted">{{ $msg->email }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark font-monospace">{{ $msg->phone }}</div>
                                    <div class="d-flex gap-2 mt-1">
                                        <a href="tel:{{ $msg->phone }}" class="badge bg-label-primary text-decoration-none" title="Call Customer">
                                            <i class="ti tabler-phone fs-7"></i> Call
                                        </a>
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $msg->phone);
                                            if (str_starts_with($cleanPhone, '01')) {
                                                $cleanPhone = '88' . $cleanPhone;
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="badge bg-label-success text-decoration-none" title="Chat on WhatsApp">
                                            <i class="ti tabler-brand-whatsapp fs-7"></i> WhatsApp
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-dark mb-0 text-truncate" style="max-width: 320px;" title="{{ $msg->message }}">
                                        {{ $msg->message }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    @if($msg->status === 'unread')
                                        <span class="badge bg-danger"><i class="ti tabler-mail-filled me-1"></i>Unread</span>
                                    @elseif($msg->status === 'replied')
                                        <span class="badge bg-success"><i class="ti tabler-check me-1"></i>Replied</span>
                                    @else
                                        <span class="badge bg-secondary">Read</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    <div>{{ $msg->created_at->format('d M Y') }}</div>
                                    <small>{{ $msg->created_at->format('h:i A') }} ({{ $msg->created_at->diffForHumans() }})</small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <!-- View Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewMsgModal{{ $msg->id }}" title="View Message">
                                            <i class="ti tabler-eye"></i>
                                        </button>

                                        <!-- Reply SMS Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replySmsModal{{ $msg->id }}" title="Send Reply SMS">
                                            <i class="ti tabler-send"></i>
                                        </button>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.contact-messages.destroy', $msg->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Delete">
                                                <i class="ti tabler-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Message Modal -->
                            <div class="modal fade" id="viewMsgModal{{ $msg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title fw-bold text-dark">
                                                <i class="ti tabler-mail-opened text-primary me-2"></i>Inquiry from {{ $msg->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-3">
                                            <div class="p-3 bg-light rounded-3 mb-3 small">
                                                <div class="row g-2">
                                                    <div class="col-6"><strong>Customer Name:</strong> {{ $msg->name }}</div>
                                                    <div class="col-6"><strong>Phone:</strong> {{ $msg->phone }}</div>
                                                    <div class="col-6"><strong>Received:</strong> {{ $msg->created_at->format('d M Y, h:i A') }}</div>
                                                    <div class="col-6">
                                                        <strong>Status:</strong> 
                                                        <span class="badge {{ $msg->status === 'unread' ? 'bg-danger' : ($msg->status === 'replied' ? 'bg-success' : 'bg-secondary') }}">{{ ucfirst($msg->status) }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <label class="fw-bold small text-muted mb-1">Message Content:</label>
                                            <div class="p-3 border rounded-3 bg-white text-dark mb-3 lh-base">
                                                {!! nl2br(e($msg->message)) !!}
                                            </div>

                                            @if($msg->notes)
                                                <label class="fw-bold small text-muted mb-1">Reply History / Logs:</label>
                                                <div class="p-2 border rounded-3 bg-light small text-muted mb-3 font-monospace">
                                                    {!! nl2br(e($msg->notes)) !!}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-top bg-light">
                                            @if($msg->status === 'unread')
                                            <form action="{{ route('admin.contact-messages.read', $msg->id) }}" method="POST" class="me-auto">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                    <i class="ti tabler-check me-1"></i>Mark as Read
                                                </button>
                                            </form>
                                            @endif
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#replySmsModal{{ $msg->id }}">
                                                <i class="ti tabler-send me-1"></i>Send SMS Reply
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reply SMS Modal -->
                            <div class="modal fade" id="replySmsModal{{ $msg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <form action="{{ route('admin.contact-messages.send-sms', $msg->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header border-bottom">
                                                <h5 class="modal-title fw-bold text-dark">
                                                    <i class="ti tabler-send text-primary me-2"></i>Send Reply SMS to {{ $msg->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Customer Phone</label>
                                                    <input type="text" class="form-control" value="{{ $msg->phone }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Customer Message</label>
                                                    <div class="p-2.5 bg-light rounded border text-muted small">{{ $msg->message }}</div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold" for="sms_message_{{ $msg->id }}">SMS Reply Message <span class="text-danger">*</span></label>
                                                    <textarea name="sms_message" id="sms_message_{{ $msg->id }}" class="form-control" rows="4" placeholder="Write reply message..." required>প্রিয় {{ $msg->name }}, M3 Mobile Care-এ যোগাযোগের জন্য ধন্যবাদ। আপনার বার্তার প্রেক্ষিতে জানাচ্ছি যে... </textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top bg-light">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm px-3">
                                                    <i class="ti tabler-send me-1"></i>Send SMS Now
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="ti tabler-messages-off fs-1 d-block mb-2 text-secondary"></i>
                                    <h6 class="fw-bold mb-1 text-dark">কোনো মেসেজ বা ইনকোয়ারি পাওয়া যায়নি</h6>
                                    <p class="small mb-0">কাস্টমাররা পাবলিক Contact Us পেজ থেকে কোনো বার্তা পাঠালে এখানে জমা হবে।</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($messages->hasPages())
                <div class="card-footer py-2 border-top">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
