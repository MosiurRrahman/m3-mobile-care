@extends('layouts/contentNavbarLayout')

@section('title', 'Service Catalog Catalog - M3 Mobile Care')

@section('content')
<div class="row">
    <!-- Catalog Header -->
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">Service Catalog</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Catalog</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="ti tabler-plus me-1"></i>Add New Service
        </button>
    </div>

    <!-- Main Content Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Estimated Price</th>
                                <th class="text-end" style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $index => $service)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="fw-bold text-dark">{{ $service->name }}</span></td>
                                <td><span class="text-muted small">{{ $service->description ?? 'No description' }}</span></td>
                                <td><span class="fw-semibold text-success">{{ number_format($service->price, 2) }} BDT</span></td>
                                <td class="text-end">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-icon btn-sm btn-outline-primary me-1 edit-service-btn" 
                                                data-id="{{ $service->id }}"
                                                data-name="{{ $service->name }}"
                                                data-description="{{ $service->description }}"
                                                data-price="{{ $service->price }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editServiceModal" 
                                                title="Edit Service">
                                            <i class="ti tabler-edit"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this service from the catalog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Delete"><i class="ti tabler-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="ti tabler-list-details fs-2 d-block mb-2"></i>
                                    No services added to the catalog yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_name">Service Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="add_name" class="form-control" placeholder="e.g. Screen Replacement" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="add_price">Estimated Price (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="add_price" step="0.01" min="0" class="form-control" placeholder="e.g. 2500" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="add_description">Description</label>
                        <textarea name="description" id="add_description" rows="3" class="form-control" placeholder="e.g. Original display panel replacement with 6 months warranty."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Service -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="editServiceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_name">Service Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="edit_price">Estimated Price (BDT) <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="edit_price" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold" for="edit_description">Description</label>
                        <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-service-btn');
        const editForm = document.getElementById('editServiceForm');
        const editName = document.getElementById('edit_name');
        const editPrice = document.getElementById('edit_price');
        const editDescription = document.getElementById('edit_description');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const description = this.getAttribute('data-description');

                // Update form action dynamically
                editForm.action = `/admin/services/${id}`;
                
                // Populate inputs
                editName.value = name;
                editPrice.value = price;
                editDescription.value = description;
            });
        });
    });
</script>
@endsection
