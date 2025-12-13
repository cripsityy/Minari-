<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>

<header id="navMount"></header>

<div class="main-content">
    <div class="container">

        {{-- BACK BUTTON --}}
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('order.history') }}" class="back-btn me-3">
                <span class="material-icons">arrow_back</span>
            </a>
            <h1 class="page-title mb-0">Order Details {{ $order->order_number ?? '#'.$order->id }}</h1>
        </div>

        {{-- DELIVERY BADGE --}}
        <div class="delivery-badge">
            <div class="check-icon">
                <span class="material-icons">check</span>
            </div>
            <span>Delivered to {{ $order->shipping_address ?? 'Home' }}</span>
        </div>

        {{-- ORDER INFO --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">📦</span>
                <h2>Order Information</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Order Number</div>
                <div class="info-value">{{ $order->order_number ?? '#'.$order->id }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Order Date</div>
                <div class="info-value">{{ $order->created_at->format('d M Y') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value status-value">{{ $order->status }}</div>
            </div>
        </div>

        {{-- SHIPPING --}}
        @if($order->shipping)
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">📍</span>
                <h2>Shipping Address</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Recipient</div>
                <div class="info-value">{{ $order->shipping->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Address</div>
                <div class="info-value">{{ $order->shipping->address }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Telephone</div>
                <div class="info-value">{{ $order->shipping->phone }}</div>
            </div>
        </div>
        @endif

        {{-- ORDERED PRODUCTS --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">shopping_bag</span>
                <h2>Ordered Products</h2>
            </div>

            @foreach($order->items as $item)
            <div class="product-info mb-3 border-bottom pb-3">
                <div class="product-image">
                    <img src="{{ $item->product_image ?? ($item->product->image ? asset('storage/'.$item->product->image) : asset('images/default-product.jpg')) }}" alt="{{ $item->product_name }}">
                </div>
                <div class="product-details w-100">
                    <h4>{{ $item->product_name }}</h4>
                    <p class="product-specs">Qty: {{ $item->quantity }} • Size: {{ $item->size ?? '-' }}</p>
                    <p class="product-price">{{ $item->price }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAYMENT SUMMARY --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">payments</span>
                <h2>Payment Summary</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Payment Method</div>
                <div class="info-value">{{ $order->payment_method ?? 'Cash on Delivery' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label payment-total">Total</div>
                <div class="info-value payment-total">{{ $order->total_amount ? 'Rp ' . number_format($order->total_amount, 0, ',', '.') : $order->total }}</div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-buttons">
            <button class="btn btn-secondary">
                <span class="material-icons">help</span>
                Need Help?
            </button>
        </div>

    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>

<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/orderdetailcust.js') }}"></script>

</body>
</html>
