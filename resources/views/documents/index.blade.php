@extends('layouts/contentNavbarLayout')

@section('title', 'দোকানের প্যাড ও ডকুমেন্ট জেনারেটর - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="ti tabler-file-text text-primary me-2"></i>দোকানের প্যাড ও ডকুমেন্ট জেনারেটর
            </h4>
            <span class="text-muted small">দোকানের অফিশিয়াল প্যাডে MoU, চুক্তিপত্র, ভাউচার, নোটিশ ও অন্যান্য ডকুমেন্ট তৈরি ও সংরক্ষণ করুন</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="createDocDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti tabler-plus me-1"></i>নতুন ডকুমেন্ট তৈরি করুন
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="createDocDropdown">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.documents.create', ['type' => 'mou']) }}">
                            <span class="badge bg-label-primary me-2">MoU</span> সমঝোতা স্মারক (MoU)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.documents.create', ['type' => 'agreement']) }}">
                            <span class="badge bg-label-info me-2">Deed</span> ব্যবসা / দোকান চুক্তিপত্র
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.documents.create', ['type' => 'voucher']) }}">
                            <span class="badge bg-label-success me-2">Voucher</span> টাকা প্রাপ্তি/প্রদান ভাউচার
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.documents.create', ['type' => 'notice']) }}">
                            <span class="badge bg-label-warning me-2">Notice</span> জরুরি বিজ্ঞপ্তি / নোটিশ
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.documents.create', ['type' => 'custom']) }}">
                            <span class="badge bg-label-secondary me-2">Custom</span> কাস্টম চিঠি / ফাইল
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti tabler-check me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Filters Card -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.documents.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-medium small">খুঁজুন (ডকুমেন্ট নং / শিরোনাম / নাম / মোবাইল)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti tabler-search"></i></span>
                            <input type="text" name="search" class="form-class form-control" placeholder="যেমন: DOC-2026 বা চুক্তিপত্র..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium small">ডকুমেন্টের ধরন</label>
                        <select name="type" class="form-select">
                            <option value="">সকল ধরন (All Types)</option>
                            <option value="mou" {{ request('type') == 'mou' ? 'selected' : '' }}>MoU (সমঝোতা স্মারক)</option>
                            <option value="agreement" {{ request('type') == 'agreement' ? 'selected' : '' }}>Agreement (চুক্তিপত্র)</option>
                            <option value="voucher" {{ request('type') == 'voucher' ? 'selected' : '' }}>Voucher (ভাউচার)</option>
                            <option value="notice" {{ request('type') == 'notice' ? 'selected' : '' }}>Notice (বিজ্ঞপ্তি)</option>
                            <option value="custom" {{ request('type') == 'custom' ? 'selected' : '' }}>Custom (কাস্টম চিঠি)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium small">হতে (From)</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium small">পর্যন্ত (To)</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100" title="ফিল্টার করুন">
                            <i class="ti tabler-filter me-1"></i>
                        </button>
                        @if(request()->anyFilled(['search', 'type', 'date_from', 'date_to']))
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary" title="রিসেট">
                                <i class="ti tabler-refresh"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents List Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold fs-6">সংরক্ষিত ডকুমেন্টের তালিকা (Total: {{ $documents->total() }})</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ডকুমেন্ট নং</th>
                            <th>শিরোনাম (Title)</th>
                            <th>ধরন (Type)</th>
                            <th>প্রাপক / দ্বিতীয় পক্ষ</th>
                            <th>তারিখ</th>
                            <th>অবস্থা</th>
                            <th>এন্ট্রি বাই</th>
                            <th class="text-end">একশন</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($documents as $doc)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.documents.show', $doc->id) }}" class="fw-bold text-primary">
                                        {{ $doc->document_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 250px;" title="{{ $doc->title }}">
                                        {{ $doc->title }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $doc->type_badge_class }}">
                                        {{ $doc->type_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($doc->recipient_name)
                                        <div class="fw-medium">{{ $doc->recipient_name }}</div>
                                        @if($doc->recipient_phone)
                                            <small class="text-muted"><i class="ti tabler-phone fs-9 me-1"></i>{{ $doc->recipient_phone }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted fs-8">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $doc->date ? $doc->date->format('d M, Y') : '-' }}</td>
                                <td>
                                    @if($doc->status == 'published')
                                        <span class="badge bg-success">প্রকাশিত</span>
                                    @else
                                        <span class="badge bg-secondary">ড্রাফট</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $doc->creator ? $doc->creator->name : 'System' }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.documents.show', $doc->id) }}" class="btn btn-sm btn-icon btn-label-info" title="প্রিভিউ দেখুন">
                                            <i class="ti tabler-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.documents.print', $doc->id) }}" target="_blank" class="btn btn-sm btn-icon btn-label-primary" title="প্যাডে প্রিন্ট করুন">
                                            <i class="ti tabler-printer"></i>
                                        </a>
                                        <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-icon btn-label-warning" title="এডিট করুন">
                                            <i class="ti tabler-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ডকুমেন্টটি মুছে ফেলতে চান?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="মুছে ফেলুন">
                                                <i class="ti tabler-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti tabler-file-off fs-1 d-block mb-2"></i>
                                        <p class="mb-0 fs-6">কোনো ডকুমেন্ট পাওয়া যায়নি!</p>
                                        <small>উপরে "নতুন ডকুমেন্ট তৈরি করুন" বাটনে ক্লিক করে প্রথম ডকুমেন্ট তৈরি করুন।</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($documents->hasPages())
                <div class="card-footer py-3">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
