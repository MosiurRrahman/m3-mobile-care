@extends('layouts/contentNavbarLayout')

@section('title', 'নতুন ডকুমেন্ট তৈরি করুন - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <a href="{{ route('admin.documents.index') }}" class="text-muted me-1"><i class="ti tabler-arrow-left"></i></a>
                নতুন ডকুমেন্ট / প্যাড তৈরি করুন
            </h4>
            <span class="text-muted small">দোকানের প্যাডের জন্য MoU, চুক্তিপত্র, ভাউচার বা নোটিশ ড্রাফট করুন</span>
        </div>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
            <i class="ti tabler-list me-1"></i>সকল ডকুমেন্ট
        </a>
    </div>

    <!-- Main Form -->
    <div class="col-12">
        <form action="{{ route('admin.documents.store') }}" method="POST" id="documentForm">
            @csrf
            <div class="row g-4">
                <!-- Left Column: Document Fields -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-label-primary border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold fs-6">
                                <i class="ti tabler-edit me-2"></i>ডকুমেন্টের বিষয়বস্তু ও বিবরণ
                            </h5>
                        </div>
                        <div class="card-body pt-4">
                            <!-- Template Selector & Presets -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small">১. টেমপ্লেট নির্বাচন করুন (Preset Templates)</label>
                                <div class="d-flex flex-wrap gap-2" id="typeButtons">
                                    <button type="button" class="btn btn-outline-primary type-btn {{ $selectedType == 'mou' ? 'active' : '' }}" data-type="mou">
                                        <i class="ti tabler-file-handshake me-1"></i>সমঝোতা স্মারক (MoU)
                                    </button>
                                    <button type="button" class="btn btn-outline-info type-btn {{ $selectedType == 'agreement' ? 'active' : '' }}" data-type="agreement">
                                        <i class="ti tabler-file-certificate me-1"></i>চুক্তিপত্র (Agreement)
                                    </button>
                                    <button type="button" class="btn btn-outline-success type-btn {{ $selectedType == 'voucher' ? 'active' : '' }}" data-type="voucher">
                                        <i class="ti tabler-receipt me-1"></i>ভাউচার (Voucher)
                                    </button>
                                    <button type="button" class="btn btn-outline-warning type-btn {{ $selectedType == 'notice' ? 'active' : '' }}" data-type="notice">
                                        <i class="ti tabler-bell-ringing me-1"></i>বিজ্ঞপ্তি (Notice)
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary type-btn {{ $selectedType == 'custom' ? 'active' : '' }}" data-type="custom">
                                        <i class="ti tabler-file-code me-1"></i>কাস্টম চিঠি
                                    </button>
                                </div>
                                <input type="hidden" name="type" id="documentType" value="{{ $selectedType }}">
                            </div>

                            <!-- Document Title -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small required">ডকুমেন্টের শিরোনাম (Document Title)</label>
                                <input type="text" name="title" id="documentTitle" class="form-control @error('title') is-invalid @enderror" placeholder="যেমন: ব্যবসা সম্প্রসারণ চুক্তিপত্র" value="{{ old('title', $templates[$selectedType]['title'] ?? '') }}" required>
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
                                    {!! old('content', $templates[$selectedType]['content'] ?? '') !!}
                                </div>

                                <textarea name="content" id="hiddenContent" class="d-none" required>{!! old('content', $templates[$selectedType]['content'] ?? '') !!}</textarea>
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
                                <input type="text" name="recipient_name" id="recipientName" class="form-control" placeholder="যেমন: আব্দুল করিম" value="{{ old('recipient_name') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">মোবাইল নাম্বার</label>
                                <input type="text" name="recipient_phone" id="recipientPhone" class="form-control" placeholder="যেমন: 01700000000" value="{{ old('recipient_phone') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">ঠিকানা (Address)</label>
                                <textarea name="recipient_address" id="recipientAddress" class="form-control" rows="2" placeholder="যেমন: ধানমন্ডি, ঢাকা">{{ old('recipient_address') }}</textarea>
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
                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">লেখা / ডকুমেন্টের ফন্ট (Font Family)</label>
                                <select name="font_family" id="fontFamilySelect" class="form-select">
                                    <option value="Hind Siliguri" {{ old('font_family') == 'Hind Siliguri' ? 'selected' : '' }}>Hind Siliguri (হিন্দ শিলিগুড়ি - ক্লিন মডার্ন)</option>
                                    <option value="SolaimanLipi" {{ old('font_family') == 'SolaimanLipi' ? 'selected' : '' }}>SolaimanLipi (সলাইমান লিপি - ক্ল্যাসিক বাংলা)</option>
                                    <option value="Kalpurush" {{ old('font_family') == 'Kalpurush' ? 'selected' : '' }}>Kalpurush (কালপুরুষ - ফরমাল বাংলা)</option>
                                    <option value="Tiro Bangla" {{ old('font_family') == 'Tiro Bangla' ? 'selected' : '' }}>Tiro Bangla (তিরো বাংলা - ঐতিহ্যবাহী সেরিফ)</option>
                                    <option value="Outfit" {{ old('font_family') == 'Outfit' ? 'selected' : '' }}>Outfit (আউটফিট - আধুনিক ইংলিশ)</option>
                                    <option value="Courier New" {{ old('font_family') == 'Courier New' ? 'selected' : '' }}>Courier New (টাইপরাইটার স্টাইল)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold required">অবস্থা (Status)</label>
                                <select name="status" class="form-select" required>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>প্রকাশিত (Published)</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>ড্রাফট (Draft)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium">অভ্যন্তরীণ নোট (Internal Notes)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="নোট শুধুমাত্র অ্যাডমিন প্যানেলে দেখাবে...">{{ old('notes') }}</textarea>
                            </div>

                            <hr>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="ti tabler-device-floppy me-1"></i>ডকুমেন্ট সেভ করুন
                                </button>
                                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">
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

<!-- Template JSON Data for JS -->
<script>
    const templates = @json($templates);

    // Format HTML Text in ContentEditable Editor
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
        const typeBtns = document.querySelectorAll('.type-btn');
        const documentTypeInput = document.getElementById('documentType');
        const documentTitleInput = document.getElementById('documentTitle');
        const editorArea = document.getElementById('editorArea');
        const hiddenContent = document.getElementById('hiddenContent');
        const form = document.getElementById('documentForm');

        // Preset Template Switching
        typeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                typeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const type = this.getAttribute('data-type');
                documentTypeInput.value = type;

                if (templates[type]) {
                    documentTitleInput.value = templates[type].title;
                    editorArea.innerHTML = templates[type].content;
                    hiddenContent.value = templates[type].content;
                }
            });
        });

        // Sync Contenteditable to Hidden Textarea
        editorArea.addEventListener('input', function() {
            hiddenContent.value = this.innerHTML;
        });

        form.addEventListener('submit', function() {
            hiddenContent.value = editorArea.innerHTML;
        });
    });
</script>
@endsection
