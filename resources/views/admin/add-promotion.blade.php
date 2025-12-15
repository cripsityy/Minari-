@extends('layouts.admin')

@section('title', 'Add Promotion')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Add New Promotion</h2>
        <a href="{{ route('admin.promotions') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Back to Promotions
        </a>
    </div>

    <div class="form-container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.promotions.store') }}" method="POST" id="promotionForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Promo Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Enter promo code" style="text-decoration: none;" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" required>
                            <option value="">Select discount type</option>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="value" value="{{ old('value') }}" placeholder="Enter discount value" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Minimum Purchase</label>
                        <input type="number" class="form-control" name="min_purchase" value="{{ old('min_purchase') }}" placeholder="Enter minimum purchase amount" min="0">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter promotion description" required>{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" class="form-control" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Enter usage limit" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Applicable Products</label>
                <div class="card p-3" style="max-height: 200px; overflow-y: auto;">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="applicable_products[]" id="prod_all" value="all" 
                            {{ in_array('all', old('applicable_products', [])) || empty(old('applicable_products')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="prod_all">
                            All Products
                        </label>
                    </div>
                    @foreach($products as $product)
                    <div class="form-check mb-1">
                        <input class="form-check-input product-checkbox" type="checkbox" name="applicable_products[]" id="prod_{{ $product->id }}" value="{{ $product->id }}"
                            {{ in_array($product->id, old('applicable_products', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="prod_{{ $product->id }}">
                            {{ $product->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const allCheckbox = document.getElementById('prod_all');
                    const productCheckboxes = document.querySelectorAll('.product-checkbox');

                    // Handle "All Products" click
                    allCheckbox.addEventListener('change', function() {
                        const isChecked = this.checked;
                        productCheckboxes.forEach(checkbox => {
                            checkbox.checked = isChecked;
                        });
                    });

                    // Handle individual product click
                    productCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            if (!this.checked) {
                                allCheckbox.checked = false;
                            } else {
                                // Check if all are checked
                                const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                                if (allChecked) {
                                    allCheckbox.checked = true;
                                }
                            }
                        });
                    });
                });
            </script>
            @endpush

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.promotions') }}'">
                    Cancel
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus"></i> Add Promotion
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/addpromotionadmin.js') }}"></script>
@endpush