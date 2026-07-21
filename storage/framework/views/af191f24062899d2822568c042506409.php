<?php $__env->startSection('title', 'Sales POS Terminal - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<!-- Tom Select CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
.product-out-of-stock {
    opacity: 0.65;
    position: relative;
}
.product-out-of-stock .add-to-cart-btn {
    pointer-events: none;
    background-color: #64748b !important;
    border-color: #64748b !important;
    color: #cbd5e1 !important;
    cursor: not-allowed;
}
.product-out-of-stock-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background-color: #ef4444;
    color: white;
    padding: 3px 8px;
    font-size: 0.7rem;
    font-weight: bold;
    border-radius: 4px;
    z-index: 5;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}
/* Ensure Tom Select fits custom input-group styling */
.ts-wrapper.form-select {
    border-radius: 0 8px 8px 0 !important;
    border-left: 0 !important;
}
.ts-control {
    border: none !important;
    padding: 6px 12px !important;
}
</style>

<div class="row">
    <!-- POS Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Sales POS Terminal</h4>
            <span class="text-muted small">Process instant retail checkout bills for parts and accessories</span>
        </div>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#quickCustomerModal">
            <i class="ti tabler-user-plus me-1"></i>Quick Customer Register
        </button>
    </div>

    <!-- POS Body -->
    <div class="col-lg-7 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-1">
                <h5 class="fw-bold mb-0 text-dark"><i class="ti tabler-search me-2 text-primary"></i>Product Catalog</h5>
            </div>
            
            <!-- Real-time search bar -->
            <div class="card-body">
                <div class="mb-4">
                    <input type="text" id="barcode-search" class="form-control form-control-lg border-primary" placeholder="Scan Barcode or Search by Product SKU/Name..." autofocus>
                    <div class="form-text small text-muted">Pro Tip: Simply scan a barcode or type keywords to instantly add items.</div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-4" id="products-catalog-list" style="max-height: 600px; overflow-y: auto; padding-right: 5px;">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col product-card-wrapper mb-2" data-id="<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>" data-sku="<?php echo e($item->sku); ?>" data-barcode="<?php echo e($item->barcode); ?>" data-price="<?php echo e($item->sale_price); ?>" data-qty="<?php echo e($item->quantity); ?>" data-category="<?php echo e($item->categoryRelation ? $item->categoryRelation->name : $item->category); ?>" data-brand="<?php echo e($item->brand ?: 'Generic'); ?>" data-cost-price="<?php echo e($item->purchase_price); ?>" data-description="<?php echo e($item->description); ?>" data-variants="<?php echo e(json_encode($item->variants)); ?>" data-image="<?php echo e(!empty($item->images) && is_array($item->images) && isset($item->images[0]) ? asset('storage/' . $item->images[0]) : ''); ?>" data-qty-alert="<?php echo e($item->alert_quantity); ?>">
                        <div class="product-pos-card shadow-xs <?php echo e($item->quantity <= 0 ? 'product-out-of-stock' : ''); ?>">
                            <?php if($item->quantity <= 0): ?>
                                <span class="product-out-of-stock-badge">Out of Stock</span>
                            <?php endif; ?>
                            <!-- Floating Quick View Icon on top-right of image/card -->
                            <button class="btn btn-light btn-xs quick-view-btn position-absolute shadow-xs" data-id="<?php echo e($item->id); ?>" style="top: 10px; right: 10px; z-index: 10; width: 32px; height: 32px; border-radius: 50%; padding: 0; background: rgba(255, 255, 255, 0.9); border: 1px solid #eef2f6;" title="Quick View">
                                <i class="ti tabler-eye fs-5 text-dark"></i>
                            </button>

                            <!-- Image Column (Centered, transparent background to blend in) -->
                            <?php if(!empty($item->images) && is_array($item->images) && isset($item->images[0])): ?>
                                <div class="product-image-container mb-3">
                                    <img src="<?php echo e(asset('storage/' . $item->images[0])); ?>" class="w-100 h-100 object-fit-cover" alt="<?php echo e($item->name); ?>">
                                </div>
                            <?php else: ?>
                                <div class="product-image-container mb-3 border bg-light">
                                    <i class="ti tabler-photo fs-2 text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Info Column -->
                            <div class="product-info-container mb-3">
                                <h6 class="fw-bold text-dark mb-1 text-wrap text-start" style="font-size: 0.85rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.3rem;" title="<?php echo e($item->name); ?>"><?php echo e($item->name); ?></h6>
                                <span class="text-muted d-block text-start mb-2" style="font-size: 0.72rem;"><?php echo e($item->sku); ?> · <span class="fw-semibold text-info"><?php echo e(str_replace('_', ' ', ucfirst($item->type))); ?></span></span>
                            </div>
                            
                            <!-- Bottom row -->
                            <div class="d-flex align-items-end justify-content-between">
                                <div class="text-start">
                                    <span class="fw-extrabold text-dark d-block mb-1" style="font-size: 1rem; font-weight: 800;"><?php echo e(number_format($item->sale_price, 2)); ?> BDT</span>
                                    <?php if($item->quantity <= $item->alert_quantity): ?>
                                        <span class="stock-pill-danger"><?php echo e($item->quantity); ?> Piece</span>
                                    <?php else: ?>
                                        <span class="stock-pill-success"><?php echo e($item->quantity); ?> Piece</span>
                                    <?php endif; ?>
                                </div>
                                
                                <button class="btn btn-teal-accent add-to-cart-btn position-relative" data-id="<?php echo e($item->id); ?>" style="width: 40px; height: 40px; border-radius: 10px; padding: 0;">
                                    <i class="ti tabler-shopping-cart fs-4"></i>
                                    <!-- Dynamic Qty Badge -->
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-item-qty-badge d-none" id="qty-badge-<?php echo e($item->id); ?>" style="font-size: 0.65rem; padding: 0.2rem 0.4rem; z-index: 5;">
                                        0
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- POS Cart & Checkout -->
    <div class="col-lg-5 mb-4">
        <div class="card border-0 shadow-sm h-100 d-flex flex-column justify-content-between">
            <div class="card-body pb-2">
                <h5 class="fw-bold mb-4 text-primary"><i class="ti tabler-shopping-cart me-2"></i>Shopping Cart</h5>
                
                <div class="cart-items-wrapper" style="max-height: 380px; overflow-y: auto; padding-right: 5px;" id="cart-container">
                    <div id="empty-cart-row" class="text-center py-5 text-muted">
                        <div class="rounded-circle bg-light d-inline-flex p-3.5 mb-3">
                            <i class="ti tabler-shopping-cart-x fs-1 text-secondary"></i>
                        </div>
                        <h6 class="fw-bold mb-1 text-secondary">Your Cart is Empty</h6>
                        <p class="small mb-0 text-muted px-4">Scan barcodes or add items from the catalog to begin processing the sale invoice.</p>
                    </div>
                    <div id="cart-list" class="d-flex flex-column gap-2.5"></div>
                </div>
            </div>

            <!-- Checkout calculations -->
            <div class="card-footer border-top-0 p-4" style="background: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-2.5">
                    <span class="text-muted fw-semibold" style="font-size: 0.85rem;">Subtotal</span>
                    <span class="fw-bold text-dark" id="summary-subtotal" style="font-size: 0.95rem;">0.00 BDT</span>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label text-muted fw-semibold mb-0" for="pos-discount" style="font-size: 0.85rem;">Apply Discount</label>
                    </div>
                    <div class="input-group input-group-sm shadow-xs">
                        <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #e2e8f0;"><i class="ti tabler-tag" style="font-size: 0.9rem;"></i></span>
                        <input type="number" id="pos-discount" class="form-control form-control-sm text-end border-start-0 ps-0 fw-bold" value="0" min="0" style="font-size: 0.9rem; border-radius: 0 8px 8px 0; border-color: #e2e8f0;">
                    </div>
                </div>

                <div class="p-3 rounded-3 mb-3" style="background: #eefcf4; border-left: 4px solid #00b67a;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-success-emphasis" style="font-size: 0.9rem; color: #007d52 !important;">Total Payable</span>
                        <span class="fw-extrabold text-success" style="font-size: 1.25rem; font-weight: 800; color: #00b67a !important;" id="summary-payable">0.00 BDT</span>
                    </div>
                </div>

                <!-- Split Payment Breakdown -->
                <div class="mb-3.5">
                    <label class="form-label text-muted fw-semibold mb-2" style="font-size: 0.85rem;">Payment Breakdown (স্প্লিট পেমেন্ট)</label>
                    
                    <!-- Cash Input Block -->
                    <div class="p-2 border rounded bg-white mb-2" style="border-radius: 8px;">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-bold text-dark small"><i class="ti tabler-cash text-success me-1"></i>Cash Payment</span>
                            <span class="text-muted small" style="font-size: 0.7rem;">ক্যাশ পেমেন্ট</span>
                        </div>
                        <input type="number" id="pos-cash-amount" class="form-control text-end text-dark fw-bold border-0 bg-light p-2" style="border-radius: 6px; font-size: 0.9rem;" value="0" min="0" placeholder="0">
                    </div>

                    <!-- Dynamic MFS List Container -->
                    <div id="mfs-payments-container" class="d-flex flex-column gap-2 mb-2">
                        <!-- Dynamic payment rows injected here -->
                    </div>

                    <!-- Add MFS dropdown + button -->
                    <div class="input-group input-group-sm">
                        <select id="mfs-method-select" class="form-select border bg-light text-muted fw-semibold" style="border-radius: 6px 0 0 6px; font-size: 0.78rem;">
                            <option value="">+ Add MFS (বিকাশ/নগদ/রকেট)</option>
                            <option value="bKash">bKash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                        <button type="button" id="btn-add-mfs-payment" class="btn btn-success fw-bold px-3" style="border-radius: 0 6px 6px 0;"><i class="ti tabler-plus fs-5"></i></button>
                    </div>
                </div>

                <!-- Cash Given (Only active when Cash Payment > 0) -->
                <div class="mb-3" id="cash-given-group">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label text-muted fw-semibold mb-0" for="pos-cash-given" style="font-size: 0.85rem;">Customer Cash Given</label>
                    </div>
                    <div class="input-group cashier-input-group mb-2">
                        <span class="input-group-text text-muted"><i class="ti tabler-wallet fs-4"></i></span>
                        <input type="number" id="pos-cash-given" class="form-control cashier-input text-end text-dark" value="" min="0" placeholder="0">
                    </div>
                    <!-- Quick Cash Presets -->
                    <div class="d-flex flex-wrap gap-1" id="quick-cash-presets">
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn fw-bold" data-value="exact" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">Exact</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn" data-value="100" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">100 BDT</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn" data-value="200" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">200 BDT</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn" data-value="500" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">500 BDT</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn" data-value="1000" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">1000 BDT</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary cash-preset-btn" data-value="2000" style="font-size: 0.68rem; padding: 3px 8px; border-radius: 6px;">2000 BDT</button>
                    </div>
                </div>

                <!-- Change Return Badge (Only visible when change is > 0) -->
                <div class="d-flex justify-content-between align-items-center mb-3 text-success-emphasis p-2.5 rounded-3 d-none shadow-xs" id="change-return-group" style="background: #eefcf4; border: 1px dashed #00b67a;">
                    <span class="fw-semibold" style="font-size: 0.85rem;"><i class="ti tabler-arrows-left-right me-1 text-success"></i>Change Return</span>
                    <span class="fw-extrabold" id="summary-change" style="font-size: 1.1rem; font-weight: 800; color: #00b67a;">0.00 BDT</span>
                </div>

                <!-- Paid & Due Displays -->
                <div class="d-flex justify-content-between align-items-center mb-1.5 pt-1.5 border-top border-dashed" style="border-color: #e2e8f0 !important;">
                    <span class="fw-semibold text-muted" style="font-size: 0.85rem;">Total Paid (পরিশোধিত)</span>
                    <span class="fw-bold text-dark" id="summary-total-paid" style="font-size: 0.95rem;">0.00 BDT</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-semibold text-muted" style="font-size: 0.85rem;">Remaining Due (বকেয়া)</span>
                    <span class="fw-extrabold text-success" id="summary-due" style="font-size: 1.1rem; font-weight: 800;">0.00 BDT</span>
                </div>

                <!-- Due Alert Notification -->
                <div class="alert alert-warning border-0 p-2.5 mb-3 d-none align-items-center gap-2" id="due-warning-alert" style="font-size: 0.78rem; border-radius: 8px; background-color: #fffbeb; border: 1px solid #fef3c7;">
                    <i class="ti tabler-alert-circle text-warning fs-5"></i>
                    <div class="text-warning-emphasis fw-semibold">
                        Remaining due requires selecting/registering a customer.
                    </div>
                </div>

                <!-- Customer Registry Selection -->
                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold mb-1" for="pos-customer-id" style="font-size: 0.85rem;">Customer</label>
                    <div class="input-group input-group-sm shadow-xs">
                        <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #e2e8f0;"><i class="ti tabler-user" style="font-size: 0.9rem;"></i></span>
                        <select id="pos-customer-id" class="form-select select2 border-start-0 ps-0" style="border-radius: 0 8px 8px 0; border-color: #e2e8f0;">
                            <option value="">Walk-in Customer</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> (<?php echo e($customer->phone); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#quickCustomerModal" class="small text-primary mt-1.5 d-inline-block" style="font-size: 0.75rem; text-decoration: none;">
                        <i class="ti tabler-plus me-0.5"></i>Quick Register New Customer
                    </a>
                </div>

                <button class="btn btn-success btn-lg w-100 py-3 fw-bold" id="checkout-submit-btn" disabled style="border-radius: 12px; font-size: 1rem; box-shadow: 0 4px 14px rgba(40, 199, 111, 0.2); transition: all 0.2s ease;">
                    <i class="ti tabler-credit-card me-2 fs-4"></i>Complete & Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Quick Register Customer -->
<div class="modal fade" id="quickCustomerModal" tabindex="-1" aria-labelledby="quickCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="quickCustomerModalLabel">Quick Customer Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quickCustomerForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qc_name">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" id="qc_name" class="form-control" required placeholder="e.g. Rahim Ali">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="qc_phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" id="qc_phone" class="form-control" required placeholder="e.g. 01712345678">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="qc_address">Address Details</label>
                        <textarea id="qc_address" rows="2" class="form-control" placeholder="e.g. Dhanmondi, Road 12"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register & Select</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Invoice Preview & Confirm -->
<div class="modal fade" id="invoicePreviewModal" tabindex="-1" aria-labelledby="invoicePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="invoicePreviewModalLabel"><i class="ti tabler-receipt me-2 text-primary"></i>Checkout Invoice Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="border border-dark p-3 bg-white rounded-3 small">
                    <!-- Receipt Header -->
                    <div class="text-center mb-3">
                        <h5 class="fw-bold text-dark mb-0.5"><?php echo e(App\Models\Setting::get('shop_name', 'M3 Mobile Care')); ?></h5>
                        <div class="text-muted" style="font-size: 0.75rem;"><?php echo e(App\Models\Setting::get('address', 'Level 3, Multiplan Center, Elephant Road, Dhaka')); ?></div>
                        <div class="text-muted" style="font-size: 0.75rem;">Phone: <?php echo e(App\Models\Setting::get('phone', '+880 1712-345678')); ?> | Email: <?php echo e(App\Models\Setting::get('email', 'info@m3mobilecare.com')); ?></div>
                        <hr class="border-dark my-2.5">
                    </div>

                    <!-- Meta info -->
                    <div class="row g-1 text-dark mb-3" style="font-size: 0.8rem;">
                        <div class="col-6"><strong>Invoice No:</strong> <span class="text-muted">INV-TEMP-XXXX</span></div>
                        <div class="col-6 text-end"><strong>Date:</strong> <span id="preview-invoice-date">-</span></div>
                        <div class="col-12 mt-1"><strong>Customer:</strong> <span id="preview-invoice-customer" class="fw-semibold">Walk-in Customer</span></div>
                    </div>

                    <!-- Items Table -->
                    <table class="table table-sm table-bordered align-middle text-dark mb-3" style="font-size: 0.8rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Item Description</th>
                                <th class="text-center" style="width: 50px;">Qty</th>
                                <th class="text-end" style="width: 80px;">Rate</th>
                                <th class="text-end" style="width: 100px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="preview-invoice-items">
                            <!-- JS populated rows -->
                        </tbody>
                    </table>

                    <!-- Cost Summaries -->
                    <div class="row justify-content-end text-dark" style="font-size: 0.8rem;">
                        <div class="col-7">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted py-0.5">Subtotal:</td>
                                    <td class="text-end fw-bold py-0.5" id="preview-invoice-subtotal">0.00 BDT</td>
                                </tr>
                                <tr id="preview-invoice-discount-row">
                                    <td class="text-muted py-0.5 text-danger">Discount:</td>
                                    <td class="text-end fw-bold py-0.5 text-danger" id="preview-invoice-discount">-0.00 BDT</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold py-0.5">Total Bill:</td>
                                    <td class="text-end fw-extrabold py-0.5" id="preview-invoice-payable">0.00 BDT</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-0.5 text-success">Paid Amount:</td>
                                    <td class="text-end fw-bold py-0.5 text-success" id="preview-invoice-paid">0.00 BDT</td>
                                </tr>
                                <tr id="preview-invoice-cash-given-row" class="d-none">
                                    <td class="text-muted py-0.5">Cash Received:</td>
                                    <td class="text-end fw-semibold py-0.5" id="preview-invoice-cash-given">0.00 BDT</td>
                                </tr>
                                <tr id="preview-invoice-change-row" class="d-none">
                                    <td class="text-muted py-0.5 text-success">Change Returned:</td>
                                    <td class="text-end fw-bold py-0.5 text-success" id="preview-invoice-change">0.00 BDT</td>
                                </tr>
                                <tr class="border-top" id="preview-invoice-due-row">
                                    <td class="fw-bold py-0.5 text-danger">Due Amount:</td>
                                    <td class="text-end fw-extrabold py-0.5 text-danger" id="preview-invoice-due">0.00 BDT</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="ti tabler-edit me-1"></i>Cancel & Edit</button>
                <button type="button" class="btn btn-success fw-bold" id="confirm-checkout-btn"><i class="ti tabler-circle-check me-1"></i>Confirm & Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Product Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-light p-3">
                <h5 class="modal-title fw-bold text-dark" id="quickViewModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Product Image Column -->
                    <div class="col-md-5">
                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center overflow-hidden border border-light" style="height: 280px;">
                            <img id="qv-product-image" src="" alt="Product Image" class="w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                    <!-- Product Details Column -->
                    <div class="col-md-7 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 fw-bold" id="qv-product-brand" style="font-size: 0.75rem;">Brand</span>
                                <span class="badge bg-info bg-opacity-10 text-info px-2.5 py-1.5 fw-bold" id="qv-product-category" style="font-size: 0.75rem;">Category</span>
                            </div>
                            <h4 class="fw-bold text-dark mb-1" id="qv-product-name">Product Name</h4>
                            <p class="text-muted small mb-3" id="qv-product-sku">SKU: N/A</p>
                            
                            <div class="row g-2 mb-3 p-3 bg-light rounded-3">
                                <div class="col-4">
                                    <span class="text-muted small d-block" style="font-size: 0.7rem;">Cost Price</span>
                                    <span class="fw-bold text-secondary" style="font-size: 0.95rem;" id="qv-product-cost-price">0.00 BDT</span>
                                </div>
                                <div class="col-4 border-start ps-3">
                                    <span class="text-muted small d-block" style="font-size: 0.7rem;">Sell Price</span>
                                    <span class="fw-extrabold text-primary" style="font-size: 1.1rem;" id="qv-product-price">0.00 BDT</span>
                                </div>
                                <div class="col-4 border-start ps-3">
                                    <span class="text-muted small d-block" style="font-size: 0.7rem;">Stock Level</span>
                                    <span class="badge bg-success-subtle text-success" id="qv-product-stock">0 Piece</span>
                                </div>
                            </div>

                            <div class="mb-3" id="qv-variants-section">
                                <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;">Available Variations:</h6>
                                <div id="qv-variants-container" class="d-flex flex-wrap gap-2">
                                    <!-- Dynamic variants tags will be loaded here -->
                                </div>
                            </div>
                            
                            <div class="mb-0">
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Description:</h6>
                                <p class="text-muted small mb-0" id="qv-product-desc">No description available for this product.</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top d-flex gap-2">
                            <button type="button" class="btn btn-teal-accent flex-grow-1 py-2 fw-semibold" id="qv-add-to-cart-btn">
                                <i class="ti tabler-shopping-cart me-1"></i>Add To Cart
                            </button>
                            <button type="button" class="btn btn-light py-2 px-4" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles and POS Scripting -->
<style>
.product-pos-card {
    border: 1px solid #eef2f6 !important;
    border-radius: 16px !important;
    background: #ffffff;
    padding: 16px !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    position: relative;
}
.product-pos-card:hover {
    border-color: #7367f0 !important;
    box-shadow: 0 10px 30px rgba(115, 103, 240, 0.08) !important;
    transform: translateY(-4px);
}
.product-image-container {
    background-color: transparent;
    border-radius: 12px;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}
.product-image-container img {
    transition: transform 0.3s ease;
}
.product-pos-card:hover .product-image-container img {
    transform: scale(1.06);
}
.btn-teal-accent {
    background-color: #00b67a;
    color: #ffffff;
    border: none;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-teal-accent:hover {
    background-color: #009b68;
    color: #ffffff;
    transform: scale(1.08);
}
.stock-pill-success {
    background-color: #e6f7f0 !important;
    color: #00b67a !important;
    border-radius: 20px;
    padding: 0.2rem 0.6rem;
    font-size: 0.72rem;
    font-weight: 600;
    display: inline-block;
}
.stock-pill-danger {
    background-color: #ffebe8 !important;
    color: #ff4d4f !important;
    border-radius: 20px;
    padding: 0.2rem 0.6rem;
    font-size: 0.72rem;
    font-weight: 600;
    display: inline-block;
}
.hover-border-primary:hover {
    border-color: #7367f0 !important;
    box-shadow: 0 4px 12px rgba(115, 103, 240, 0.1) !important;
    transform: translateY(-2px);
}
.transition-all {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}
#products-catalog-list::-webkit-scrollbar {
    width: 6px;
}
#products-catalog-list::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.15);
    border-radius: 4px;
}
#products-catalog-list::-webkit-scrollbar-track {
    background: transparent;
}
/* Custom Payment Method Radio Button Cards */
#pay-cash:checked + .payment-method-card {
    border-color: #2e7d32 !important;
    background-color: rgba(46, 125, 50, 0.08) !important;
    color: #2e7d32 !important;
    box-shadow: 0 4px 12px rgba(46, 125, 50, 0.12);
}
#pay-bkash:checked + .payment-method-card {
    border-color: #d81b60 !important;
    background-color: rgba(216, 27, 96, 0.08) !important;
    color: #d81b60 !important;
    box-shadow: 0 4px 12px rgba(216, 27, 96, 0.12);
}
#pay-card:checked + .payment-method-card {
    border-color: #1565c0 !important;
    background-color: rgba(21, 101, 192, 0.08) !important;
    color: #1565c0 !important;
    box-shadow: 0 4px 12px rgba(21, 101, 192, 0.12);
}
.payment-method-card {
    border: 1px solid #e2e8f0;
    color: #64748b;
    transition: all 0.2s ease;
    cursor: pointer;
    background-color: #ffffff;
}
.payment-method-card:hover {
    border-color: #cbd5e1;
    background-color: #f8fafc;
}
/* Premium Search Input */
#barcode-search {
    border: 2px solid #7367f0 !important;
    border-radius: 12px !important;
    font-size: 0.95rem;
    padding: 12px 20px !important;
    box-shadow: 0 4px 15px rgba(115, 103, 240, 0.05) !important;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1) !important;
}
#barcode-search:focus {
    box-shadow: 0 6px 20px rgba(115, 103, 240, 0.15) !important;
    transform: scale(1.008);
}
/* Premium Large Inputs for Cashier */
.cashier-input-group {
    border-radius: 12px !important;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    border: 2px solid #cbd5e1 !important;
    transition: all 0.2s ease;
    background-color: #ffffff;
}
.cashier-input-group:focus-within {
    border-color: #7367f0 !important;
    box-shadow: 0 4px 15px rgba(115, 103, 240, 0.12) !important;
}
.cashier-input-group .input-group-text {
    border: none !important;
    background-color: #f8fafc !important;
    padding-left: 14px !important;
    padding-right: 14px !important;
}
.cashier-input {
    border: none !important;
    font-size: 1.25rem !important;
    font-weight: 800 !important;
    padding: 10px 14px !important;
    height: 48px !important;
}
.cashier-input:focus {
    box-shadow: none !important;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cart = [];
        
        // DOM Nodes
        const barcodeSearch = document.getElementById('barcode-search');
        const catalogList = document.getElementById('products-catalog-list');
        const cartContainer = document.getElementById('cart-container');
        const cartList = document.getElementById('cart-list');
        const emptyCartRow = document.getElementById('empty-cart-row');
        const subtotalLabel = document.getElementById('summary-subtotal');
        const payableLabel = document.getElementById('summary-payable');
        const discountInput = document.getElementById('pos-discount');
        const cashInput = document.getElementById('pos-cash-amount');
        const mfsContainer = document.getElementById('mfs-payments-container');
        const mfsMethodSelect = document.getElementById('mfs-method-select');
        const btnAddMfsPayment = document.getElementById('btn-add-mfs-payment');
        const totalPaidDisplay = document.getElementById('summary-total-paid');
        const dueLabel = document.getElementById('summary-due');
        const customerSelect = document.getElementById('pos-customer-id');
        let tomSelectCustomer = null;
        if (customerSelect) {
            tomSelectCustomer = new TomSelect(customerSelect, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Search customer by name or phone..."
            });
            
            tomSelectCustomer.on('change', function() {
                let subtotal = 0;
                cart.forEach(item => subtotal += item.price * item.qty);
                const discount = parseFloat(discountInput.value) || 0;
                const payable = Math.max(0, subtotal - discount);
                updateDue(payable);
            });
        }
        const checkoutBtn = document.getElementById('checkout-submit-btn');
        const confirmCheckoutBtn = document.getElementById('confirm-checkout-btn');
        const cashGivenInput = document.getElementById('pos-cash-given');
        const changeLabel = document.getElementById('summary-change');
        const changeGroup = document.getElementById('change-return-group');
        const cashGivenGroup = document.getElementById('cash-given-group');
        let isPaidManuallyEdited = false;

        // Search and Barcode Scanner Simulation
        barcodeSearch.addEventListener('input', function(e) {
            const query = e.target.value.trim().toLowerCase();
            if (query.length === 0) {
                showAllProducts();
                return;
            }
            
            // Check exact barcode match first
            let exactMatchFound = false;
            document.querySelectorAll('.product-card-wrapper').forEach(wrapper => {
                const barcode = wrapper.getAttribute('data-barcode').toLowerCase();
                const sku = wrapper.getAttribute('data-sku').toLowerCase();
                
                if (barcode === query || sku === query) {
                    exactMatchFound = true;
                    addToCart(wrapper.getAttribute('data-id'));
                    barcodeSearch.value = ''; // Reset scanner
                }
            });

            if (exactMatchFound) {
                showAllProducts();
                return;
            }

            // Normal text filtering of catalog
            document.querySelectorAll('.product-card-wrapper').forEach(wrapper => {
                const name = wrapper.getAttribute('data-name').toLowerCase();
                const sku = wrapper.getAttribute('data-sku').toLowerCase();
                
                if (name.includes(query) || sku.includes(query)) {
                    wrapper.classList.remove('d-none');
                } else {
                    wrapper.classList.add('d-none');
                }
            });
        });

        function showAllProducts() {
            document.querySelectorAll('.product-card-wrapper').forEach(wrapper => {
                wrapper.classList.remove('d-none');
            });
        }

        // Add to cart and Quick View click
        catalogList.addEventListener('click', function(e) {
            if (e.target.closest('.add-to-cart-btn')) {
                const btn = e.target.closest('.add-to-cart-btn');
                const id = btn.getAttribute('data-id');
                addToCart(id);
            } else if (e.target.closest('.quick-view-btn')) {
                const btn = e.target.closest('.quick-view-btn');
                const id = btn.getAttribute('data-id');
                openQuickView(id);
            }
        });

        // Quick View Modal Controller
        const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
        
        function openQuickView(id) {
            const card = document.querySelector(`.product-card-wrapper[data-id="${id}"]`);
            if (!card) return;

            const name = card.getAttribute('data-name');
            const sku = card.getAttribute('data-sku');
            const price = parseFloat(card.getAttribute('data-price'));
            const qty = parseInt(card.getAttribute('data-qty'));
            const category = card.getAttribute('data-category') || 'N/A';
            const brand = card.getAttribute('data-brand') || 'N/A';
            const costPrice = parseFloat(card.getAttribute('data-cost-price')) || 0;
            const description = card.getAttribute('data-description') || 'No description available for this product.';
            const image = card.getAttribute('data-image');
            const variantsRaw = card.getAttribute('data-variants');

            // Populate text/image fields
            document.getElementById('qv-product-name').innerText = name;
            document.getElementById('qv-product-sku').innerText = 'SKU: ' + sku;
            document.getElementById('qv-product-brand').innerText = 'Brand: ' + brand;
            document.getElementById('qv-product-category').innerText = 'Category: ' + category;
            document.getElementById('qv-product-cost-price').innerText = costPrice.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            document.getElementById('qv-product-price').innerText = price.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            document.getElementById('qv-product-stock').innerText = qty + ' Piece';
            document.getElementById('qv-product-desc').innerText = description || 'No description available for this product.';
            
            const qvImage = document.getElementById('qv-product-image');
            if (image) {
                qvImage.src = image;
                qvImage.parentElement.classList.remove('d-none');
            } else {
                qvImage.src = '';
                qvImage.parentElement.classList.add('d-none');
            }

            // Set stock class based on low stock limit
            const alertQty = parseInt(card.getAttribute('data-qty-alert')) || 5;
            const stockBadge = document.getElementById('qv-product-stock');
            if (qty <= alertQty) {
                stockBadge.className = 'badge bg-danger-subtle text-danger';
            } else {
                stockBadge.className = 'badge bg-success-subtle text-success';
            }

            // Populate variants section
            const variantsContainer = document.getElementById('qv-variants-container');
            const variantsSection = document.getElementById('qv-variants-section');
            variantsContainer.innerHTML = '';
            
            let variants = [];
            try {
                if (variantsRaw) {
                    variants = JSON.parse(variantsRaw);
                }
            } catch (e) {
                console.error("Error parsing product variants json", e);
            }

            if (variants && variants.length > 0) {
                variantsSection.classList.remove('d-none');
                variants.forEach(v => {
                    const span = document.createElement('span');
                    span.className = 'badge bg-light text-dark border px-2.5 py-1.5 fw-semibold';
                    span.style.fontSize = '0.75rem';
                    span.innerText = `${v.variation}: ${v.value} (${v.quantity} pcs · ${parseFloat(v.price).toLocaleString()} BDT)`;
                    variantsContainer.appendChild(span);
                });
            } else {
                variantsSection.classList.add('d-none');
            }

            // Map Add to Cart button in Modal
            const modalAddBtn = document.getElementById('qv-add-to-cart-btn');
            modalAddBtn.onclick = function() {
                addToCart(id);
                quickViewModal.hide();
            };

            // Show Modal
            quickViewModal.show();
        }

        // Main Add To Cart function
        function addToCart(id) {
            const card = document.querySelector(`.product-card-wrapper[data-id="${id}"]`);
            if (!card) return;

            const name = card.getAttribute('data-name');
            const price = parseFloat(card.getAttribute('data-price'));
            const maxQty = parseInt(card.getAttribute('data-qty'));

            // Check if already in cart
            const existing = cart.find(item => item.id === id);
            if (existing) {
                if (existing.qty >= maxQty) {
                    alert(`Insufficient stock! Only ${maxQty} units of ${name} are available.`);
                    return;
                }
                existing.qty++;
            } else {
                if (maxQty < 1) {
                    alert(`Insufficient stock! ${name} is out of stock.`);
                    return;
                }
                cart.push({ id, name, price, qty: 1, maxQty });
            }

            renderCart();
        }

        // Render shopping cart
        function renderCart() {
            cartList.innerHTML = '';

            if (cart.length === 0) {
                emptyCartRow.classList.remove('d-none');
                checkoutBtn.disabled = true;
                subtotalLabel.innerText = '0.00 BDT';
                payableLabel.innerText = '0.00 BDT';
                cashInput.value = 0;
                bkashInput.value = 0;
                nagadInput.value = 0;
                rocketInput.value = 0;
                totalPaidDisplay.innerText = '0.00 BDT';
                cashGivenInput.value = '';
                changeGroup.classList.add('d-none');
                changeLabel.innerText = '0.00 BDT';
                dueLabel.innerText = '0.00 BDT';
                dueLabel.className = 'fw-bold text-success';
                isPaidManuallyEdited = false;
                
                updateCatalogQtyBadges();
                return;
            }

            emptyCartRow.classList.add('d-none');
            checkoutBtn.disabled = false;

            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between transition-all hover-shadow';
                itemDiv.innerHTML = `
                    <div class="d-flex align-items-center gap-2.5" style="max-width: 55%;">
                        <div class="rounded bg-primary bg-opacity-10 p-2 text-primary d-none d-sm-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                            <i class="ti tabler-package fs-4"></i>
                        </div>
                        <div class="text-truncate">
                            <h6 class="fw-bold text-dark mb-0.5 text-truncate" style="font-size: 0.85rem;" title="${item.name}">${item.name}</h6>
                            <span class="text-muted small" style="font-size: 0.75rem;">${item.price.toLocaleString('en-US', {minimumFractionDigits: 2})} BDT</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Custom quantity controller -->
                        <div class="input-group input-group-sm" style="width: 95px;">
                            <button class="btn btn-outline-secondary px-2 dec-qty-btn" type="button" data-id="${item.id}"><i class="ti tabler-minus fs-7" style="pointer-events: none;"></i></button>
                            <input type="number" class="form-control text-center cart-qty-input px-1" data-id="${item.id}" value="${item.qty}" min="1" max="${item.maxQty}">
                            <button class="btn btn-outline-secondary px-2 inc-qty-btn" type="button" data-id="${item.id}"><i class="ti tabler-plus fs-7" style="pointer-events: none;"></i></button>
                        </div>
                        
                        <!-- Item subtotal and remove -->
                        <div class="text-end" style="min-width: 85px;">
                            <span class="fw-bold text-dark d-block" style="font-size: 0.8rem;">${itemTotal.toLocaleString('en-US', {minimumFractionDigits: 2})} BDT</span>
                            <button class="btn btn-link btn-xs text-danger p-0 mt-0.5 remove-cart-item" data-id="${item.id}" style="font-size: 0.7rem; text-decoration: none;">
                                <i class="ti tabler-trash me-0.5"></i>Remove
                            </button>
                        </div>
                    </div>
                `;
                cartList.appendChild(itemDiv);
            });

            // Update calculations
            subtotalLabel.innerText = subtotal.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            
            updatePayable(subtotal);
            updateCatalogQtyBadges();
        }

        function updateCatalogQtyBadges() {
            // Hide and reset all quantity badges in catalog first
            document.querySelectorAll('.cart-item-qty-badge').forEach(badge => {
                badge.innerText = '0';
                badge.classList.add('d-none');
            });

            // Show badges only for items inside the cart
            cart.forEach(item => {
                const badge = document.getElementById('qty-badge-' + item.id);
                if (badge) {
                    badge.innerText = item.qty;
                    badge.classList.remove('d-none');
                }
            });
        }

        function getMfsAmount(method) {
            const row = document.querySelector(`.mfs-payment-row[data-method="${method}"]`);
            if (!row) return 0;
            const input = row.querySelector('.mfs-amount-input');
            return parseFloat(input.value) || 0;
        }

        function setMfsAmount(method, value) {
            const row = document.querySelector(`.mfs-payment-row[data-method="${method}"]`);
            if (row) {
                const input = row.querySelector('.mfs-amount-input');
                input.value = value;
            }
        }

        function getMfsRef(method) {
            const row = document.querySelector(`.mfs-payment-row[data-method="${method}"]`);
            if (!row) return '';
            const input = row.querySelector('.mfs-ref-input');
            return input.value.trim();
        }

        function updatePayable(subtotal) {
            const discount = parseFloat(discountInput.value) || 0;
            const payable = Math.max(0, subtotal - discount);
            payableLabel.innerText = payable.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            
            if (!isPaidManuallyEdited) {
                cashInput.value = payable;
                mfsContainer.innerHTML = '';
            }
            
            if (parseFloat(cashInput.value) > 0 && cashGivenInput.value !== '') {
                calculateCashChange();
            } else {
                updateDue(payable);
            }
        }

        function updateDue(payable) {
            const cashVal = parseFloat(cashInput.value) || 0;
            let mfsVal = 0;
            document.querySelectorAll('.mfs-amount-input').forEach(input => {
                mfsVal += parseFloat(input.value) || 0;
            });
            const paid = cashVal + mfsVal;

            totalPaidDisplay.innerText = paid.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            const due = Math.max(0, payable - paid);
            dueLabel.innerText = due.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
            
            const dueWarningAlert = document.getElementById('due-warning-alert');
            const customerId = customerSelect.value;

            if (due > 0) {
                dueLabel.className = 'fw-bold text-danger';
                if (!customerId) {
                    dueWarningAlert.classList.remove('d-none');
                    dueWarningAlert.classList.add('d-flex');
                } else {
                    dueWarningAlert.classList.add('d-none');
                    dueWarningAlert.classList.remove('d-flex');
                }
            } else {
                dueLabel.className = 'fw-bold text-success';
                dueWarningAlert.classList.add('d-none');
                dueWarningAlert.classList.remove('d-flex');
            }
        }

        // Discount changes
        discountInput.addEventListener('input', function() {
            let subtotal = 0;
            cart.forEach(item => subtotal += item.price * item.qty);
            updatePayable(subtotal);
        });

        // Cash Input Changes
        if (cashInput) {
            cashInput.addEventListener('input', function() {
                isPaidManuallyEdited = true;
                let subtotal = 0;
                cart.forEach(item => subtotal += item.price * item.qty);
                const discount = parseFloat(discountInput.value) || 0;
                const payable = Math.max(0, subtotal - discount);
                
                const cashVal = parseFloat(cashInput.value) || 0;
                let mfsVal = 0;
                document.querySelectorAll('.mfs-amount-input').forEach(input => {
                    mfsVal += parseFloat(input.value) || 0;
                });
                const totalPaid = cashVal + mfsVal;

                if (totalPaid > payable) {
                    this.value = Math.max(0, payable - mfsVal);
                }

                // Toggle Customer Cash Given panel based on Cash input value
                if (parseFloat(cashInput.value) > 0) {
                    cashGivenGroup.classList.remove('d-none');
                    calculateCashChange();
                } else {
                    cashGivenGroup.classList.add('d-none');
                    cashGivenInput.value = '';
                    changeGroup.classList.add('d-none');
                    changeLabel.innerText = '0.00 BDT';
                    updateDue(payable);
                }
            });
        }

        // Dynamic MFS Payment Adding
        btnAddMfsPayment.addEventListener('click', function() {
            const method = mfsMethodSelect.value;
            if (!method) return;

            // Check if already added
            if (document.querySelector(`.mfs-payment-row[data-method="${method}"]`)) {
                alert(`${method} payment field is already added.`);
                mfsMethodSelect.value = '';
                return;
            }

            let borderClass = 'border-primary';
            let iconColor = 'text-primary';
            if (method === 'bKash') {
                borderClass = 'border-pink';
                iconColor = 'text-pink';
            } else if (method === 'Nagad') {
                borderClass = 'border-warning';
                iconColor = 'text-warning';
            } else if (method === 'Rocket') {
                borderClass = 'border-purple';
                iconColor = 'text-purple';
            }

            // Create row
            const row = document.createElement('div');
            row.className = `mfs-payment-row p-2 border rounded bg-white shadow-xs d-flex flex-column gap-1.5 border-start border-3 ${borderClass}`;
            row.setAttribute('data-method', method);
            
            // Inline style helper to fix color codes
            let inlineStyle = '';
            if (method === 'bKash') {
                inlineStyle = 'border-left-color: #d81b60 !important;';
            } else if (method === 'Nagad') {
                inlineStyle = 'border-left-color: #f39c12 !important;';
            } else if (method === 'Rocket') {
                inlineStyle = 'border-left-color: #8e44ad !important;';
            }
            if (inlineStyle) {
                row.setAttribute('style', inlineStyle);
            }

            let textClassStyle = '';
            if (method === 'bKash') {
                textClassStyle = 'color: #d81b60 !important;';
            } else if (method === 'Nagad') {
                textClassStyle = 'color: #f39c12 !important;';
            } else if (method === 'Rocket') {
                textClassStyle = 'color: #8e44ad !important;';
            }

            row.innerHTML = `
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold small" style="${textClassStyle}"><i class="ti tabler-wallet me-1"></i>${method} Payment</span>
                    <button type="button" class="btn btn-link btn-xs text-danger p-0 border-0 remove-mfs-btn" style="line-height: 1;"><i class="ti tabler-trash fs-5"></i></button>
                </div>
                <div class="row g-1">
                    <div class="col-6">
                        <input type="number" class="form-control form-control-sm text-end fw-bold mfs-amount-input border-0 bg-light p-1.5" placeholder="Amount (৳)" min="0" step="0.01" style="font-size: 0.85rem; border-radius: 6px;">
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control form-control-sm mfs-ref-input border-0 bg-light p-1.5" placeholder="Number / Txn ID" style="font-size: 0.78rem; border-radius: 6px;">
                    </div>
                </div>
            `;

            mfsContainer.appendChild(row);
            mfsMethodSelect.value = '';

            // Focus on amount input
            row.querySelector('.mfs-amount-input').focus();

            // Bind listeners for dynamic inputs
            const amountInput = row.querySelector('.mfs-amount-input');
            amountInput.addEventListener('input', function() {
                isPaidManuallyEdited = true;
                
                let subtotal = 0;
                cart.forEach(item => subtotal += item.price * item.qty);
                const discount = parseFloat(discountInput.value) || 0;
                const payable = Math.max(0, subtotal - discount);

                // Re-calculate sum of all payments
                const cashVal = parseFloat(cashInput.value) || 0;
                let otherMfsTotal = 0;
                document.querySelectorAll('.mfs-amount-input').forEach(otherInput => {
                    if (otherInput !== this) {
                        otherMfsTotal += parseFloat(otherInput.value) || 0;
                    }
                });

                const maxAllowedForThis = Math.max(0, payable - (cashVal + otherMfsTotal));
                if (parseFloat(this.value) > maxAllowedForThis) {
                    this.value = maxAllowedForThis;
                }

                updateDue(payable);
            });

            // Bind remove button
            row.querySelector('.remove-mfs-btn').addEventListener('click', function() {
                row.remove();
                let subtotal = 0;
                cart.forEach(item => subtotal += item.price * item.qty);
                const discount = parseFloat(discountInput.value) || 0;
                const payable = Math.max(0, subtotal - discount);
                updateDue(payable);
            });

            // Re-run due calculations
            let subtotal = 0;
            cart.forEach(item => subtotal += item.price * item.qty);
            const discount = parseFloat(discountInput.value) || 0;
            const payable = Math.max(0, subtotal - discount);
            
            // Automatically allocate remaining due to the newly added MFS
            const cashVal = parseFloat(cashInput.value) || 0;
            let mfsTotal = 0;
            document.querySelectorAll('.mfs-amount-input').forEach(otherInput => {
                mfsTotal += parseFloat(otherInput.value) || 0;
            });
            const remaining = Math.max(0, payable - (cashVal + mfsTotal));
            if (remaining > 0) {
                amountInput.value = remaining;
            } else {
                amountInput.value = 0;
            }

            updateDue(payable);
        });

        // Cash Given changes
        if (cashGivenInput) {
            cashGivenInput.addEventListener('input', function() {
                calculateCashChange();
            });
        }

        function calculateCashChange() {
            let subtotal = 0;
            cart.forEach(item => subtotal += item.price * item.qty);
            const discount = parseFloat(discountInput.value) || 0;
            const payable = Math.max(0, subtotal - discount);

            const cashPayment = parseFloat(cashInput.value) || 0;
            const cashGiven = parseFloat(cashGivenInput.value) || 0;
            
            if (cashGivenInput.value === '') {
                changeGroup.classList.add('d-none');
                changeLabel.innerText = '0.00 BDT';
                updateDue(payable);
                return;
            }

            if (cashGiven >= cashPayment) {
                const change = cashGiven - cashPayment;
                changeLabel.innerText = change.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' BDT';
                changeGroup.classList.remove('d-none');
            } else {
                changeGroup.classList.add('d-none');
                changeLabel.innerText = '0.00 BDT';
            }

            updateDue(payable);
        }

        // Handle Cash Preset buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('cash-preset-btn')) {
                const cashPayment = parseFloat(cashInput.value) || 0;
                const val = e.target.getAttribute('data-value');
                if (val === 'exact') {
                    cashGivenInput.value = cashPayment;
                } else {
                    cashGivenInput.value = parseFloat(val);
                }
                calculateCashChange();
            }
        });

        // Cart Actions (Quantity change, Increment, Decrement, or Remove)
        cartContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('cart-qty-input')) {
                const input = e.target;
                const id = input.getAttribute('data-id');
                let newQty = parseInt(input.value) || 1;
                
                const item = cart.find(item => item.id === id);
                if (item) {
                    if (newQty > item.maxQty) {
                        alert(`Only ${item.maxQty} units in stock!`);
                        newQty = item.maxQty;
                        input.value = newQty;
                    }
                    item.qty = newQty;
                    renderCart();
                }
            }
        });

        cartContainer.addEventListener('click', function(e) {
            // Remove item
            if (e.target.closest('.remove-cart-item')) {
                const btn = e.target.closest('.remove-cart-item');
                const id = btn.getAttribute('data-id');
                const index = cart.findIndex(item => item.id === id);
                if (index !== -1) {
                    cart.splice(index, 1);
                    renderCart();
                }
                return;
            }

            // Increment quantity
            if (e.target.closest('.inc-qty-btn')) {
                const btn = e.target.closest('.inc-qty-btn');
                const id = btn.getAttribute('data-id');
                const item = cart.find(item => item.id === id);
                if (item) {
                    if (item.qty >= item.maxQty) {
                        alert(`Only ${item.maxQty} units in stock!`);
                        return;
                    }
                    item.qty++;
                    renderCart();
                }
                return;
            }

            // Decrement quantity
            if (e.target.closest('.dec-qty-btn')) {
                const btn = e.target.closest('.dec-qty-btn');
                const id = btn.getAttribute('data-id');
                const item = cart.find(item => item.id === id);
                if (item) {
                    if (item.qty > 1) {
                        item.qty--;
                        renderCart();
                    }
                }
                return;
            }
        });

        // Quick register customer form submission (AJAX)
        document.getElementById('quickCustomerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('qc_name').value;
            const phone = document.getElementById('qc_phone').value;
            const address = document.getElementById('qc_address').value;

            fetch('<?php echo e(route("admin.customers.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, phone, address })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (tomSelectCustomer) {
                        tomSelectCustomer.addOption({
                            value: data.customer.id,
                            text: `${data.customer.name} (${data.customer.phone})`
                        });
                        tomSelectCustomer.setValue(data.customer.id);
                    } else {
                        const opt = document.createElement('option');
                        opt.value = data.customer.id;
                        opt.innerText = `${data.customer.name} (${data.customer.phone})`;
                        opt.selected = true;
                        customerSelect.appendChild(opt);
                    }
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('quickCustomerModal'));
                    modal.hide();
                    document.getElementById('quickCustomerForm').reset();
                    alert('Customer registered and selected successfully!');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Failed to register customer. Check inputs.');
            });
        });

        // Checkout Preview (Modal Trigger)
        checkoutBtn.addEventListener('click', function() {
            if (cart.length === 0) return;

            // Check if there is a due and no customer is selected
            const customerId = customerSelect.value;
            let subtotalVal = 0;
            cart.forEach(item => subtotalVal += item.price * item.qty);
            const discountVal = parseFloat(discountInput.value) || 0;
            const payableVal = Math.max(0, subtotalVal - discountVal);
            
            const cashVal = parseFloat(cashInput.value) || 0;
            const bkashVal = getMfsAmount('bKash');
            const nagadVal = getMfsAmount('Nagad');
            const rocketVal = getMfsAmount('Rocket');
            const paidVal = cashVal + bkashVal + nagadVal + rocketVal;
            const dueVal = Math.max(0, payableVal - paidVal);

            if (dueVal > 0 && !customerId) {
                alert('A registered customer is required to record a remaining due balance. Please select or register a customer first.');
                return;
            }

            // Populate Modal Meta Info
            document.getElementById('preview-invoice-date').innerText = new Date().toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });

            const customerName = customerSelect.options[customerSelect.selectedIndex].text;
            document.getElementById('preview-invoice-customer').innerText = customerSelect.value ? customerName : 'Walk-in Customer (Guest)';

            // Populate Modal Items
            const previewItemsContainer = document.getElementById('preview-invoice-items');
            previewItemsContainer.innerHTML = '';
            
            let subtotal = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><span class="fw-bold">${item.name}</span></td>
                    <td class="text-center">${item.qty}</td>
                    <td class="text-end">${item.price.toFixed(2)}</td>
                    <td class="text-end fw-semibold">${itemTotal.toFixed(2)} BDT</td>
                `;
                previewItemsContainer.appendChild(tr);
            });

            // Populate Modal Summaries
            const discount = parseFloat(discountInput.value) || 0;
            const payable = Math.max(0, subtotal - discount);
            const paid = paidVal;
            const due = dueVal;

            document.getElementById('preview-invoice-subtotal').innerText = subtotal.toFixed(2) + ' BDT';
            
            const discountRow = document.getElementById('preview-invoice-discount-row');
            if (discount > 0) {
                discountRow.style.display = '';
                document.getElementById('preview-invoice-discount').innerText = '-' + discount.toFixed(2) + ' BDT';
            } else {
                discountRow.style.display = 'none';
            }

            document.getElementById('preview-invoice-payable').innerText = payable.toFixed(2) + ' BDT';
            document.getElementById('preview-invoice-paid').innerText = paid.toFixed(2) + ' BDT';
            
            // Cash Given and Change returned in preview
            const cashGivenRow = document.getElementById('preview-invoice-cash-given-row');
            const changeRow = document.getElementById('preview-invoice-change-row');
            const cashGivenVal = parseFloat(cashGivenInput.value) || 0;
            
            if (cashVal > 0 && cashGivenVal > 0) {
                cashGivenRow.classList.remove('d-none');
                document.getElementById('preview-invoice-cash-given').innerText = cashGivenVal.toFixed(2) + ' BDT';
                
                if (cashGivenVal > cashVal) {
                    changeRow.classList.remove('d-none');
                    document.getElementById('preview-invoice-change').innerText = (cashGivenVal - cashVal).toFixed(2) + ' BDT';
                } else {
                    changeRow.classList.add('d-none');
                }
            } else {
                cashGivenRow.classList.add('d-none');
                changeRow.classList.add('d-none');
            }

            const dueRow = document.getElementById('preview-invoice-due-row');
            const dueLabel = document.getElementById('preview-invoice-due');
            dueLabel.innerText = due.toFixed(2) + ' BDT';
            if (due > 0) {
                dueRow.className = 'border-top table-danger';
            } else {
                dueRow.className = 'border-top';
            }

            // Open Modal
            let previewModal = bootstrap.Modal.getInstance(document.getElementById('invoicePreviewModal'));
            if (!previewModal) {
                previewModal = new bootstrap.Modal(document.getElementById('invoicePreviewModal'));
            }
            previewModal.show();
        });

        // Confirm Checkout & Save to DB
        confirmCheckoutBtn.addEventListener('click', function() {
            if (cart.length === 0) return;

            const customerId = customerSelect.value;
            const discount = parseFloat(discountInput.value) || 0;

            const cashVal = parseFloat(cashInput.value) || 0;
            const bkashVal = getMfsAmount('bKash');
            const nagadVal = getMfsAmount('Nagad');
            const rocketVal = getMfsAmount('Rocket');
            const paidAmount = cashVal + bkashVal + nagadVal + rocketVal;

            // Re-calculate payable and due to ensure safety
            let subtotalVal2 = 0;
            cart.forEach(item => subtotalVal2 += item.price * item.qty);
            const payableVal2 = Math.max(0, subtotalVal2 - discount);
            const dueVal2 = Math.max(0, payableVal2 - paidAmount);

            if (dueVal2 > 0 && !customerId) {
                alert('A registered customer is required to record a remaining due balance. Please select or register a customer first.');
                confirmCheckoutBtn.disabled = false;
                return;
            }

            const cashReceived = parseFloat(cashGivenInput.value) || cashVal;
            const changeReturned = (cashVal > 0 && cashReceived > cashVal) ? (cashReceived - cashVal) : 0;

            confirmCheckoutBtn.disabled = true;

            fetch('<?php echo e(route("admin.pos.checkout")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    customer_id: customerId,
                    discount: discount,
                    cash_amount: cashVal,
                    bkash_amount: bkashVal,
                    nagad_amount: nagadVal,
                    rocket_amount: rocketVal,
                    bkash_ref: getMfsRef('bKash'),
                    nagad_ref: getMfsRef('Nagad'),
                    rocket_ref: getMfsRef('Rocket'),
                    cash_received: cashReceived,
                    change_returned: changeReturned,
                    cart: cart.map(item => ({ id: item.id, qty: item.qty }))
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Close Modal
                    const previewModal = bootstrap.Modal.getInstance(document.getElementById('invoicePreviewModal'));
                    if (previewModal) {
                        previewModal.hide();
                    }

                    alert('Checkout processed successfully! Opening invoice ticket...');
                    
                    // Open invoice printable in new tab
                    window.open(`/admin/pos/invoice/${data.sale_id}`, '_blank');
                    
                    // Reset POS
                    cart.length = 0;
                    discountInput.value = 0;
                    if (tomSelectCustomer) {
                        tomSelectCustomer.setValue('');
                    } else {
                        customerSelect.value = '';
                    }
                    renderCart();
                    
                    // Reload window to update stock displays
                    window.location.reload();
                } else {
                    alert('Checkout failed: ' + data.message);
                    confirmCheckoutBtn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Fatal checkout processing error. Check server logs.');
                confirmCheckoutBtn.disabled = false;
            });
        });

        // POS Keyboard Shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F2') {
                e.preventDefault();
                const searchInput = document.getElementById('barcode-search');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            } else if (e.key === 'F8') {
                e.preventDefault();
                const discountInput = document.getElementById('pos-discount');
                if (discountInput) {
                    discountInput.focus();
                    discountInput.select();
                }
            } else if (e.key === 'F9') {
                e.preventDefault();
                const payCash = document.getElementById('pay-cash');
                const payBkash = document.getElementById('pay-bkash');
                const payCard = document.getElementById('pay-card');
                if (payCash && payBkash && payCard) {
                    if (payCash.checked) {
                        payBkash.checked = true;
                        payBkash.dispatchEvent(new Event('change'));
                    } else if (payBkash.checked) {
                        payCard.checked = true;
                        payCard.dispatchEvent(new Event('change'));
                    } else {
                        payCash.checked = true;
                        payCash.dispatchEvent(new Event('change'));
                    }
                }
            } else if (e.key === 'F10') {
                e.preventDefault();
                const checkoutBtn = document.getElementById('checkout-submit-btn');
                if (checkoutBtn && !checkoutBtn.disabled) {
                    checkoutBtn.click();
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\m3-mobile-care\resources\views/pos/index.blade.php ENDPATH**/ ?>