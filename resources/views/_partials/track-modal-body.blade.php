@if($repair)
<div class="row g-4 text-start">
    <!-- Ticket Info Panel -->
    <div class="col-lg-5">
        <div class="glass-card p-4 h-100 bg-white bg-opacity-5" style="border-radius: 16px;">
            <h5 class="fw-bold mb-4 text-white d-flex align-items-center"><i class="ti tabler-info-circle text-primary me-2"></i>Device & Owner Info</h5>
            
            <div class="d-flex flex-column gap-3">
                <div class="border-bottom border-white border-opacity-5 pb-2.5">
                    <span class="label-title d-block mb-1">Customer Name</span>
                    <span class="value-text">{{ $repair->customer ? $repair->customer->name : 'Walk-in Customer' }}</span>
                </div>
                <div class="border-bottom border-white border-opacity-5 pb-2.5">
                    <span class="label-title d-block mb-1">Device Model</span>
                    <span class="value-text d-flex align-items-center">
                        <i class="ti tabler-device-mobile text-primary me-1.5"></i>{{ $repair->device_brand }} {{ $repair->device_model }}
                    </span>
                </div>
                <div class="border-bottom border-white border-opacity-5 pb-2.5">
                    <span class="label-title d-block mb-1">IMEI / Serial</span>
                    <span class="value-text font-monospace">{{ $repair->serial_imei ?? 'N/A' }}</span>
                </div>
                <div class="border-bottom border-white border-opacity-5 pb-2.5">
                    <span class="label-title d-block mb-1">Diagnosed Issue</span>
                    <span class="value-text" style="font-weight: 400;">{{ $repair->issue_description }}</span>
                </div>
                <div class="border-bottom border-white border-opacity-5 pb-2.5">
                    <span class="label-title d-block mb-1">Payment Estimate</span>
                    <span class="text-success fw-extrabold fs-5">{{ number_format($repair->estimated_cost, 2) }} BDT</span>
                </div>
                @if($repair->expected_delivery_date)
                <div>
                    <span class="label-title d-block mb-1">Expected Delivery</span>
                    <span class="text-warning fw-bold"><i class="ti tabler-calendar-clock me-1.5"></i>{{ \Carbon\Carbon::parse($repair->expected_delivery_date)->format('M d, Y') }}</span>
                </div>
                @endif
            </div>

            @if($repair->technician_notes)
            <div class="mt-4 p-3 rounded bg-white bg-opacity-5 border-start border-3 border-primary">
                <span class="text-primary small fw-bold d-block mb-1">Updates from Laboratory:</span>
                <p class="mb-0 value-text small" style="font-weight: 400;">{{ $repair->technician_notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Visual State Timeline -->
    <div class="col-lg-7">
        <div class="glass-card p-4 h-100 bg-white bg-opacity-5" style="border-radius: 16px;">
            <h5 class="fw-bold mb-5 text-white d-flex align-items-center"><i class="ti tabler-timeline text-primary me-2"></i>Service Stage Tracker</h5>
            
            @php
                $status = $repair->status;
                $steps = [
                    'pending' => ['Title' => 'Awaiting Review', 'Desc' => 'Ticket created and device logged in database.', 'Icon' => 'tabler-ticket'],
                    'diagnosing' => ['Title' => 'Diagnostic Assessment', 'Desc' => 'Technician checking battery status, circuit values, & screens.', 'Icon' => 'tabler-zoom-check'],
                    'waiting_for_approval' => ['Title' => 'Pending Approval', 'Desc' => 'Waiting for customer consent on final estimates.', 'Icon' => 'tabler-clock'],
                    'repairing' => ['Title' => 'Active Repair Room', 'Desc' => 'Replacing IC components, glass lamination, or software flash.', 'Icon' => 'tabler-tool'],
                    'quality_check' => ['Title' => 'Quality Checks', 'Desc' => 'Testing touch responses, camera focus, & charging profiles.', 'Icon' => 'tabler-shield-check'],
                    'completed' => ['Title' => 'Ready for Pickup', 'Desc' => 'Successfully restored. Invoice prepared.', 'Icon' => 'tabler-checkbox'],
                    'delivered' => ['Title' => 'Closed / Handover', 'Desc' => 'Settled and delivered back to user.', 'Icon' => 'tabler-archive']
                ];

                $statusOrder = ['pending', 'diagnosing', 'waiting_for_approval', 'repairing', 'quality_check', 'completed', 'delivered'];
                $currentIndex = array_search($status, $statusOrder);
                if ($status == 'cancelled') {
                    $steps['cancelled'] = ['Title' => 'Cancelled Ticket', 'Desc' => 'This ticket has been cancelled.', 'Icon' => 'tabler-square-x'];
                    $statusOrder = ['pending', 'cancelled'];
                    $currentIndex = 1;
                }
            @endphp

            <div class="position-relative ps-4 text-start" style="border-left: 2px dashed rgba(255,255,255,0.1); margin-left: 15px;">
                @foreach($statusOrder as $index => $stepKey)
                    @php
                        $step = $steps[$stepKey];
                        $isPassed = $currentIndex >= $index && $status != 'cancelled';
                        $isActive = $currentIndex === $index;
                    @endphp
                    <div class="mb-4 position-relative">
                        <!-- Node Indicator -->
                        <div class="position-absolute rounded-circle d-flex align-items-center justify-content-center text-white {{ $isActive ? 'pulse-dot' : '' }}" 
                             style="left: -32px; top: 0px; width: 30px; height: 30px; background: {{ $isActive ? 'linear-gradient(135deg, #7367f0 0%, #5e50eb 100%)' : ($isPassed ? '#28c76f' : '#334155') }};">
                            <i class="ti {{ $step['Icon'] }} fs-6"></i>
                        </div>
                        <div class="ps-2">
                            <h6 class="fw-bold mb-1 {{ $isActive ? 'step-active' : ($isPassed ? 'step-passed' : 'step-pending') }}">
                                {{ $step['Title'] }}
                                @if($isActive)
                                    <span class="badge bg-label-primary bg-opacity-20 text-primary ms-2 fs-9">Current Status</span>
                                @endif
                            </h6>
                            <p class="step-desc mb-0 small">{{ $step['Desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <div class="rounded-circle bg-danger bg-opacity-10 p-3.5 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
        <i class="ti tabler-alert-circle text-danger fs-1"></i>
    </div>
    <h4 class="fw-bold text-white mb-2">Ticket ID Not Found</h4>
    <p class="text-slate-400 max-w-md mx-auto small">We couldn't locate a repair job matching the code: <strong>{{ request('ticket_id') }}</strong>. Please check the ID on your check-in slip.</p>
</div>
@endif
