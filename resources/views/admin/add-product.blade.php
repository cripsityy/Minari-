@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Add New Product</h2>
        <a href="{{ route('admin.products') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <!-- Error/Success Handling is now in layout, but localized validation errors still need display -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form id="addProductForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Enter price (e.g., 150.000)" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control" placeholder="Enter stock quantity" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Enter product description"></textarea>
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload product image</p>
                            <small>Recommended: 500x500px</small>
                            <img id="imagePreview" class="image-preview">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="file-input" onchange="previewImage(event)">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex gap-3 justify-content-end">
                        <button type="button" class="btn-cancel" onclick="window.history.back()">
                            Cancel
                        </button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/addproductadmin.js') }}"></script>
@endpush