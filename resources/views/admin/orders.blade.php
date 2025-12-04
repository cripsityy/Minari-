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
            <a href="{{ route('admin.products') }}" class="sidebar-item">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-item">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-item active">
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
                <h2 class="page-title">Orders</h2>
            </div>
            <div class="filter-section">
                <input type="text" class="search-box" placeholder="Search products...">
                <button class="filter-btn active">All Category</button>
            </div>

            <div class="table-custom">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Order_ID</th>
                            <th>Customers</th>
                            <th>Product</th>
                            <th>Total</th>
                            <th>Payment Status</th>
                            <th>Shipping Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', 1) }}" style="color: #000; text-decoration: none;">#0101</a></td>
                            <td>Anneiza</td>
                            <td>White Jeans</td>
                            <td>Rp 300.000</td>
                            <td><span class="badge-status badge-active">Paid</span></td>
                            <td><span class="badge-status badge-active">Shipped</span></td>
                            <td>28.10.2025</td>
                        </tr>
                            <td><a href="{{ route('admin.orders.detail', 2) }}" style="color: #000; text-decoration: none;">#0102</a></td>
                            <td>Lisa</td>
                            <td>Blue Shirt</td>
                            <td>Rp 175.000</td>
                            <td><span class="badge-status badge-pending">Unpaid</span></td>
                            <td><span class="badge-status badge-shipped">Processing</span></td>
                            <td>28.10.2025</td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', 3) }}" style="color: #000; text-decoration: none;">#0103</a></td>
                            <td>Aliyah</td>
                            <td>Soft green cardigan</td>
                            <td>Rp 250.000</td>
                            <td><span class="badge-status badge-pending">Unpaid</span></td>
                            <td><span class="badge-status badge-shipped">Processing</span></td>
                            <td>27.10.2025</td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', 4) }}" style="color: #000; text-decoration: none;">#0104</a></td>
                            <td>Karina</td>
                            <td>Cherry white long sleeve shirt</td>
                            <td>Rp 300.000</td>
                            <td><span class="badge-status badge-active">Paid</span></td>
                            <td><span class="badge-status badge-active">Shipped</span></td>
                            <td>27.10.2025</td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', 5) }}" style="color: #000; text-decoration: none;">#0105</a></td>
                            <td>Elsa</td>
                            <td>Green jeans crop blouse</td>
                            <td>Rp 175.000</td>
                            <td><span class="badge-status badge-cancelled">Pending</span></td>
                            <td><span class="badge-status badge-cancelled">Pending</span></td>
                            <td>25.10.2025</td>
                        </tr>
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', 6) }}" style="color: #000; text-decoration: none;">#0106</a></td>
                            <td>Cantika</td>
                            <td>Dark blue low rise flare jeans</td>
                            <td>Rp 300.000</td>
                            <td><span class="badge-status badge-active">Paid</span></td>
                            <td><span class="badge-status badge-active">Shipped</span></td>
                            <td>25.10.2025</td>
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
    </body>
</html>