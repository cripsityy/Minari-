<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orderdetail.css') }}">
</head>

<body>

<header id="navMount"></header>

<div class="main-content">
    
    {{-- Header --}}
    <div class="detail-header">
        <a href="{{ route('order.history') }}" class="back-btn">
            <span class="material-icons" style="font-size: 20px;">arrow_back</span>
        </a>
        <h1 class="page-title">Order Details {{ $order->order_number ?? 'MIN'.str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</h1>
    </div>

    {{-- Delivery Status --}}
    <div class="delivery-status-card" style="background-color: {{ strtolower($order->order_status) == 'cancelled' ? '#f8d7da' : (strtolower($order->order_status) == 'delivered' ? '#d4edda' : '#fff3cd') }};">
        <div class="status-icon" style="background-color: {{ strtolower($order->order_status) == 'cancelled' ? '#dc3545' : (strtolower($order->order_status) == 'delivered' ? '#28a745' : '#ffc107') }};">
            <span class="material-icons">
                @if(strtolower($order->order_status) == 'delivered') check
                @elseif(strtolower($order->order_status) == 'cancelled') close
                @elseif(strtolower($order->order_status) == 'shipped' || strtolower($order->order_status) == 'sent') local_shipping
                @else schedule
                @endif
            </span>
        </div>
        <div class="delivery-text" style="color: {{ strtolower($order->order_status) == 'cancelled' ? '#721c24' : (strtolower($order->order_status) == 'delivered' ? '#155724' : '#856404') }};">
            {{ ucfirst($order->order_status) }} 
            @if(strtolower($order->order_status) == 'delivered')
                to <span style="font-weight: 600;">{{ $order->delivery ?? ($order->shipping_address ?? 'Home') }}</span>
            @endif
        </div>
    </div>

    {{-- Card 1: Order Information --}}
    <div class="detail-card">
        <h3 class="card-title">
            Order Information
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Order Number</label>
                <span>{{ $order->order_number ?? 'MIN'.str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-item">
                <label>Order Date</label>
                <span>{{ $order->created_at->format('d M Y') }}</span>
            </div>
            <div class="info-item">
                <label>Status</label>
                <span style="color: #317331; font-weight:bold;">{{ ucfirst($order->order_status) }}</span>
            </div>
        </div>
    </div>

    {{-- Card 2: Ordered Products --}}
    <div class="detail-card">
        <h3 class="card-title">
            Ordered Products
        </h3>
        
        @foreach($order->items as $item)
            <div class="product-item">
                <div class="product-thumb">
                     <img src="{{ $item->product_image ?? (optional($item->product ?? null)->image ? asset('storage/'.optional($item->product)->image) : asset('images/default-product.jpg')) }}" 
                          alt="{{ $item->product_name }}">
                </div>
                <div class="product-meta" style="flex:1;">
                    <h4>{{ $item->product_name }}</h4>
                    <p>Qty: {{ $item->quantity }} @if($item->size) • Size: {{ $item->size }} @endif</p>
                    <div class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Card 3: Payment Summary --}}
    <div class="detail-card">
        <h3 class="card-title">
            Payment Summary
        </h3>
        
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ ucwords(str_replace(['_', '-'], ' ', $order->payment_method ?? 'Bank Transfer')) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total</span>
            <span class="info-value" style="font-size: 16px; font-weight: 700;">Rp {{ number_format($order->total_amount ?? $order->total ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Footer --}}
    <div class="detail-footer" style="display: flex; justify-content: space-between; align-items: center;">

        @if(in_array(strtolower($order->order_status ?? ''), ['delivered', 'completed', 'done', 'paid']))
            <a href="{{ route('rating.page', ['order_id' => $order->id]) }}" class="btn btn-dark rounded-pill px-4" style="background-color: #1D1B20; border: none; font-family: 'Poppins', sans-serif;">
                Rate Product
            </a>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>
<script src="{{ asset('js/navbar.js') }}"></script>

</body>
</html>
