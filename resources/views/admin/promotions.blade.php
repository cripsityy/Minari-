<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Promotions</title>
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
            <a href="{{ route('admin.promotions') }}" class="sidebar-item active">
                <i class="fas fa-ad"></i>
                <span>Promotions</span>
            </a>
        </div>
        
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Promotions</h2>
                <a href="{{ route('admin.promotions.add') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Add Promotion
                </a>
            </div>

            <div class="filter-section">
                <input type="text" class="search-box" placeholder="Search promotions...">
                <button class="filter-btn active">All Promotions</button>
            </div>

            <div class="table-custom">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Promo Code</th>
                            <th>Description</th>
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>NEWYEAR25</strong></td>
                            <td>New Year Sale 2025</td>
                            <td>25%</td>
                            <td>01 Jan 2025</td>
                            <td>15 Jan 2025</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>WELCOME10</strong></td>
                            <td>Welcome New Customer</td>
                            <td>10%</td>
                            <td>01 Nov 2024</td>
                            <td>31 Dec 2025</td>
                            <td><span class="badge-status badge-active">Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>FLASH50</strong></td>
                            <td>Flash Sale Weekend</td>
                            <td>50%</td>
                            <td>15 Nov 2025</td>
                            <td>17 Nov 2025</td>
                            <td><span class="badge-status badge-pending">Scheduled</span></td>
                        </tr>
                        <tr>
                            <td><strong>SUMMER20</strong></td>
                            <td>Summer Collection</td>
                            <td>20%</td>
                            <td>01 Jun 2024</td>
                            <td>31 Aug 2024</td>
                            <td><span class="badge-status badge-inactive">Expired</span></td>
                        </tr>
                        <tr>
                            <td><strong>WEEKEND15</strong></td>
                            <td>Weekend Sale</td>
                            <td>15%</td>
                            <td>03 Nov 2025</td>
                            <td>03 Nov 2025</td>
                            <td><span class="badge-status badge-inactive">Expired</span></td>
                        </tr>
                        <tr>
                            <td><strong>ARRIVAL10</strong></td>
                            <td>New Arrival</td>
                            <td>10%</td>
                            <td>01 Nov 2025</td>
                            <td>31 Nov 2025</td>
                            <td><span class="badge-status badge-inactive">Expired</span></td>
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