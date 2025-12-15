<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Edit Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    </head>
    <body>
        <nav class="navbar-custom fixed-top">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center w-100 px-5">
                    <div class="logo">
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                    </div>
                    <div class="navbar-icons">
                        <img src="{{ asset('images/notification.png') }}" alt="Favorite" width="24" height="24"></a>
                        <img src="{{ asset('images/searchnav.png') }}" alt="Search" width="24" height="24"></a>
                        <img src="{{ asset('images/email.png') }}" alt="Cart" width="24" height="24"></a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
                <i class="fas fa-table-columns"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products') }}" class="sidebar-item active">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-item">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-item">
                <i class="fas fa-file-invoice"></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.customers') }}" class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.reviews') }}" class="sidebar-item">
                <i class="fas fa-thumbs-up"></i>
                <span>Review</span>
            </a>
            <a href="{{ route('admin.promotions') }}" class="sidebar-item">
                <i class="fas fa-ad"></i>
                <span>Promotions</span>
            </a>
        </div>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Edit Product</h2>
                <a href="{{ route('admin.products') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>

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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label d-block">Size</label>
                                        <div class="d-flex gap-3 flex-wrap">
                                            @php $sizes = explode(',', $product->size ?? ''); @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="all-size" id="sizeAll" {{ in_array('all-size', $sizes) || $product->size == 'all-size' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sizeAll">All Size</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="S" id="sizeS" {{ in_array('S', $sizes) || $product->size == 'S' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sizeS">S</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="M" id="sizeM" {{ in_array('M', $sizes) || $product->size == 'M' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sizeM">M</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="L" id="sizeL" {{ in_array('L', $sizes) || $product->size == 'L' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sizeL">L</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="XL" id="sizeXL" {{ in_array('XL', $sizes) || $product->size == 'XL' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sizeXL">XL</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Material</label>
                                        <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}" placeholder="Enter material">
                                    </div>
                                </div>
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
        </div>

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

        <footer>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                        </div>
                        <p>Your everyday fashion boutique</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>Give us suggestions for future progress</p>
                        <div class="footer-form">
                            <input type="text" placeholder="your message . . .">
                            <button>Send</button>
                        </div>
                    </div>
                </div>
                <div class="footer-divider"></div>
                <div class="copyright">
                    © 2025 MINARI. All Rights Reserved.
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/editproductadmin.js') }}"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>