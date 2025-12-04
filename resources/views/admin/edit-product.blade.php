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
                <form id="editProductForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" value="Choco Blouse" placeholder="Enter product name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" required>
                                            <option value="">Select Category</option>
                                            <option value="shirts-blouse" selected>Shirts and Blouse</option>
                                            <option value="sweaters">Sweaters, Cardigan, and Fleece</option>
                                            <option value="t-shirts-polo">T-Shirts and Polo</option>
                                            <option value="pants">Pants</option>
                                            <option value="skirt-dress">Skirt and Dress</option>
                                            <option value="accessories">Accessories</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" value="175.000" placeholder="Enter price (e.g., 150.000)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Stock Quantity</label>
                                        <input type="number" class="form-control" value="76" placeholder="Enter stock quantity" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="4" placeholder="Enter product description">Elegant chocolate-colored blouse made from high-quality cotton material. Perfect for casual and formal occasions.</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Size</label>
                                        <select class="form-select">
                                            <option value="">Select Size</option>
                                            <option value="all-size" selected>All Size</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Material</label>
                                        <input type="text" class="form-control" value="100% Cotton" placeholder="Enter material">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="current-image">
                                <label class="form-label">Current Image</label>
                                <img src="{{ asset('images/product1.png') }}" alt="Choco Blouse" class="img-fluid">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Update Image</label>
                                <div class="image-upload" onclick="document.getElementById('imageInput').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click to upload new image</p>
                                    <small>Recommended: 500x500px</small>
                                    <img id="imagePreview" class="image-preview">
                                </div>
                                <input type="file" id="imageInput" accept="image/*" class="file-input" onchange="previewImage(event)">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featuredProduct" checked>
                                    <label class="form-check-label" for="featuredProduct">
                                        Featured Product
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-between">
                                <button type="button" class="btn-delete" onclick="confirmDelete()">
                                    <i class="fas fa-trash"></i> Delete Product
                                </button>
                                <div class="d-flex gap-3">
                                    <button type="button" class="btn-cancel" onclick="window.history.back()">
                                        Cancel
                                    </button>
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
                        <p>Are you sure you want to delete <strong>"Choco Blouse"</strong>?</p>
                        <p class="text-danger">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteProduct()">Delete Product</button>
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