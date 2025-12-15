<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    </head>
    <body>
        @include('admin.partials.navbar')

        <div class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item active">
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
            <a href="{{ route('admin.promotions') }}" class="sidebar-item">
                <i class="fas fa-ad"></i>
                <span>Promotions</span>
            </a>
        </div>
        
        <div class="main-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h6>Total Sales</h6>
                    <div class="value" style="color: #F4B4A1;">{{ 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                </div>
                <div class="stat-card">
                    <h6>Total Orders</h6>
                    <div class="value">{{ $stats['total_orders'] }}</div>
                </div>
                <div class="stat-card">
                    <h6>Total Customers</h6>
                    <div class="value">{{ $stats['total_customers'] }} Users</div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card">
                        <h5 class="mb-4">Recent Orders</h5>
                        <div class="table-custom">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge-status {{ $order->status_badge_class }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No recent orders</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="content-card mb-3">
                        <h5 class="mb-3">Top Selling Products</h5>
                        @forelse($topProducts as $product)
                        <div class="d-flex align-items-center mb-3">
                            <div class="product-img me-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            </div>
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <div class="text-muted">{{ $product->order_items_sum_quantity ?? 0 }} sales</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted">No sales yet</div>
                        @endforelse
                    </div>

                    <div class="content-card mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Customers Feedback</h5>
                            <a href="{{ route('admin.reviews') }}" class="text-decoration-none" style="color: #FBAF99; font-size: 14px;">View All</a>
                        </div>
                        
                        @forelse($recentReviews as $review)
                        <div class="d-flex align-items-start mb-3">
                            <div class="customer-avatar me-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong style="font-size: 14px;">{{ $review->user->name ?? 'Anonymous' }}</strong>
                                    <div class="rating" style="color: #f3a8a8; font-size: 12px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted mb-1" style="font-size: 13px; line-height: 1.4;">
                                    "{{ Str::limit($review->comment, 60) }}"
                                </p>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted">No reviews yet</div>
                        @endforelse
                    </div>

                    <div class="content-card">
                        <h5 class="mb-3">Quick Actions</h5>
                        <a href="{{ route('admin.products.add') }}" class="btn-add w-100 mb-2" style="display: block; text-decoration: none; text-align: center;">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                        <a href="{{ route('admin.categories') }}" class="btn-add w-100 mb-2" style="display: block; text-decoration: none; text-align: center;">
                            <i class="fas fa-pen"></i> Manage Categories
                        </a>
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
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>