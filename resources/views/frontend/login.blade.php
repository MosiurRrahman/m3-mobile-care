@extends('layouts.frontend')

@section('title', 'Customer Login - M3 Mobile Care')

@section('content')
<!-- BREADCRUMB SECTION START -->
<div class="ul-container">
    <div class="ul-breadcrumb">
        <h2 class="ul-breadcrumb-title">Log In</h2>
        <div class="ul-breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="flaticon-home"></i> Home</a>
            <i class="flaticon-arrow-point-to-right"></i>
            <span class="current-page">Log In</span>
        </div>
    </div>
</div>
<!-- BREADCRUMB SECTION END -->

<div class="ul-container">
    <div class="ul-login">
        <div class="ul-inner-page-container">
            <div class="row justify-content-evenly align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-5">
                    <div class="ul-login-img text-center">
                        <img src="{{ asset('frontend/img/login-img.svg') }}" alt="Login Image">
                    </div>
                </div>

                <div class="col-xl-4 col-md-7">
                    <h3 class="mb-4 text-center fw-bold">Customer Login</h3>

                    @if($errors->any())
                        <div class="alert alert-danger mb-3 p-2 small rounded">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.login.process') }}" method="POST" class="ul-contact-form">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="email" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="position-relative">
                                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-100 mt-2">Log In</button>
                    </form>

                    <p class="text-center mt-4 mb-0">Don't have an account yet? <a href="{{ route('customer.register') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
