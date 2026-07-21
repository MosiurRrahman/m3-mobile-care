@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">My Account Profile</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Account Profile</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Notifications -->
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

    <!-- Profile Info Card & Stats -->
    <div class="col-md-5 mb-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center py-5">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle mb-3 border border-2 border-primary" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-label-primary p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="ti tabler-user" style="font-size: 50px;"></i>
                    </div>
                @endif
                <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
                @php
                    $roleColors = [
                        'super_admin' => 'bg-label-danger',
                        'admin' => 'bg-label-primary',
                        'technician' => 'bg-label-success',
                        'salesman' => 'bg-label-info'
                    ];
                    $roleLabels = [
                        'super_admin' => 'Super Admin (Owner)',
                        'admin' => 'Admin Manager',
                        'technician' => 'Technician',
                        'salesman' => 'Salesman'
                    ];
                @endphp
                <span class="badge {{ $roleColors[$user->role] ?? 'bg-label-secondary' }} px-3 py-1.5 mb-4">{{ $roleLabels[$user->role] ?? ucfirst($user->role) }}</span>

                <div class="row text-start mt-2">
                    <div class="col-12 mb-2 d-flex justify-content-between">
                        <span class="text-muted small fw-semibold">Email:</span>
                        <span class="text-dark small fw-bold">{{ $user->email }}</span>
                    </div>
                    <div class="col-12 mb-2 d-flex justify-content-between">
                        <span class="text-muted small fw-semibold">Phone:</span>
                        <span class="text-dark small fw-bold">{{ $user->phone ?? 'Not set' }}</span>
                    </div>
                    <div class="col-12 mb-2 d-flex justify-content-between">
                        <span class="text-muted small fw-semibold">Branch:</span>
                        <span class="text-dark small fw-bold">{{ $user->branch ?? 'Not set' }}</span>
                    </div>
                    @if($user->role === 'technician')
                        <div class="col-12 mb-2 d-flex justify-content-between">
                            <span class="text-muted small fw-semibold">Skill Level:</span>
                            <span class="text-dark small fw-bold">{{ $user->skill_level ?? 'Basic' }}</span>
                        </div>
                        <div class="col-12 mb-2 d-flex justify-content-between">
                            <span class="text-muted small fw-semibold">Experience:</span>
                            <span class="text-dark small fw-bold">{{ $user->experience ?? 'Not set' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Performance Stats Card -->
        @if($user->role === 'technician' || $user->role === 'salesman')
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body py-4">
                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-20 p-2.5 rounded-circle me-3">
                        @if($user->role === 'technician')
                            <i class="ti tabler-tool text-white fs-4"></i>
                        @else
                            <i class="ti tabler-receipt text-white fs-4"></i>
                        @endif
                    </div>
                    <div>
                        @if($user->role === 'technician')
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['jobs_completed'] }}</h3>
                            <span class="small text-white text-opacity-80">Assigned Jobs Completed</span>
                        @else
                            <h3 class="fw-bold mb-0 text-white">{{ $stats['sales_count'] }}</h3>
                            <span class="small text-white text-opacity-80">Retail Sales Executed</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Edit Profile Card -->
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom bg-transparent py-3">
                <h5 class="fw-bold mb-0 text-dark">Edit Profile Details</h5>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="avatar">Profile Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-dark mb-3">Change Account Password</h6>
                    <p class="text-muted small mb-3">Leave these fields blank if you do not wish to change your current account password.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimum 6 characters">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-type new password">
                    </div>
                </div>
                <div class="card-footer border-top bg-transparent py-3 text-end">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
