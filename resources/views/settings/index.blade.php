@extends('layouts/contentNavbarLayout')

@section('title', 'Shop Settings - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Header -->
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">Shop Configuration Settings</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop Settings</li>
            </ol>
        </nav>
    </div>

    <!-- Notifications -->
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
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header border-bottom bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark">Invoice & Receipt Configuration</h5>
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

                        <hr class="my-4 text-muted opacity-25">

                        <!-- Footer Terms -->
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="receipt_footer">Invoice Receipt Terms & Policy (Footer)</label>
                            <textarea name="receipt_footer" id="receipt_footer" class="form-control font-monospace text-dark" rows="5" placeholder="Enter warranty terms and pickup guidelines...">{{ old('receipt_footer', $settings['receipt_footer']) }}</textarea>
                            <span class="text-muted small d-block mt-1">These terms will print directly at the bottom of the Customer Invoice and Job Slips.</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top bg-transparent py-3 text-end">
                    <button type="submit" class="btn btn-primary px-4">Save Configuration</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
