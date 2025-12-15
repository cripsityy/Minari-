<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Add New Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    </head>
    <body>
        @include('admin.partials.navbar')

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
                <h2 class="page-title">Add New Product</h2>
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label d-block">Size</label>
                                        <div class="d-flex gap-3 flex-wrap">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="all-size" id="sizeAll">
                                                <label class="form-check-label" for="sizeAll">All Size</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="XS" id="sizeXS">
                                                <label class="form-check-label" for="sizeXS">XS</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="S" id="sizeS">
                                                <label class="form-check-label" for="sizeS">S</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="M" id="sizeM">
                                                <label class="form-check-label" for="sizeM">M</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="L" id="sizeL">
                                                <label class="form-check-label" for="sizeL">L</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="XL" id="sizeXL">
                                                <label class="form-check-label" for="sizeXL">XL</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="size[]" value="XXL" id="sizeXXL">
                                                <label class="form-check-label" for="sizeXXL">XXL</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        <script src="{{ asset('js/addproductadmin.js') }}"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>