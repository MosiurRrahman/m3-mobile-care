@extends('layouts/blankLayout')

@section('title', 'Book Online Smartphone Repair Appointment - M3 Mobile Care')
@section('meta_description', 'Book an online repair appointment with M3 Mobile Care – Trusted Mobile Repair & Accessories Shop at (বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও. Website: www.m3mobilecares.com, Mobile: +8801353106967 / +8801353106966.')
@section('meta_keywords', 'Book Mobile Repair, Online Phone Repair Appointment, Smartphone Repair Booking Bangladesh, iPhone Screen Repair Booking, Ranisankail Mobile Repair')

@section('head_extra')
<!-- BreadcrumbList & Service JSON-LD Schema -->
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@graph' => [
    [
      '@type' => 'BreadcrumbList',
      'itemListElement' => [
        [
          '@type' => 'ListItem',
          'position' => 1,
          'name' => 'Home',
          'item' => url('/')
        ],
        [
          '@type' => 'ListItem',
          'position' => 2,
          'name' => 'Book Repair',
          'item' => route('book.form')
        ]
      ]
    ],
    [
      '@type' => 'Service',
      'name' => 'Online Mobile Repair Appointment Booking',
      'provider' => [
        '@type' => 'MobilePhoneRepairStore',
        'name' => 'M3 Mobile Care',
        'url' => url('/')
      ],
      'areaServed' => 'BD',
      'description' => 'Book phone repairs online for screen display replacement, battery swap, micro-soldering, and software flashing.'
    ]
  ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
<style>
  .border-dashed {
    border-style: dashed !important;
  }
  .device-card {
    transition: all 0.2s ease;
  }
  .device-card:hover {
    border-color: #f37021 !important;
  }
</style>
@endsection

@section('content')
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" aria-label="Booking Page Header Navigation">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" aria-label="M3 Mobile Care Homepage">
            <img src="{{ asset('assets/img/branding/logo-dark-icon.png') }}" alt="M3 Logo" width="32" height="32" class="me-2">
            <span class="fs-4 fw-bold text-primary">M3</span>
            <span class="fs-4 fw-bold text-white ms-1">Mobile Care</span>
        </a>
        <a class="btn btn-outline-light btn-sm ms-auto" href="{{ route('home') }}"><i class="ti tabler-arrow-left me-1"></i>Back to Home</a>
    </div>
</nav>

<main class="py-5 bg-light" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="text-center mb-4">
                    <span class="badge bg-label-primary px-3 py-1 mb-2">Booking Request</span>
                    <h1 class="fw-bold h2 text-dark">Online Repair Booking</h1>
                    <p class="text-muted">Fill out the details below to book your phone repair appointment. You can add multiple mobiles under one customer booking.</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="ti tabler-alert-circle me-1"></i> অনুগ্রহ করে নিচের তথ্যগুলো চেক করুন:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('book.store') }}" method="POST" id="booking-form">
                            @csrf

                            <!-- Section 1: Customer Info -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="h5 fw-bold mb-0 text-primary"><i class="ti tabler-user me-2"></i>1. Customer Information (গ্রাহকের তথ্য)</h2>
                                <span class="badge bg-light text-muted fw-normal" id="lookup-status-badge"></span>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0 position-relative">
                                    <label class="form-label fw-semibold" for="customer_phone">Phone Number (মোবাইল নম্বর) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="e.g. 01712345678" value="{{ old('customer_phone') }}" required autocomplete="tel">
                                        <span class="input-group-text d-none" id="phone-spinner">
                                            <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                                        </span>
                                    </div>
                                    <div class="form-text small text-muted"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="customer_name">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="e.g. Rahim Ali" value="{{ old('customer_name') }}" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="customer_email">Email Address <span class="text-muted">(Optional)</span></label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="e.g. rahim@example.com" value="{{ old('customer_email') }}">
                                    <div class="form-text">We'll use this to send repair updates and tracking credentials.</div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <!-- Section 2: Device(s) Info -->
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <div>
                                    <h2 class="h5 fw-bold mb-0 text-primary"><i class="ti tabler-device-mobile me-2"></i>2. Devices Information</h2>
                                    
                                </div>
                                <span class="badge bg-label-primary px-3 py-2 fs-6" id="total-devices-badge">1 Device</span>
                            </div>

                            <!-- Devices Container -->
                            <div id="devices-container">
                                @php
                                    $oldDevices = old('devices');
                                    if (empty($oldDevices) || !is_array($oldDevices)) {
                                        $oldDevices = [
                                            [
                                                'brand' => old('device_brand', ''),
                                                'model' => old('device_model', request('model', '')),
                                                'service_id' => old('service_type', ''),
                                                'serial_imei' => old('serial_imei', ''),
                                                'issue_description' => old('issue_description', ''),
                                                'estimated_cost' => old('estimated_cost', 0),
                                            ]
                                        ];
                                    }
                                @endphp

                                @foreach($oldDevices as $i => $dev)
                                <div class="card device-card mb-4 border rounded-3 bg-light shadow-none" data-device-index="{{ $i }}">
                                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2 device-badge">Mobile #{{ $i + 1 }}</span>
                                            <span class="fw-semibold text-dark device-title-text">{{ !empty($dev['brand']) || !empty($dev['model']) ? trim(($dev['brand'] ?? '') . ' ' . ($dev['model'] ?? '')) : 'Device Details' }}</span>
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-remove-device {{ count($oldDevices) > 1 ? '' : 'd-none' }}" title="Remove this device">
                                            <i class="ti tabler-trash me-1"></i>Remove
                                        </button>
                                    </div>
                                    <div class="card-body p-3 p-md-4">
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label class="form-label fw-semibold">Device Brand<span class="text-danger">*</span></label>
                                                <select name="devices[{{ $i }}][brand]" class="form-select device-brand" required>
                                                    <option value="" disabled {{ empty($dev['brand']) ? 'selected' : '' }}>Select Brand</option>
                                                    <option value="Apple" {{ ($dev['brand'] ?? '') == 'Apple' ? 'selected' : '' }}>Apple (iPhone/iPad)</option>
                                                    <option value="Samsung" {{ ($dev['brand'] ?? '') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                                    <option value="Xiaomi" {{ ($dev['brand'] ?? '') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi / Redmi</option>
                                                    <option value="Realme" {{ ($dev['brand'] ?? '') == 'Realme' ? 'selected' : '' }}>Realme</option>
                                                    <option value="Oppo" {{ ($dev['brand'] ?? '') == 'Oppo' ? 'selected' : '' }}>Oppo</option>
                                                    <option value="Vivo" {{ ($dev['brand'] ?? '') == 'Vivo' ? 'selected' : '' }}>Vivo</option>
                                                    <option value="OnePlus" {{ ($dev['brand'] ?? '') == 'OnePlus' ? 'selected' : '' }}>OnePlus</option>
                                                    <option value="Google" {{ ($dev['brand'] ?? '') == 'Google' ? 'selected' : '' }}>Google Pixel</option>
                                                    <option value="Other" {{ ($dev['brand'] ?? '') == 'Other' ? 'selected' : '' }}>Other Brand</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Device Model <span class="text-danger">*</span></label>
                                                <input type="text" name="devices[{{ $i }}][model]" class="form-control device-model" placeholder="e.g. iPhone 13 Pro Max, Galaxy S21" required value="{{ $dev['model'] ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label class="form-label fw-semibold">Select Core Repair Service <span class="text-muted">(Optional)</span></label>
                                                <select name="devices[{{ $i }}][service_id]" class="form-select device-service">
                                                    <option value="" data-price="0" {{ empty($dev['service_id']) ? 'selected' : '' }}>Custom / Unlisted Service</option>
                                                    @foreach($services as $service)
                                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ ($dev['service_id'] ?? '') == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} ({{ number_format($service->price, 0) }} BDT)
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">IMEI or Serial Number <span class="text-muted">(Optional)</span></label>
                                                <input type="text" name="devices[{{ $i }}][serial_imei]" class="form-control device-imei" placeholder="Enter IMEI to speed up service" value="{{ $dev['serial_imei'] ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Describe the Issue  <span class="text-danger">*</span></label>
                                                <textarea name="devices[{{ $i }}][issue_description]" rows="3" class="form-control device-issue" placeholder="Tell us what is wrong with this device (e.g. Screen cracked, battery draining fast, touch dead, charging problem)..." required>{{ $dev['issue_description'] ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="p-3 bg-white rounded border device-price-box {{ !empty($dev['estimated_cost']) && $dev['estimated_cost'] > 0 ? '' : 'd-none' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold text-muted small">Estimated Price for this device:</span>
                                                <span class="fw-bold text-success device-price-label">{{ number_format($dev['estimated_cost'] ?? 0, 0) }} BDT</span>
                                            </div>
                                            <input type="hidden" name="devices[{{ $i }}][estimated_cost]" class="device-price-input" value="{{ $dev['estimated_cost'] ?? 0 }}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Add Another Device Button -->
                            <div class="mb-4">
                                <button type="button" id="btn-add-device" class="btn btn-outline-primary w-100 py-3 rounded-3 fw-bold border-2 border-dashed">
                                    <i class="ti tabler-plus fs-5 me-1"></i> + Add Another Mobile 
                                </button>
                            </div>

                            <!-- Total Estimated Cost Summary Box -->
                            <div class="p-4 bg-light-subtle rounded-3 mb-4 border d-none" id="total_estimate_box">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <span class="fw-bold text-dark fs-6 d-block">Total Estimated Cost (<span id="total_devices_text">1 Device</span>):</span>
                                        <small class="text-muted">Final cost may adjust after physical technician diagnosis</small>
                                    </div>
                                    <span class="fs-3 fw-extrabold text-success" id="total_price_label">0 BDT</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow-sm fw-bold">
                                <i class="ti tabler-check me-2"></i>Submit Booking Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Hidden Template for Dynamic Device Cards -->
<template id="device-template">
    <div class="card device-card mb-4 border rounded-3 bg-light shadow-none" data-device-index="__INDEX__">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2 device-badge">Mobile #__NUMBER__</span>
                <span class="fw-semibold text-dark device-title-text">Device Details</span>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-device" title="Remove this device">
                <i class="ti tabler-trash me-1"></i>Remove
            </button>
        </div>
        <div class="card-body p-3 p-md-4">
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-semibold">Device Brand <span class="text-danger">*</span></label>
                    <select name="devices[__INDEX__][brand]" class="form-select device-brand" required>
                        <option value="" disabled selected>Select Brand</option>
                        <option value="Apple">Apple (iPhone/iPad)</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Xiaomi">Xiaomi / Redmi</option>
                        <option value="Realme">Realme</option>
                        <option value="Oppo">Oppo</option>
                        <option value="Vivo">Vivo</option>
                        <option value="OnePlus">OnePlus</option>
                        <option value="Google">Google Pixel</option>
                        <option value="Other">Other Brand</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Device Model <span class="text-danger">*</span></label>
                    <input type="text" name="devices[__INDEX__][model]" class="form-control device-model" placeholder="e.g. iPhone 13 Pro Max, Galaxy S21" required value="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-semibold">Select Core Repair Service <span class="text-muted">(Optional)</span></label>
                    <select name="devices[__INDEX__][service_id]" class="form-select device-service">
                        <option value="" data-price="0" selected>Custom / Unlisted Service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} ({{ number_format($service->price, 0) }} BDT)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">IMEI or Serial Number <span class="text-muted">(Optional)</span></label>
                    <input type="text" name="devices[__INDEX__][serial_imei]" class="form-control device-imei" placeholder="Enter IMEI to speed up service">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Describe the Issue  <span class="text-danger">*</span></label>
                    <textarea name="devices[__INDEX__][issue_description]" rows="3" class="form-control device-issue" placeholder="Tell us what is wrong with this device (e.g. Screen cracked, battery draining fast, touch dead, charging problem)..." required></textarea>
                </div>
            </div>
            <div class="p-3 bg-white rounded border device-price-box d-none">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-muted small">Estimated Price for this device:</span>
                    <span class="fw-bold text-success device-price-label">0 BDT</span>
                </div>
                <input type="hidden" name="devices[__INDEX__][estimated_cost]" class="device-price-input" value="0">
            </div>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('devices-container');
        const btnAdd = document.getElementById('btn-add-device');
        const template = document.getElementById('device-template');
        const totalEstimateBox = document.getElementById('total_estimate_box');
        const totalPriceLabel = document.getElementById('total_price_label');
        const totalDevicesText = document.getElementById('total_devices_text');
        const totalDevicesBadge = document.getElementById('total-devices-badge');

        // Customer auto-lookup by phone
        const phoneInput = document.getElementById('customer_phone');
        const nameInput = document.getElementById('customer_name');
        const emailInput = document.getElementById('customer_email');
        const phoneSpinner = document.getElementById('phone-spinner');
        const lookupBadge = document.getElementById('lookup-status-badge');

        let phoneTimeout = null;
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                clearTimeout(phoneTimeout);
                const phone = phoneInput.value.trim();
                if (phone.length < 8) {
                    if (lookupBadge) lookupBadge.innerText = '';
                    return;
                }

                if (phoneSpinner) phoneSpinner.classList.remove('d-none');

                phoneTimeout = setTimeout(() => {
                    fetch(`{{ route('customer.lookup.ajax') }}?phone=${encodeURIComponent(phone)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (phoneSpinner) phoneSpinner.classList.add('d-none');
                            if (data.found) {
                                if (data.name && (!nameInput.value || nameInput.value === 'Walk-in Customer')) {
                                    nameInput.value = data.name;
                                }
                                if (data.email && !emailInput.value) {
                                    emailInput.value = data.email;
                                }
                                if (lookupBadge) {
                                    lookupBadge.className = 'badge bg-label-success';
                                    lookupBadge.innerText = 'Existing Customer Recognized ✓';
                                }
                            } else {
                                if (lookupBadge) lookupBadge.innerText = '';
                            }
                        })
                        .catch(() => {
                            if (phoneSpinner) phoneSpinner.classList.add('d-none');
                        });
                }, 400);
            });
        }
        // Add Device
        btnAdd.addEventListener('click', function() {
            const currentCards = container.querySelectorAll('.device-card');
            const newIndex = currentCards.length;
            const newNumber = newIndex + 1;
            const html = template.innerHTML
                .replace(/__INDEX__/g, newIndex)
                .replace(/__NUMBER__/g, newNumber);
            const div = document.createElement('div');
            div.innerHTML = html.trim();
            const newCard = div.firstChild;
            container.appendChild(newCard);
            reindexDevices();
            updateTotalEstimate();
            // Smooth scroll to the newly added device
            newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        // Delegate Remove Device & Change Events
        container.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-device');
            if (btnRemove) {
                const card = btnRemove.closest('.device-card');
                if (card && container.querySelectorAll('.device-card').length > 1) {
                    card.remove();
                    reindexDevices();
                    updateTotalEstimate();
                }
            }
        });

        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('device-service')) {
                updateCardPrice(e.target.closest('.device-card'));
                updateTotalEstimate();
            }
            if (e.target.classList.contains('device-brand') || e.target.classList.contains('device-model')) {
                updateCardTitle(e.target.closest('.device-card'));
            }
        });
        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('device-model')) {
                updateCardTitle(e.target.closest('.device-card'));
            }
        });
        function updateCardTitle(card) {
            if (!card) return;
            const brand = card.querySelector('.device-brand')?.value || '';
            const model = card.querySelector('.device-model')?.value || '';
            const titleEl = card.querySelector('.device-title-text');
            if (titleEl) {
                const fullText = (brand + ' ' + model).trim();
                titleEl.innerText = fullText.length ? fullText : 'Device Details';
            }
        }
        function updateCardPrice(card) {
            if (!card) return;
            const select = card.querySelector('.device-service');
            const priceBox = card.querySelector('.device-price-box');
            const priceLabel = card.querySelector('.device-price-label');
            const priceInput = card.querySelector('.device-price-input');
            if (!select || !priceBox || !priceLabel || !priceInput) return;
            const opt = select.options[select.selectedIndex];
            const price = parseFloat(opt ? opt.getAttribute('data-price') : 0) || 0;
            if (price > 0) {
                priceBox.classList.remove('d-none');
                priceLabel.innerText = price.toLocaleString('en-US') + ' BDT';
                priceInput.value = price;
            } else {
                priceBox.classList.add('d-none');
                priceInput.value = 0;
            }
        }
        function reindexDevices() {
            const cards = container.querySelectorAll('.device-card');
            const totalCount = cards.length;
            cards.forEach((card, index) => {
                const number = index + 1;
                card.setAttribute('data-device-index', index);
                // Update badge
                const badge = card.querySelector('.device-badge');
                if (badge) badge.innerText = 'Mobile #' + number;

                // Update remove button visibility
                const removeBtn = card.querySelector('.btn-remove-device');
                if (removeBtn) {
                    if (totalCount > 1) {
                        removeBtn.classList.remove('d-none');
                    } else {
                        removeBtn.classList.add('d-none');
                    }
                }

                // Update form field names
                const inputs = card.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/devices\[\d+\]/, `devices[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });

            // Update badges
            const devLabel = totalCount === 1 ? '1 Device' : `${totalCount} Devices`;
            if (totalDevicesBadge) totalDevicesBadge.innerText = devLabel;
            if (totalDevicesText) totalDevicesText.innerText = devLabel;
        }

        function updateTotalEstimate() {
            const cards = container.querySelectorAll('.device-card');
            let sum = 0;
            let hasPrice = false;

            cards.forEach(card => {
                const priceInput = card.querySelector('.device-price-input');
                const p = parseFloat(priceInput ? priceInput.value : 0) || 0;
                if (p > 0) {
                    sum += p;
                    hasPrice = true;
                }
            });

            if (hasPrice && sum > 0) {
                totalEstimateBox.classList.remove('d-none');
                totalPriceLabel.innerText = sum.toLocaleString('en-US') + ' BDT';
            } else {
                totalEstimateBox.classList.add('d-none');
            }
        }

        // Initialize prices and titles on page load
        container.querySelectorAll('.device-card').forEach(card => {
            updateCardPrice(card);
            updateCardTitle(card);
        });
        reindexDevices();
        updateTotalEstimate();
    });
</script>
@endsection
