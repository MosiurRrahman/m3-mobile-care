@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Product - M3 Mobile Care')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold mb-0">Edit {{ $item->type === 'spare_part' ? 'Spare Part' : 'Accessory' }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ $item->type === 'spare_part' ? route('admin.inventory.parts') : route('admin.inventory.accessories') }}">{{ $item->type === 'spare_part' ? 'Spare Parts' : 'Accessories' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>
    </div>

    <div class="col-12">
        <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column: Product Information & Custom Fields -->
                <div class="col-lg-8">
                    <!-- Card 1: Product Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-info-circle me-2"></i>Product Information</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="supplier_id">Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-select select2">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $item->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="brand">Brand Name</label>
                                    <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $item->brand) }}" placeholder="e.g. Joyroom, Apple, Samsung">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="category_id">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="" disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="sub_category">Sub Category</label>
                                    <input type="text" name="sub_category" id="sub_category" class="form-control" value="{{ old('sub_category', $item->sub_category) }}" placeholder="e.g. Bluetooth Audio">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="barcode">Item Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" value="{{ old('barcode', $item->barcode) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="sku_code">Product SKU (Readonly)</label>
                                    <input type="text" id="sku_code" class="form-control bg-light" value="{{ $item->sku }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-12">
                                    <label class="form-label fw-semibold" for="description">Description</label>
                                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Write specifications, highlights, color choices...">{{ old('description', $item->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Pricing & Stocks -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-report-money me-2"></i>Pricing & Stocks</h5>

                            <div class="row mb-3">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="product_type">Product Type <span class="text-danger">*</span></label>
                                    <select name="product_type" id="product_type" class="form-select" required>
                                        <option value="single" {{ old('product_type', $item->product_type) === 'single' ? 'selected' : '' }}>Single Product</option>
                                        <option value="variable" {{ old('product_type', $item->product_type) === 'variable' ? 'selected' : '' }}>Variable Product</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label fw-semibold" for="purchase_price">Purchase Cost (BDT) <span class="text-danger">*</span></label>
                                    <input type="number" name="purchase_price" id="purchase_price" step="0.01" min="0" class="form-control" value="{{ old('purchase_price', $item->purchase_price) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold" for="alert_quantity">Low Stock Alarm Limit <span class="text-danger">*</span></label>
                                    <input type="number" name="alert_quantity" id="alert_quantity" class="form-control" value="{{ old('alert_quantity', $item->alert_quantity) }}" min="0" required>
                                </div>
                            </div>

                            <!-- Single Product fields -->
                            <div id="single-product-fields">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold" for="quantity">Quantity in Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $item->quantity) }}" min="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="sale_price">Retail Price (BDT) <span class="text-danger">*</span></label>
                                        <input type="number" name="sale_price" id="sale_price" step="0.01" min="0" class="form-control" value="{{ old('sale_price', $item->sale_price) }}">
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label fw-semibold" for="discount_type">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="form-select">
                                            <option value="">No Discount</option>
                                            <option value="flat" {{ old('discount_type', $item->discount_type) === 'flat' ? 'selected' : '' }}>Flat Amount</option>
                                            <option value="percentage" {{ old('discount_type', $item->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold" for="discount_value">Discount Value / Amount</label>
                                        <input type="number" name="discount_value" id="discount_value" step="0.01" min="0" class="form-control" value="{{ old('discount_value', $item->discount_value) }}" placeholder="e.g. 50 BDT or 10%">
                                    </div>
                                </div>
                            </div>

                            <!-- Variable Product fields -->
                            <div id="variable-product-fields" class="d-none">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="variants-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Variation (e.g. Color)</th>
                                                <th>Value (e.g. Red)</th>
                                                <th>SKU</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th style="width: 50px;">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variants-tbody">
                                            <!-- Dynamic rows loaded here via JS -->
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-3" id="add-variant-row">
                                    <i class="ti tabler-plus me-1"></i>Add Variant Value Row
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Column: Images & Custom Fields -->
                <div class="col-lg-4">
                    <!-- Card 3: Product Images -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-photo me-2"></i>Product Gallery</h5>
                            
                            @if(!empty($item->images))
                                <div class="row g-2 mb-3">
                                    @foreach($item->images as $path)
                                        <div class="col-4 position-relative">
                                            <img src="{{ asset('storage/' . $path) }}" class="img-fluid rounded border w-100" style="height: 80px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                <span class="text-muted small d-block mb-3">Uploading new images will overwrite existing gallery.</span>
                            @endif

                            <label class="form-label fw-semibold">Upload New Images</label>
                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                        </div>
                    </div>

                    <!-- Card 4: Custom Fields / Warranties / Dates -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary mb-4"><i class="ti tabler-adjustments me-2"></i>Custom attributes</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="warranties">Warranty Terms</label>
                                <input type="text" name="warranties" id="warranties" class="form-control" value="{{ old('warranties', $item->warranties) }}" placeholder="e.g. 6 Months Replacement">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="manufacturer">Manufacturer</label>
                                <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="{{ old('manufacturer', $item->manufacturer) }}" placeholder="e.g. Joyroom Co. Ltd.">
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold" for="expiry">Expiry / Batch Date</label>
                                <input type="date" name="expiry" id="expiry" class="form-control" value="{{ old('expiry', $item->expiry ? $item->expiry->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <button type="submit" class="btn btn-primary w-100 mb-2 py-2"><i class="ti tabler-device-floppy me-1"></i>Save Changes</button>
                            <a href="{{ $item->type === 'spare_part' ? route('admin.inventory.parts') : route('admin.inventory.accessories') }}" class="btn btn-outline-secondary w-100 py-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productType = document.getElementById('product_type');
        const singleFields = document.getElementById('single-product-fields');
        const variableFields = document.getElementById('variable-product-fields');
        const alertQuantityInput = document.getElementById('alert_quantity');

        function toggleProductType() {
            const singleInputs = singleFields.querySelectorAll('input, select, textarea');
            const variableInputs = variableFields.querySelectorAll('input, select, textarea');

            if (productType.value === 'single') {
                singleFields.classList.remove('d-none');
                variableFields.classList.add('d-none');
                
                // Enable single fields
                singleInputs.forEach(input => {
                    input.disabled = false;
                    if (input.id === 'quantity' || input.id === 'sale_price') {
                        input.required = true;
                    }
                });

                // Disable variable fields
                variableInputs.forEach(input => {
                    input.disabled = true;
                });
            } else {
                singleFields.classList.add('d-none');
                variableFields.classList.remove('d-none');
                
                // Disable single fields
                singleInputs.forEach(input => {
                    input.disabled = true;
                    input.required = false;
                });

                // Enable variable fields
                variableInputs.forEach(input => {
                    input.disabled = false;
                });
            }
        }
        
        productType.addEventListener('change', toggleProductType);

        // Add variant rows
        const variantsTbody = document.getElementById('variants-tbody');
        const addVariantRowBtn = document.getElementById('add-variant-row');
        let variantIndex = 0;

        function addVariantRow(variation = '', val = '', skuVal = '', qty = '0', price = '') {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="text" name="variants[${variantIndex}][variation]" class="form-control form-control-sm" value="${variation}" placeholder="Variation" required>
                </td>
                <td>
                    <input type="text" name="variants[${variantIndex}][value]" class="form-control form-control-sm" value="${val}" placeholder="Value" required>
                </td>
                <td>
                    <input type="text" name="variants[${variantIndex}][sku]" class="form-control form-control-sm" value="${skuVal}" placeholder="SKU" required>
                </td>
                <td>
                    <input type="number" name="variants[${variantIndex}][quantity]" class="form-control form-control-sm" value="${qty}" min="0" required>
                </td>
                <td>
                    <input type="number" name="variants[${variantIndex}][price]" class="form-control form-control-sm" value="${price}" step="0.01" min="0" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger remove-tr-btn"><i class="ti tabler-x"></i></button>
                </td>
            `;
            variantsTbody.appendChild(tr);
            
            tr.querySelector('.remove-tr-btn').addEventListener('click', function() {
                tr.remove();
            });
            
            variantIndex++;
        }

        addVariantRowBtn.addEventListener('click', () => addVariantRow());

        // Load existing variants if any
        const existingVariants = {!! json_encode($item->variants) !!};
        if (existingVariants && existingVariants.length > 0) {
            existingVariants.forEach(v => {
                addVariantRow(v.variation, v.value, v.sku, v.quantity, v.price);
            });
        } else {
            // Seed a default one if none exist
            addVariantRow('Color', 'Default', '{{ $item->sku }}', '{{ $item->quantity }}', '{{ $item->sale_price }}');
        }

        toggleProductType();
    });
</script>
@endsection
