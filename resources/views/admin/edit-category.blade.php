<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Edit Category</title>
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
            <a href="{{ route('admin.products') }}" class="sidebar-item">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-item active">
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
                <h2 class="page-title">Edit Category</h2>
                <a href="{{ route('admin.categories') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
            </div>

            <div class="form-container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="editCategoryForm" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" id="categoryName" value="{{ old('name', $category->name) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="categoryDescription" rows="4" placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="activeStatus" value="active" {{ old('status', $category->status) == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="activeStatus">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="inactiveStatus" value="inactive" {{ old('status', $category->status) == 'inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactiveStatus">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Category Image</label>
                                <div class="current-image mb-3">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Current category image" id="currentCategoryImage" class="img-fluid">
                                </div>
                                
                                <div class="image-upload" onclick="document.getElementById('categoryImage').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click to upload new image</p>
                                    <small>JPG, PNG, or GIF (Max 2MB)</small>
                                    <input type="file" name="image" id="categoryImage" class="file-input" accept="image/*" onchange="previewImage(this)">
                                </div>
                                
                                <img id="imagePreview" class="image-preview" src="#" alt="Preview" style="display:none; max-width: 100%; margin-top: 10px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn-delete" onclick="categoryManager.confirmDelete()">
                            <i class="fas fa-trash"></i> Delete Category
                        </button>
                        <div>
                            <a href="{{ route('admin.categories') }}" class="btn-cancel me-2">Cancel</a>
                            <button type="submit" class="btn-update">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                        <p class="text-danger"><strong>Warning:</strong> Products in this category will be moved to "Uncategorized".</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete Category</button>
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
        <script src="{{ asset('js/editcategoriesadmin.js') }}"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').src = e.target.result;
                        document.getElementById('imagePreview').style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>
</html>