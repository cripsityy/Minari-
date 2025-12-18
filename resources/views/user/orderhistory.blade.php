<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orderhistory.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<header id="navMount"></header>

<div class="main-content">
    <h1 class="page-title">Order History</h1>

    <div class="order-list">
        @if(isset($orders) && $orders->count() > 0)
            @foreach($orders as $order)
                <div class="order-card">
                    {{-- Header --}}
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order {{ $order->order_number ?? 'MIN'.str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</h3>
                            <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="order-status status-{{ strtolower($order->status) }}">
                            <span class="material-icons" style="font-size:16px;">
                                @if($order->status == 'Sent' || $order->status == 'Shipped') local_shipping
                                @elseif($order->status == 'Delivered') check_circle
                                @elseif($order->status == 'Completed') task_alt
                                @elseif($order->status == 'Cancelled') cancel
                                @else schedule @endif
                            </span> 
                            {{ $order->status }}
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="order-content-wrapper">
                        {{-- Left: Products --}}
                        <div class="products-grid">
                            @foreach($order->items->take(4) as $item) {{-- Limit to 4 to prevent overcrowding --}}
                                <div class="product-item">
                                    <div class="product-image">
                                        <img src="{{ $item->product_image ?? (optional($item->product ?? null)->image ? asset('storage/'.optional($item->product)->image) : asset('images/default-product.jpg')) }}" 
                                             alt="{{ $item->product_name }}">
                                    </div>
                                    <div class="product-details">
                                        <h4>{{ $item->product_name }}</h4>
                                        <p class="product-specs">
                                            Qty: {{ $item->quantity }} @if($item->size) • Size: {{ $item->size }} @endif
                                        </p>
                                        <p class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @if($order->items->count() > 4)
                                <div class="text-muted small ps-2 pt-2">+ {{ $order->items->count() - 4 }} other items</div>
                            @endif
                        </div>

                        {{-- Right: Summary --}}
                        <div class="order-summary-col">
                            <div class="summary-row">
                                <span class="material-icons">location_on</span>
                                <div>
                                    <div style="font-weight: 500; color: #333;">Delivered to:</div>
                                    {{ Str::limit($order->delivery ?? ($order->shipping_address ?? 'Home'), 40) }}
                                </div>
                            </div>
                            <div class="summary-row">
                                <span class="material-icons">payments</span>
                                <div>
                                    <div style="font-weight: 500; color: #333;">Payment Method:</div>
                                    {{ $order->payment_method ?? 'Bank Transfer' }}
                                </div>
                            </div>
                            <div class="total-row">
                                Total: Rp {{ number_format($order->total_amount ?? $order->total ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="order-footer">
                        <a href="{{ route('order.detail', ['id' => $order->id]) }}" class="btn-detail">View Details</a>
                        @if($order->status == 'Completed' || $order->status == 'Delivered')
                            <a href="{{ route('rating.page', ['order_id' => $order->id]) }}" class="btn-rate">Rate Product</a>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <span class="material-icons" style="font-size: 64px; color: #e0e0e0;">shopping_bag</span>
                </div>
                <h3 style="font-family: 'Playfair Display'; color: #000;">No orders yet</h3>
                <p class="text-muted">You haven't placed any orders yet.</p>
                <a href="{{ route('home') }}" class="btn-rate mt-3 d-inline-block">Start Shopping</a>
            </div>
        @endif
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script> 
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}"; 
</script>

<script src="{{ asset('js/navbar.js') }}"></script>

</body>
</html>