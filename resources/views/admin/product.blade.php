<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Product Management</title>
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
                <h2 class="page-title">Products</h2>
                <a href="{{ route('admin.products.add') }}" class="btn-add" style="text-decoration: none;">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>

            <div class="filter-section">
                <input type="text" class="search-box" placeholder="Search products...">
                <button class="filter-btn active">All Category</button>
            </div>

            <div class="table-custom">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/chocoblouse.png') }}" alt="Choco Blouse">
                                </div>
                            </td>
                            <td>Choco Blouse</td>
                            <td>Shirt and Blouse</td>
                            <td>Rp 175.000</td>
                            <td>76</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 1) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('Choco Blouse')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/whitejeans.png') }}" alt="White Jeans">
                                </div>
                            </td>
                            <td>White Jeans</td>
                            <td>Pants</td>
                            <td>Rp 200.000</td>
                            <td>0</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 2) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('White Jeans')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/tshirt.png') }}" alt="Cream Dream T-shirt">
                                </div>
                            </td>
                            <td>Cream Dream T-shirt</td>
                            <td>T-Shirt and Polo</td>
                            <td>Rp 150.000</td>
                            <td>26</td>
                            <td><span class="badge-status badge-inactive">Inactive</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 3) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('Cream Dream T-shirt')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/cherrysleeve.png') }}" alt="Cherry white long sleeve shirt">
                                </div>
                            </td>
                            <td>Cherry white long sleeve shirt</td>
                            <td>Shirt and Blouse</td>
                            <td>Rp 300.000</td>
                            <td>37</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 4) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('Cherry white long sleeve shirt')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/pants.png') }}" alt="Culotte Pants">
                                </div>
                            </td>
                            <td>Culotte Pants</td>
                            <td>Tops</td>
                            <td>Rp 180.000</td>
                            <td>5</td>
                            <td><span class="badge-status badge-inactive">Inactive</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 5) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('Culotte Pants')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-img">
                                    <img src="{{ asset('images/whiteknitted.png') }}" alt="White knitted polo shirt">
                                </div>
                            </td>
                            <td>White knitted polo shirt</td>
                            <td>T-Shirt and Polo</td>
                            <td>Rp 250.000</td>
                            <td>15</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                            <td class="action-icons">
                                <a href="{{ route('admin.products.edit', 6) }}" class="text-decoration-none">
                                    <i class="fas fa-edit" title="Edit"></i>
                                </a>
                                <a href="#" class="text-decoration-none" onclick="confirmDelete('White knitted polo shirt')">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
        <script src="{{ asset('js/navigation.js') }}"></script>
        <script>
            function confirmDelete(productName) {
                if (confirm('Are you sure you want to delete "' + productName + '"?')) {
                    alert(productName + ' deleted successfully!');
                }
            }
        </script>
    </body>
</html>