@extends('layouts/blankLayout')

@section('title', 'Booking Successful - M3 Mobile Care')
@section('meta_robots', 'noindex, follow')

@section('content')
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/branding/logo-dark-icon.png') }}" alt="M3 Logo" width="32" height="32" class="me-2">
            <span class="fs-4 fw-bold text-primary">M3</span>
            <span class="fs-4 fw-bold text-white ms-1">Mobile Care</span>
        </a>
    </div>
</nav>

<main class="py-5 bg-light" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <div class="card-body">
                        <!-- Icon success -->
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="ti tabler-circle-check fs-1"></i>
                        </div>
                        
                        <h1 class="h2 fw-bold text-success mb-2">Booking Confirmed!</h1>
                        @php
                            $customerName = ($repair->customer && !empty($repair->customer->name)) ? $repair->customer->name : 'Valued Customer';
                            $count = isset($repairs) ? $repairs->count() : 1;
                        @endphp

                        @if($count > 1)
                            <p class="text-muted leading-relaxed mb-4">
                                Thank you, <strong>{{ $customerName }}</strong>. Your booking requests for <strong>{{ $count }} devices</strong> have been registered successfully! Each device has its own tracking ticket ID below.
                            </p>

                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-outline-primary btn-sm" onclick="copyAllTicketIds()">
                                    <i class="ti tabler-copy me-1"></i>Copy All Ticket IDs
                                </button>
                            </div>

                            <div class="text-start mb-4">
                                @foreach($repairs as $idx => $r)
                                <div class="card mb-3 border rounded-3 bg-white shadow-none">
                                    <div class="card-body p-3 p-md-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                            <div>
                                                <span class="badge bg-primary me-2">Device #{{ $idx + 1 }}</span>
                                                <span class="fw-bold text-dark fs-5">{{ $r->device_brand }} {{ $r->device_model }}</span>
                                            </div>
                                            <span class="badge bg-label-warning text-uppercase">{{ $r->status }}</span>
                                        </div>

                                        <p class="text-muted small mb-3"><strong>Reported Issue:</strong> {{ $r->issue_description }}</p>

                                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 flex-wrap gap-2">
                                            <div>
                                                <span class="text-muted small d-block">Tracking Ticket ID:</span>
                                                <span class="h4 fw-extrabold text-primary mb-0 font-monospace ticket-code" id="ticket-id-{{ $idx }}">{{ $r->ticket_id }}</span>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline-secondary btn-sm" onclick="copySpecificTicket('{{ $r->ticket_id }}')">
                                                    <i class="ti tabler-copy me-1"></i>Copy Code
                                                </button>
                                                <a href="{{ route('home', ['ticket_id' => $r->ticket_id]) }}" class="btn btn-primary btn-sm" target="_blank">
                                                    <i class="ti tabler-search me-1"></i>Live Track
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted leading-relaxed">Thank you, {{ $customerName }}. Your booking request for the <strong>{{ $repair->device_brand }} {{ $repair->device_model }}</strong> repair has been registered successfully.</p>
                            
                            <div class="my-5 p-4 bg-light rounded-3 border">
                                <span class="text-uppercase text-muted fw-semibold small d-block mb-1">Your Tracking Ticket ID</span>
                                <h2 class="fw-extrabold text-dark tracking-wide mb-3 ticket-code" id="ticket-id">{{ $repair->ticket_id }}</h2>
                                <button class="btn btn-outline-primary btn-sm" onclick="copySpecificTicket('{{ $repair->ticket_id }}')">
                                    <i class="ti tabler-copy me-1"></i>Copy Ticket Code
                                </button>
                            </div>
                        @endif

                        <div class="text-start mb-4">
                            <h3 class="h5 fw-bold mb-3"><i class="ti tabler-help text-primary me-2"></i>What's Next?</h3>
                            <ol class="text-muted small ps-3">
                                <li class="mb-2"><strong>Bring your device(s):</strong> Visit our shop with the Ticket ID, or ship the device to our store address.</li>
                                <li class="mb-2"><strong>Technician Diagnosis:</strong> Once we receive your device, a technician will examine it and update status notes.</li>
                                <li class="mb-2"><strong>Live Status:</strong> Enter your Ticket ID on our homepage anytime to track live progress, technician notes, and final cost.</li>
                            </ol>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-center mt-5">
                            @if(isset($repairs) && $repairs->count() > 1)
                                <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                                    <i class="ti tabler-search me-1"></i>Track On Homepage
                                </a>
                            @else
                                <a href="{{ route('home', ['ticket_id' => $repair->ticket_id]) }}" class="btn btn-primary px-4 py-2">
                                    <i class="ti tabler-search me-1"></i>Track status now
                                </a>
                            @endif
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2">
                                Return to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function copySpecificTicket(ticketId) {
        navigator.clipboard.writeText(ticketId).then(function() {
            if (typeof iziToast !== 'undefined') {
                iziToast.success({
                    title: 'Copied!',
                    message: 'Ticket ID ' + ticketId + ' copied to clipboard.',
                    position: 'topRight'
                });
            } else {
                alert('Ticket ID copied to clipboard: ' + ticketId);
            }
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }

    function copyTicketId() {
        const ticketEl = document.getElementById('ticket-id');
        if (ticketEl) {
            copySpecificTicket(ticketEl.innerText.trim());
        }
    }

    function copyAllTicketIds() {
        const ticketEls = document.querySelectorAll('.ticket-code');
        const tickets = Array.from(ticketEls).map(el => el.innerText.trim()).filter(Boolean);
        if (tickets.length) {
            const textToCopy = tickets.join(', ');
            navigator.clipboard.writeText(textToCopy).then(function() {
                if (typeof iziToast !== 'undefined') {
                    iziToast.success({
                        title: 'All Copied!',
                        message: 'All ' + tickets.length + ' Ticket IDs copied: ' + textToCopy,
                        position: 'topRight'
                    });
                } else {
                    alert('All Ticket IDs copied to clipboard: ' + textToCopy);
                }
            });
        }
    }
</script>
@endsection
