@extends('layouts/blankLayout')

@section('title', 'Staff Login - M3 Mobile Care')

@section('content')
<div class="d-flex align-items-center justify-content-center bg-light" style="min-height: 100vh; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="d-block mb-3 text-decoration-none">
                        <img src="{{ asset('assets/img/branding/logo-light-icon.png') }}" alt="M3 Mobile Care Logo" style="height: 60px; width: auto; object-fit: contain;">
                        <div class="mt-2 h3 fw-bold mb-0" style="color: #f37021 !important; font-family: 'Outfit', sans-serif;">M3 MOBILE CARE</div>
                    </a>
                    <p class="text-muted small">Access the repair management dashboard panel</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-4 text-center">Staff Login</h4>


                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="admin@m3mobile.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                    <a href="#" class="text-muted small text-decoration-none">Forgot password?</a>
                                </div>
                                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                            </div>
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted small" for="remember">Remember me on this device</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-2.5 mb-3"><i class="ti tabler-login me-2"></i>Sign In</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 py-2.5"><i class="ti tabler-arrow-left me-2"></i>Back to Homepage</a>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <span class="text-muted small">Default Credentials:</span>
                    <span class="text-muted small d-block">admin@m3mobile.com / admin123</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
