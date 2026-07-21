@extends('layouts/blankLayout')

@section('title', 'Booking Successful - M3 Mobile Care')

@section('content')
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <span class="fs-4 fw-bold text-primary">M3</span>
            <span class="fs-4 fw-bold text-white ms-1">Mobile Care</span>
        </a>
    </div>
</nav>

<div class="py-5 bg-light d-flex align-items-center" style="min-height: 90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <div class="card-body">
                        <!-- Icon success -->
                        <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="ti tabler-circle-check fs-1"></i>
                        </div>
                        
                        <h2 class="fw-bold text-success mb-2">Booking Confirmed!</h2>
                        <p class="text-muted leading-relaxed">Thank you, {{ $repair->customer ? $repair->customer->name : 'Customer' }}. Your booking request for the <strong>{{ $repair->device_brand }} {{ $repair->device_model }}</strong> repair has been registered successfully.</p>
                        
                        <div class="my-5 p-4 bg-light rounded-3 border">
                            <span class="text-uppercase text-muted fw-semibold small d-block mb-1">Your Tracking Ticket ID</span>
                            <h2 class="fw-extrabold text-dark tracking-wide mb-3" id="ticket-id">{{ $repair->ticket_id }}</h2>
                            <button class="btn btn-outline-primary btn-sm" onclick="copyTicketId()">
                                <i class="ti tabler-copy me-1"></i>Copy Ticket Code
                            </button>
                        </div>

                        <div class="text-start mb-4">
                            <h5 class="fw-bold mb-3"><i class="ti tabler-help text-primary me-2"></i>What's Next?</h5>
                            <ol class="text-muted small ps-3">
                                <li class="mb-2"><strong>Bring your device:</strong> Visit our shop with the Ticket ID, or ship the device to our store address listed below.</li>
                                <li class="mb-2"><strong>Technician Diagnosis:</strong> Once we receive your device, a technician will be assigned to examine the device and update the status notes.</li>
                                <li class="mb-2"><strong>Live Status:</strong> You can enter this Ticket ID on our homepage anytime to track the live progress, technician notes, and final cost.</li>
                            </ol>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-center mt-5">
                            <a href="{{ route('home', ['ticket_id' => $repair->ticket_id]) }}" class="btn btn-primary px-4 py-2.5">
                                <i class="ti tabler-search me-1"></i>Track status now
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2.5">
                                Return to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyTicketId() {
        const ticketId = document.getElementById('ticket-id').innerText;
        navigator.clipboard.writeText(ticketId).then(function() {
            alert('Ticket ID copied to clipboard: ' + ticketId);
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endsection
