<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Order Details</title>
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
            <div class="order-detail-header">
                <div>
                    <a href="{{ route('admin.orders') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <h2 class="page-title mt-3">Order #{{ $id ?? '0101' }}</h2>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="order-status-badge badge-active">Paid</span>
                    <span class="order-status-badge badge-active">Shipped</span>
                    <span class="detail-value">28.10.2025</span>
                </div>
            </div>

            <div class="order-detail-grid">
                <div class="order-detail-card">
                    <h5>Customer Information</h5>
                    <div class="detail-row">
                        <span class="detail-label">Customer</span>
                        <span class="detail-value">Anneiza</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">anneiza@email.com</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone</span>
                        <span class="detail-value">+62 812-3456-7890</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Orders</span>
                        <span class="detail-value">1 Order</span>
                    </div>
                </div>

                <div class="order-detail-card">
                    <h5>Shipping Address</h5>
                    <div class="detail-value">
                        Kos Graha 9<br>
                        Jl. H. Umar No.33<br>
                        Citeureup<br>
                        Kec. Dayeuhkolot<br>
                        Kabupaten Bandung<br>
                        Jawa Barat 40257<br>
                        Indonesia
                    </div>
                </div>
            </div>

            <div class="order-detail-card">
                <h5>Order Items</h5>
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-img">
                            <img src="{{ asset('images/product2.png') }}" alt="jeans">
                        </div>
                        <div>
                            <div class="product-name">White jeans</div>
                            <div class="product-category">Pants</div>
                        </div>
                    </div>
                    <div class="product-price">Rp. 200.000,00</div>
                </div>
            </div>

            <div class="order-detail-grid">
                <div class="order-detail-card">
                    <h5>Delivery Information</h5>
                    <div class="detail-row">
                        <span class="detail-label">Courier</span>
                        <span class="detail-value">J&TUH</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Service</span>
                        <span class="detail-value">J&TUH EJET (Regular)</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Cost</span>
                        <span class="detail-value">Rp. 0</span>
                    </div>
                    
                    <div class="shipment-status">
                        <h6>Shipment Status</h6>
                        <div class="status-timeline">
                            <div class="status-step">
                                <div class="status-dot active"></div>
                                <span class="status-label">Order<br>Placed</span>
                            </div>
                            <div class="status-step">
                                <div class="status-dot active"></div>
                                <span class="status-label">Package<br>Picked Up</span>
                            </div>
                            <div class="status-step">
                                <div class="status-dot"></div>
                                <span class="status-label">In<br>Transit</span>
                            </div>
                            <div class="status-step">
                                <div class="status-dot"></div>
                                <span class="status-label">Out for<br>Delivery</span>
                            </div>
                            <div class="status-step">
                                <div class="status-dot"></div>
                                <span class="status-label">Delivered</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-detail-card">
                    <h5>Payment Summary</h5>
                    <div class="detail-row">
                        <span class="detail-label">Subtotal (1 item)</span>
                        <span class="detail-value">Rp. 200.000,00</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Delivery</span>
                        <span class="detail-value">Rp. 0</span>
                    </div>
                    <div class="detail-row" style="border-top: 2px solid #f0f0f0; font-weight: 600;">
                        <span class="detail-label">Total paid by customer</span>
                        <span class="detail-value">Rp. 200.000,00</span>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button class="btn-cancel" onclick="printInvoice()">Print Invoice</button>
                <button class="btn-update" onclick="updateOrderStatus()">Update Status</button>
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
        <script src="{{ asset('js/orderdetailadmin.js') }}"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>