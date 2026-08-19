@extends('layouts/contentNavbarLayout')

@section('title', 'Shop & SMS Settings - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">Shop & SMS Configuration Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop & SMS Settings</li>
            </ol>
        </nav>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success border-0 py-2 d-flex align-items-center">
                <i class="ti tabler-circle-check fs-4 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="col-12 mb-3">
            <div class="alert alert-danger border-0 small py-2">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="col-12">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Shop Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header border-bottom bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark"><i class="ti tabler-building-store me-2 text-primary"></i>Invoice & Shop Details</h5>
                </div>
                <div class="card-body py-4">
                    <div class="row">
                        <!-- Left inputs -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-semibold" for="shop_name">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" id="shop_name" class="form-control" value="{{ old('shop_name', $settings['shop_name']) }}" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-semibold" for="shop_slogan">Shop Slogan / Tagline</label>
                                    <input type="text" name="shop_slogan" id="shop_slogan" class="form-control" value="{{ old('shop_slogan', $settings['shop_slogan']) }}">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-semibold" for="phone">Phone Number(s)</label>
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $settings['phone']) }}">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-semibold" for="whatsapp">WhatsApp Hotline Number</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', $settings['whatsapp'] ?? '+8801353106967') }}" placeholder="+8801353106967">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label fw-semibold" for="email">Support Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $settings['email']) }}">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold" for="address">Shop Physical Address</label>
                                    <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $settings['address']) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Logo uploader right -->
                        <div class="col-md-4 mb-3 border-start border-light d-flex flex-column align-items-center justify-content-center">
                            <label class="form-label fw-semibold mb-3">Shop Logo</label>
                            @if($settings['logo'])
                                <img src="{{ asset('storage/' . $settings['logo']) }}" class="img-fluid rounded mb-3 border p-2" style="max-height: 120px; object-fit: contain;">
                            @else
                                <div class="rounded bg-light border d-flex flex-column align-items-center justify-content-center mb-3" style="width: 150px; height: 120px;">
                                    <i class="ti tabler-photo fs-2 text-muted"></i>
                                    <span class="text-muted small mt-1">No Logo Uploaded</span>
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control form-control-sm w-75" accept="image/*">
                            <span class="text-muted small mt-1.5 fs-8">PNG or JPG (Max 1MB)</span>
                        </div>

                        <hr class="my-3 text-muted opacity-25">

                        <!-- Footer Terms -->
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="receipt_footer">Invoice Receipt Terms & Policy (Footer)</label>
                            <textarea name="receipt_footer" id="receipt_footer" class="form-control font-monospace text-dark" rows="3" placeholder="Enter warranty terms and pickup guidelines...">{{ old('receipt_footer', $settings['receipt_footer']) }}</textarea>
                            <span class="text-muted small d-block mt-1">These terms will print directly at the bottom of Customer Invoices and Job Slips.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS Gateway Configuration Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header border-bottom bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                            <i class="ti tabler-message-2-share text-primary fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">BulkSMSBD Gateway & Automated Notifications</h5>
                            <span class="text-muted small">Send instant live service tracking links, delivery ready alerts, and retail invoices</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-info btn-sm" id="btn-check-balance">
                            <i class="ti tabler-coin me-1"></i>Check Live Balance
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#testSmsModal">
                            <i class="ti tabler-send me-1"></i>Send Test SMS
                        </button>
                    </div>
                </div>

                <div class="card-body py-4">
                    <!-- Balance Banner (Dynamic) -->
                    <div class="alert alert-primary border-0 py-2.5 px-3 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2" id="balance-banner">
                        <div class="d-flex align-items-center">
                            <i class="ti tabler-wallet fs-4 me-2 text-primary"></i>
                            <span class="fw-semibold">Current SMS Balance: </span>
                            <span class="badge bg-primary fs-6 ms-2 px-3 py-1" id="sms-balance-display">Click 'Check Live Balance' to refresh</span>
                        </div>
                        <span class="badge bg-label-success fw-bold">Provider: BulkSMSBD (Non-Masking)</span>
                    </div>

                    <!-- Master Switch & Credentials -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 mb-2">
                            <div class="form-check form-switch form-switch-lg p-0 d-flex align-items-center gap-3">
                                <input class="form-check-input ms-0" type="checkbox" name="sms_enabled" id="sms_enabled" value="1" {{ old('sms_enabled', $settings['sms_enabled']) == '1' ? 'checked' : '' }} style="width: 3rem; height: 1.5rem;">
                                <label class="form-check-label fw-bold text-dark fs-6" for="sms_enabled">
                                    Enable SMS Notifications Service
                                </label>
                            </div>
                            <div class="form-text text-muted ms-1">If turned off, no automated SMS will be dispatched from any module.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_api_key">BulkSMSBD API Key <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti tabler-key"></i></span>
                                <input type="text" name="sms_api_key" id="sms_api_key" class="form-control font-monospace" value="{{ old('sms_api_key', $settings['sms_api_key']) }}" placeholder="Enter BulkSMSBD API Key...">
                            </div>
                            <span class="text-muted small">Found under <code>Developers</code> tab in your BulkSMSBD dashboard.</span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_sender_id">Sender ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti tabler-id"></i></span>
                                <input type="text" name="sms_sender_id" id="sms_sender_id" class="form-control" value="{{ old('sms_sender_id', $settings['sms_sender_id']) }}" placeholder="Approved Non-masking Sender ID e.g. 88096...">
                            </div>
                            <span class="text-muted small">Found under <code>Sender ID</code> in your BulkSMSBD dashboard.</span>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Notification Triggers Grid -->
                    <h6 class="fw-bold text-dark mb-3"><i class="ti tabler-toggle-right me-1 text-primary"></i>Automated SMS Trigger Events</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="sms_send_on_repair_create" id="sms_send_on_repair_create" value="1" {{ old('sms_send_on_repair_create', $settings['sms_send_on_repair_create']) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="sms_send_on_repair_create">New Job Card / Service</label>
                                </div>
                                <p class="text-muted small mb-0">Sends Ticket ID and live tracking link when a repair job is created.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="sms_send_on_repair_ready" id="sms_send_on_repair_ready" value="1" {{ old('sms_send_on_repair_ready', $settings['sms_send_on_repair_ready']) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="sms_send_on_repair_ready">Repair Completed / Ready</label>
                                </div>
                                <p class="text-muted small mb-0">Notifies customer when service status changes to Completed / Ready for pickup.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="sms_send_on_repair_deliver" id="sms_send_on_repair_deliver" value="1" {{ old('sms_send_on_repair_deliver', $settings['sms_send_on_repair_deliver']) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="sms_send_on_repair_deliver">Delivered & Payment Bill</label>
                                </div>
                                <p class="text-muted small mb-0">Sends payment receipt, remaining due, and warranty days when delivered.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="sms_send_on_pos_sale" id="sms_send_on_pos_sale" value="1" {{ old('sms_send_on_pos_sale', $settings['sms_send_on_pos_sale']) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="sms_send_on_pos_sale">POS Retail Sale Invoice</label>
                                </div>
                                <p class="text-muted small mb-0">Sends digital receipt with Invoice No, total bill, paid and due amounts upon POS checkout.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="sms_send_on_due_payment" id="sms_send_on_due_payment" value="1" {{ old('sms_send_on_due_payment', $settings['sms_send_on_due_payment']) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="sms_send_on_due_payment">Customer Due Payment Receipt</label>
                                </div>
                                <p class="text-muted small mb-0">Sends instant payment confirmation when a customer clears an existing due balance.</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Template Customization -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0"><i class="ti tabler-template me-1 text-primary"></i>SMS Message Templates (Customizable)</h6>
                        <span class="text-muted small">You can customize the text below using placeholder tags.</span>
                    </div>

                    <!-- Available Tags Helpers -->
                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <span class="fw-bold small text-dark d-block mb-1"><i class="ti tabler-tag me-1 text-info"></i>Available Dynamic Tags (Click to copy):</span>
                        <div class="d-flex flex-wrap gap-1">
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{customer_name}')">{customer_name}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{ticket_id}')">{ticket_id}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{device}')">{device}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{track_url}')">{track_url}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{total_bill}')">{total_bill}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{paid_amount}')">{paid_amount}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{due_amount}')">{due_amount}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{invoice_no}')">{invoice_no}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{warranty_days}')">{warranty_days}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{shop_name}')">{shop_name}</code>
                            <code class="badge bg-white text-dark border tag-badge" role="button" onclick="copyTag('{shop_phone}')">{shop_phone}</code>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_template_repair_create">1. New Job Card / Service Tracking SMS</label>
                            <textarea name="sms_template_repair_create" id="sms_template_repair_create" class="form-control small font-monospace" rows="3">{{ old('sms_template_repair_create', $settings['sms_template_repair_create']) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_template_repair_ready">2. Repair Ready for Pickup SMS</label>
                            <textarea name="sms_template_repair_ready" id="sms_template_repair_ready" class="form-control small font-monospace" rows="3">{{ old('sms_template_repair_ready', $settings['sms_template_repair_ready']) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_template_repair_deliver">3. Repair Delivered & Bill SMS</label>
                            <textarea name="sms_template_repair_deliver" id="sms_template_repair_deliver" class="form-control small font-monospace" rows="3">{{ old('sms_template_repair_deliver', $settings['sms_template_repair_deliver']) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="sms_template_pos_sale">4. POS Retail Sale Bill SMS</label>
                            <textarea name="sms_template_pos_sale" id="sms_template_pos_sale" class="form-control small font-monospace" rows="3">{{ old('sms_template_pos_sale', $settings['sms_template_pos_sale']) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" for="sms_template_due_payment">5. Due Payment Collected SMS</label>
                            <textarea name="sms_template_due_payment" id="sms_template_due_payment" class="form-control small font-monospace" rows="2">{{ old('sms_template_due_payment', $settings['sms_template_due_payment']) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer border-top bg-transparent py-3 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="ti tabler-device-floppy me-1"></i>Save All Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Test SMS Modal -->
<div class="modal fade" id="testSmsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="ti tabler-send text-primary me-2"></i>Send Test SMS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div id="test-sms-alert" class="alert d-none py-2 px-3 small mb-3"></div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="test_phone">Recipient Mobile Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti tabler-phone"></i></span>
                        <input type="text" id="test_phone" class="form-control" placeholder="e.g. 01712345678" value="{{ auth()->user()->phone ?? '01353106967' }}">
                    </div>
                    <span class="text-muted small">Enter an active 11-digit Bangladeshi phone number.</span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="test_message">Test SMS Message <span class="text-danger">*</span></label>
                    <textarea id="test_message" class="form-control" rows="3">Test SMS from M3 Mobile Care via BulkSMSBD! System is working properly.</textarea>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="btn-send-test-sms">
                    <span class="spinner-border spinner-border-sm me-1 d-none" id="test-sms-spinner"></span>
                    <i class="ti tabler-send me-1" id="test-sms-icon"></i>Send Test Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnCheckBalance = document.getElementById('btn-check-balance');
    const balanceDisplay = document.getElementById('sms-balance-display');
    const btnSendTestSms = document.getElementById('btn-send-test-sms');
    const testSmsAlert = document.getElementById('test-sms-alert');
    const testSmsSpinner = document.getElementById('test-sms-spinner');
    const testSmsIcon = document.getElementById('test-sms-icon');

    // Fetch Balance
    function fetchBalance() {
        const apiKeyInput = document.getElementById('sms_api_key');
        const apiKey = apiKeyInput ? apiKeyInput.value.trim() : '';

        if (!apiKey) {
            balanceDisplay.innerText = 'Please enter API Key';
            balanceDisplay.className = 'badge bg-warning fs-6 ms-2 px-3 py-1';
            return;
        }

        balanceDisplay.innerText = 'Checking...';
        balanceDisplay.className = 'badge bg-secondary fs-6 ms-2 px-3 py-1';

        fetch('{{ route("admin.settings.sms-balance") }}?api_key=' + encodeURIComponent(apiKey))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    balanceDisplay.innerText = `${data.balance} ৳ / SMS Credits`;
                    balanceDisplay.className = 'badge bg-success fs-6 ms-2 px-3 py-1';
                } else {
                    balanceDisplay.innerText = data.message || 'Error fetching balance';
                    balanceDisplay.className = 'badge bg-danger fs-6 ms-2 px-3 py-1 text-wrap';
                }
            })
            .catch(err => {
                balanceDisplay.innerText = 'Network error contacting server';
                balanceDisplay.className = 'badge bg-danger fs-6 ms-2 px-3 py-1';
            });
    }

    if (btnCheckBalance) {
        btnCheckBalance.addEventListener('click', fetchBalance);
        // Auto fetch on page load
        fetchBalance();
    }

    // Send Test SMS
    if (btnSendTestSms) {
        btnSendTestSms.addEventListener('click', function () {
            const phone = document.getElementById('test_phone').value.trim();
            const message = document.getElementById('test_message').value.trim();

            if (!phone || !message) {
                testSmsAlert.className = 'alert alert-danger py-2 px-3 small mb-3';
                testSmsAlert.innerText = 'Please provide both a recipient phone and message.';
                testSmsAlert.classList.remove('d-none');
                return;
            }

            btnSendTestSms.disabled = true;
            testSmsSpinner.classList.remove('d-none');
            testSmsIcon.classList.add('d-none');
            testSmsAlert.classList.add('d-none');

            fetch('{{ route("admin.settings.test-sms") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    test_phone: phone,
                    test_message: message
                })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                btnSendTestSms.disabled = false;
                testSmsSpinner.classList.add('d-none');
                testSmsIcon.classList.remove('d-none');

                if (body.success) {
                    testSmsAlert.className = 'alert alert-success py-2 px-3 small mb-3';
                    testSmsAlert.innerText = body.message;
                    testSmsAlert.classList.remove('d-none');
                    // Refresh balance
                    fetchBalance();
                } else {
                    testSmsAlert.className = 'alert alert-danger py-2 px-3 small mb-3';
                    testSmsAlert.innerText = body.message || 'Failed to send SMS.';
                    testSmsAlert.classList.remove('d-none');
                }
            })
            .catch(err => {
                btnSendTestSms.disabled = false;
                testSmsSpinner.classList.add('d-none');
                testSmsIcon.classList.remove('d-none');
                testSmsAlert.className = 'alert alert-danger py-2 px-3 small mb-3';
                testSmsAlert.innerText = 'Network request failed: ' . err.message;
                testSmsAlert.classList.remove('d-none');
            });
        });
    }
});

function copyTag(tag) {
    navigator.clipboard.writeText(tag).then(() => {
        alert('Copied tag ' + tag + ' to clipboard!');
    });
}
</script>
@endsection
