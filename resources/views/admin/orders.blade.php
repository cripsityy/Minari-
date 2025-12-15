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
        @include('admin.partials.navbar')

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
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment Status</th>
                            <th>Shipping Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.detail', $order->id) }}" style="color: #000; text-decoration: none;">#{{ $order->order_number }}</a></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                @if($order->items->count() > 0)
                                    {{ $order->items->first()->product->name ?? 'Item' }}
                                    @if($order->items->count() > 1)
                                        <small class="text-muted">(+{{ $order->items->count() - 1 }} others)</small>
                                    @endif
                                @else
                                    <span class="text-muted">No items</span>
                                @endif
                            </td>
                            <td>{{ $order->formatted_total }}</td>
                            <td>
                                <span class="badge-status {{ $order->payment_badge_class }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-status {{ $order->status_badge_class }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
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