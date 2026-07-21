

<?php $__env->startSection('title', 'Sales Invoice - M3 Mobile Care'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5" style="max-width: 600px;">
    <div class="card border border-dark p-4 bg-white shadow-none">
        <div class="card-body">
            <!-- Store Details -->
            <div class="text-center mb-4">
                <h3 class="fw-extrabold text-dark mb-1"><?php echo e(App\Models\Setting::get('shop_name', 'M3 Mobile Care')); ?></h3>
                <p class="text-muted small mb-1"><?php echo e(App\Models\Setting::get('address', 'Level 3, Multiplan Center, Elephant Road, Dhaka')); ?></p>
                <p class="text-muted small mb-1">Phone: <?php echo e(App\Models\Setting::get('phone', '+880 1712-345678')); ?> | Email: <?php echo e(App\Models\Setting::get('email', 'info@m3mobilecare.com')); ?></p>
                <hr class="border-dark my-3">
                <h4 class="fw-bold text-dark mb-0">RETAIL SALES BILL</h4>
            </div>

            <!-- Invoice meta details -->
            <div class="row mb-4 small text-dark">
                <div class="col-6 mb-2">
                    <strong>Invoice No:</strong> <?php echo e($sale->invoice_no); ?>

                </div>
                <div class="col-6 mb-2 text-end">
                    <strong>Date:</strong> <?php echo e($sale->created_at->format('M d, Y h:i A')); ?>

                </div>
                <div class="col-6">
                    <strong>Salesman:</strong> <?php echo e($sale->salesman ? $sale->salesman->name : 'Staff'); ?>

                </div>
                <div class="col-6 text-end">
                    <strong>Payment Method:</strong> <span class="badge bg-dark"><?php echo e($sale->payment_method); ?></span>
                </div>
            </div>

            <!-- Customer registry -->
            <div class="p-3 bg-light rounded-3 mb-4 small text-dark">
                <h6 class="fw-bold mb-1"><i class="ti tabler-user me-1"></i>Customer Details:</h6>
                <?php if($sale->customer): ?>
                    <div class="fw-semibold"><?php echo e($sale->customer->name); ?></div>
                    <div>Phone: <?php echo e($sale->customer->phone); ?></div>
                    <?php if($sale->customer->address): ?>
                        <div>Address: <?php echo e($sale->customer->address); ?></div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="italic text-muted">Walk-in Customer (Guest)</div>
                <?php endif; ?>
            </div>

            <!-- Sold items list -->
            <h6 class="fw-bold mb-2 text-dark">Items Sold:</h6>
            <table class="table table-sm table-bordered align-middle small text-dark mb-4">
                <thead class="table-light">
                    <tr>
                        <th>Product Description</th>
                        <th class="text-center" style="width: 80px;">Qty</th>
                        <th class="text-end" style="width: 100px;">Rate</th>
                        <th class="text-end" style="width: 120px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sale->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <span class="fw-bold"><?php echo e($detail->item ? $detail->item->name : 'Unlisted Item'); ?></span>
                            <div class="text-muted small">SKU: <?php echo e($detail->item ? $detail->item->sku : ''); ?></div>
                        </td>
                        <td class="text-center"><?php echo e($detail->quantity); ?></td>
                        <td class="text-end"><?php echo e(number_format($detail->sale_price, 2)); ?></td>
                        <td class="text-end fw-semibold"><?php echo e(number_format($detail->quantity * $detail->sale_price, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <!-- Dynamic cost summaries -->
            <div class="row justify-content-end text-dark small">
                <div class="col-8 col-sm-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted fw-semibold">Subtotal:</td>
                            <td class="text-end fw-bold"><?php echo e(number_format($sale->total_amount, 2)); ?> BDT</td>
                        </tr>
                        <?php if($sale->discount > 0): ?>
                        <tr>
                            <td class="text-muted fw-semibold text-danger">Discount Applied:</td>
                            <td class="text-end fw-bold text-danger">-<?php echo e(number_format($sale->discount, 2)); ?> BDT</td>
                        </tr>
                        <?php endif; ?>
                        <tr class="border-top">
                            <td class="fw-bold fs-6 text-dark">Total Bill:</td>
                            <td class="text-end fw-extrabold fs-6 text-dark"><?php echo e(number_format($sale->payable_amount, 2)); ?> BDT</td>
                        </tr>
                        <?php $__currentLoopData = $sale->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-muted fw-semibold">
                                <?php echo e($payment->payment_method); ?>

                                <?php if($payment->transaction_type === 'due_payment'): ?>
                                    <span style="font-size: 0.65rem;" class="text-muted">(Due Pay)</span>
                                <?php endif; ?>:
                            </td>
                            <td class="text-end fw-bold text-success"><?php echo e(number_format($payment->amount, 2)); ?> BDT</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-top">
                            <td class="text-muted fw-semibold text-success">Total Paid:</td>
                            <td class="text-end fw-bold text-success"><?php echo e(number_format($sale->paid_amount, 2)); ?> BDT</td>
                        </tr>
                        <?php if($sale->payment_method === 'Cash' && $sale->change_returned > 0): ?>
                        <tr>
                            <td class="text-muted fw-semibold text-success">Change Returned:</td>
                            <td class="text-end fw-bold text-success"><?php echo e(number_format($sale->change_returned, 2)); ?> BDT</td>
                        </tr>
                        <?php endif; ?>
                        <?php if($sale->due_amount > 0): ?>
                        <tr class="table-danger">
                            <td class="fw-bold text-danger">Due Amount:</td>
                            <td class="text-end fw-extrabold text-danger"><?php echo e(number_format($sale->due_amount, 2)); ?> BDT</td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td class="text-muted fw-semibold">Due Amount:</td>
                            <td class="text-end">0.00 BDT</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Footer instructions -->
            <hr class="border-dark my-4">
            <div class="text-center text-muted small">
                <p class="mb-1 fw-bold text-dark">Thank you for shopping with <?php echo e(App\Models\Setting::get('shop_name', 'M3 Mobile Care')); ?>!</p>
                <p class="mb-0"><?php echo nl2br(e(App\Models\Setting::get('receipt_footer', "Note: Accessories carry a 6-month warranty. Please preserve this invoice copy for claiming warranty services."))); ?></p>
            </div>
        </div>
    </div>

    <!-- Print Action Buttons -->
    <div class="d-flex gap-2 justify-content-center mt-4 print-hidden">
        <button class="btn btn-secondary px-4" onclick="window.close()"><i class="ti tabler-x me-1"></i>Close Page</button>
        <button class="btn btn-primary px-4" onclick="window.print()"><i class="ti tabler-printer me-1"></i>Print Bill</button>
    </div>
</div>

<script>
    // Automatically trigger printing when loaded
    window.addEventListener('load', function() {
        // Wait a small moment for rendering then print
        setTimeout(() => {
            window.print();
        }, 500);
    });
</script>

<style>
@media print {
    .print-hidden, 
    #layout-menu, 
    .layout-navbar,
    footer {
        display: none !important;
    }
    body {
        background: #fff !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .container {
        max-width: 100% !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/blankLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\m3-mobile-care\resources\views/pos/invoice.blade.php ENDPATH**/ ?>