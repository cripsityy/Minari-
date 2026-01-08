@extends('layouts.admin')

@section('title', 'Edit Promotion')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Edit Promotion</h2>
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
        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" id="promotionForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Promo Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $promotion->code) }}" placeholder="Enter promo code" style="text-decoration: none;" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" required>
                            <option value="">Select discount type</option>
                            <option value="percentage" {{ old('type', $promotion->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('type', $promotion->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="value" value="{{ old('value', $promotion->value) }}" placeholder="Enter discount value" min="0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Minimum Purchase</label>
                        <input type="number" class="form-control" name="min_purchase" value="{{ old('min_purchase', $promotion->min_purchase) }}" placeholder="Enter minimum purchase amount" min="0">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" rows="3" placeholder="Enter promotion description" required>{{ old('description', $promotion->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $promotion->start_date ? $promotion->start_date->format('Y-m-d') : '') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $promotion->end_date ? $promotion->end_date->format('Y-m-d') : '') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Usage Limit</label>
                        <input type="number" class="form-control" name="usage_limit" value="{{ old('usage_limit', $promotion->usage_limit) }}" placeholder="Enter usage limit" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="active" {{ old('status', $promotion->is_active ? 'active' : 'inactive') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $promotion->is_active ? 'active' : 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Applicable Categories</label>
                <div class="card p-3" style="max-height: 200px; overflow-y: auto;">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="applicable_categories[]" id="cat_all" value="all" 
                            {{ in_array('all', old('applicable_categories', $promotion->applicable_categories ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat_all">
                            All Categories
                        </label>
                    </div>
                    @foreach($categories as $category)
                    <div class="form-check mb-1">
                        <input class="form-check-input category-checkbox" type="checkbox" name="applicable_categories[]" id="cat_{{ $category->id }}" value="{{ $category->id }}"
                            {{ in_array($category->id, old('applicable_categories', $promotion->applicable_categories ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat_{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>

            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const allCheckbox = document.getElementById('cat_all');
                    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');

                    // Handle "All Categories" click
                    allCheckbox.addEventListener('change', function() {
                        const isChecked = this.checked;
                        categoryCheckboxes.forEach(checkbox => {
                            checkbox.checked = isChecked;
                        });
                    });

                    // Handle individual category click
                    categoryCheckboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            if (!this.checked) {
                                allCheckbox.checked = false;
                            } else {
                                // Check if all are checked
                                const allChecked = Array.from(categoryCheckboxes).every(cb => cb.checked);
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
                <a href="{{ route('admin.promotions') }}" class="btn-cancel text-decoration-none text-center pt-2">
                    Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Promotion
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/addpromotionadmin.js') }}"></script>
@endpush
