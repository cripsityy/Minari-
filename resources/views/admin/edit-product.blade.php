@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Edit Product</h2>
        <a href="{{ route('admin.products') }}" class="btn-cancel">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>

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
        <form id="editProductForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" placeholder="Enter price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" placeholder="Enter stock quantity" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Update Image</label>
                        <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload new image</p>
                            <small>Recommended: 500x500px</small>
                            <img id="imagePreview" class="image-preview" src="{{ $product->image ? asset('storage/' . $product->image) : '' }}" style="{{ $product->image ? 'display:block' : '' }}">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="file-input" onchange="previewImage(event)">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex gap-3 justify-content-between">
                        <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                        <div class="d-flex gap-3">
                            <a href="{{ route('admin.products') }}" class="btn-cancel text-decoration-none text-center pt-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn-update">
                                <i class="fas fa-save"></i> Update Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>"{{ $product->name }}"</strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/editproductadmin.js') }}"></script>
@endpush