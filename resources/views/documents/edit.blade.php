@extends('layouts/contentNavbarLayout')

@section('title', 'ডকুমেন্ট এডিট করুন - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <a href="{{ route('admin.documents.show', $document->id) }}" class="text-muted me-1"><i class="ti tabler-arrow-left"></i></a>
                ডকুমেন্ট এডিট: {{ $document->document_number }}
            </h4>
            <span class="text-muted small">সংরক্ষিত ডকুমেন্টের তথ্য বা বিষয়বস্তু পরিবর্তন করুন</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.documents.show', $document->id) }}" class="btn btn-outline-info">
                <i class="ti tabler-eye me-1"></i>প্রিভিউ
            </a>
            <a href="{{ route('admin.documents.print', $document->id) }}" target="_blank" class="btn btn-outline-primary">
                <i class="ti tabler-printer me-1"></i>প্যাডে প্রিন্ট
            </a>
        </div>
    </div>

    <!-- Main Form -->
    <div class="col-12">
        <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" id="documentForm">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- Left Column: Document Fields -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-label-primary border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="ti tabler-edit me-2"></i>ডকুমেন্টের বিষয়বস্তু এডিট
                            </h5>
                        </div>
                        <div class="card-body pt-4">
                            <!-- Type Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small">ডকুমেন্টের ধরন (Document Type)</label>
                                <select name="type" id="documentType" class="form-select">
                                    <option value="mou" {{ old('type', $document->type) == 'mou' ? 'selected' : '' }}>MoU (সমঝোতা স্মারক)</option>
                                    <option value="agreement" {{ old('type', $document->type) == 'agreement' ? 'selected' : '' }}>Agreement (চুক্তিপত্র)</option>
                                    <option value="voucher" {{ old('type', $document->type) == 'voucher' ? 'selected' : '' }}>Voucher (ভাউচার)</option>
                                    <option value="notice" {{ old('type', $document->type) == 'notice' ? 'selected' : '' }}>Notice (বিজ্ঞপ্তি)</option>
                                    <option value="custom" {{ old('type', $document->type) == 'custom' ? 'selected' : '' }}>Custom (কাস্টম চিঠি)</option>
                                </select>
                            </div>

                            <!-- Document Title -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small required">ডকুমেন্টের শিরোনাম (Document Title)</label>
                                <input type="text" name="title" id="documentTitle" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $document->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Rich Text Toolbar & Content Editor -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small required">ডকুমেন্টের বিস্তারিত বিবরণ (Content)</label>
                                
                                <!-- Text Formatting Toolbar -->
                                <div class="btn-toolbar bg-light p-2 border rounded-top d-flex gap-1 flex-wrap" role="toolbar">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('bold')" title="Bold"><i class="ti tabler-bold"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('italic')" title="Italic"><i class="ti tabler-italic"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('underline')" title="Underline"><i class="ti tabler-underline"></i></button>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('formatBlock', '<h3>')" title="Heading 3">H3</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('formatBlock', '<h4>')" title="Heading 4">H4</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('formatBlock', '<p>')" title="Paragraph">P</button>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyLeft')" title="Left Align"><i class="ti tabler-align-left"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyCenter')" title="Center Align"><i class="ti tabler-align-center"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('justifyRight')" title="Right Align"><i class="ti tabler-align-right"></i></button>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('insertUnorderedList')" title="Bullet List"><i class="ti tabler-list-bullets"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('insertOrderedList')" title="Numbered List"><i class="ti tabler-list-numbers"></i></button>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="insertTable()" title="Insert Table"><i class="ti tabler-table"></i> Table</button>
                                    </div>
                                </div>

                                <!-- Content Editable Area -->
                                <div id="editorArea" class="form-control rounded-bottom p-3 bg-white" contenteditable="true" style="min-height: 350px; max-height: 600px; overflow-y: auto; border-top: none !important;">
                                    {!! old('content', $document->content) !!}
                                </div>

                                <textarea name="content" id="hiddenContent" class="d-none" required>{!! old('content', $document->content) !!}</textarea>
                                @error('content')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Meta & Recipient Details -->
                <div class="col-lg-4">
                    <!-- Recipient Info Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="ti tabler-user me-2"></i>প্রাপক / দ্বিতীয় পক্ষের তথ্য
                            </h5>
                        </div>
                        <div class="card-body pt-3">
                            <div class="mb-3">
                                <label class="form-label small fw-medium">প্রাপক / দ্বিতীয় পক্ষের নাম</label>
                                <input type="text" name="recipient_name" class="form-control" value="{{ old('recipient_name', $document->recipient_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">মোবাইল নাম্বার</label>
                                <input type="text" name="recipient_phone" class="form-control" value="{{ old('recipient_phone', $document->recipient_phone) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">ঠিকানা (Address)</label>
                                <textarea name="recipient_address" class="form-control" rows="2">{{ old('recipient_address', $document->recipient_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Details Card -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="ti tabler-adjustments me-2"></i>ডকুমেন্ট সেটিংস
                            </h5>
                        </div>
                        <div class="card-body pt-3">
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">তারিখ (Date)</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', $document->date ? $document->date->format('Y-m-d') : date('Y-m-d')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">লেখা / ডকুমেন্টের ফন্ট (Font Family)</label>
                                <select name="font_family" id="fontFamilySelect" class="form-select">
                                    <option value="Hind Siliguri" {{ old('font_family', $document->font_family ?? 'Hind Siliguri') == 'Hind Siliguri' ? 'selected' : '' }}>Hind Siliguri (হিন্দ শিলিগুড়ি - ক্লিন মডার্ন)</option>
                                    <option value="SolaimanLipi" {{ old('font_family', $document->font_family) == 'SolaimanLipi' ? 'selected' : '' }}>SolaimanLipi (সলাইমান লিপি - ক্ল্যাসিক বাংলা)</option>
                                    <option value="Kalpurush" {{ old('font_family', $document->font_family) == 'Kalpurush' ? 'selected' : '' }}>Kalpurush (কালপুরুষ - ফরমাল বাংলা)</option>
                                    <option value="Tiro Bangla" {{ old('font_family', $document->font_family) == 'Tiro Bangla' ? 'selected' : '' }}>Tiro Bangla (তিরো বাংলা - ঐতিহ্যবাহী সেরিফ)</option>
                                    <option value="Outfit" {{ old('font_family', $document->font_family) == 'Outfit' ? 'selected' : '' }}>Outfit (আউটফিট - আধুনিক ইংলিশ)</option>
                                    <option value="Courier New" {{ old('font_family', $document->font_family) == 'Courier New' ? 'selected' : '' }}>Courier New (টাইপরাইটার স্টাইল)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">ফন্ট সাইজ (Font Size)</label>
                                <select name="font_size" id="fontSizeSelect" class="form-select">
                                    <option value="13px" {{ old('font_size', $document->font_size ?? '15px') == '13px' ? 'selected' : '' }}>ছোট (13px - Compact)</option>
                                    <option value="15px" {{ old('font_size', $document->font_size ?? '15px') == '15px' ? 'selected' : '' }}>মাঝারি (15px - Standard Default)</option>
                                    <option value="17px" {{ old('font_size', $document->font_size ?? '15px') == '17px' ? 'selected' : '' }}>বড় (17px - Large)</option>
                                    <option value="19px" {{ old('font_size', $document->font_size ?? '15px') == '19px' ? 'selected' : '' }}>বিশাল (19px - Extra Large)</option>
                                    <option value="21px" {{ old('font_size', $document->font_size ?? '15px') == '21px' ? 'selected' : '' }}>আল্টরা বড় (21px - Ultra Large)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">অবস্থা (Status)</label>
                                <select name="status" class="form-select" required>
                                    <option value="published" {{ old('status', $document->status) == 'published' ? 'selected' : '' }}>প্রকাশিত (Published)</option>
                                    <option value="draft" {{ old('status', $document->status) == 'draft' ? 'selected' : '' }}>ড্রাফট (Draft)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">অভ্যন্তরীণ নোট (Internal Notes)</label>
                                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $document->notes) }}</textarea>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="ti tabler-check me-1"></i>আপডেট করুন
                                </button>
                                <a href="{{ route('admin.documents.show', $document->id) }}" class="btn btn-outline-secondary">
                                    বাতিল করুন
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function formatText(cmd, value = null) {
        document.execCommand(cmd, false, value);
        document.getElementById('editorArea').focus();
    }

    function insertTable() {
        const tableHtml = `
            <table class="table table-bordered my-3" style="border: 1px solid #ccc; width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 8px; border: 1px solid #ccc;">ক্রমিক</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">বিবরণ</th>
                        <th style="padding: 8px; border: 1px solid #ccc; text-align: right;">পরিমাণ (টাকা)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: center;">১</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">আইটেম / সেবার বিবরণ...</td>
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: right;">০.০০</td>
                    </tr>
                </tbody>
            </table><p></p>
        `;
        document.execCommand('insertHTML', false, tableHtml);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const editorArea = document.getElementById('editorArea');
        const hiddenContent = document.getElementById('hiddenContent');
        const form = document.getElementById('documentForm');

        editorArea.addEventListener('input', function() {
            hiddenContent.value = this.innerHTML;
        });

        form.addEventListener('submit', function() {
            hiddenContent.value = editorArea.innerHTML;
        });
    });
</script>
@endsection
