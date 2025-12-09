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
            <h1 class="page-title mb-0">Order Details #0103</h1>
        </div>

        {{-- DELIVERY BADGE --}}
        <div class="delivery-badge">
            <div class="check-icon">
                <span class="material-icons">check</span>
            </div>
            <span>Delivered to Home</span>
        </div>

        {{-- ORDER INFO --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">📦</span>
                <h2>Order Information</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Order Number</div>
                <div class="info-value">#0103</div>
            </div>

            <div class="info-row">
                <div class="info-label">Order Date</div>
                <div class="info-value">31 Oct 2025</div>
            </div>

            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value status-value">Sent</div>
            </div>
        </div>

        {{-- SHIPPING --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">📍</span>
                <h2>Shipping Address</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Type</div>
                <div class="info-value">House</div>
            </div>

            <div class="info-row">
                <div class="info-label">Recipient</div>
                <div class="info-value">Aliyah</div>
            </div>

            <div class="info-row">
                <div class="info-label">Address</div>
                <div class="info-value">Jl. Merdeka No. 123, Jakarta</div>
            </div>

            <div class="info-row">
                <div class="info-label">Telephone</div>
                <div class="info-value">0812-3456-7890</div>
            </div>
        </div>

        {{-- ORDERED PRODUCTS --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">shopping_bag</span>
                <h2>Ordered Products</h2>
            </div>

            <div class="product-info">
                <div class="product-image">
                    <img src="{{ asset('images/cardigangreen.png') }}" alt="Soft green cardigan">
                </div>
                <div class="product-details">
                    <h4>Soft green cardigan</h4>
                    <p class="product-specs">Qty: 1 • Size: M</p>
                    <p class="product-price">Rp. 250.000,00</p>
                </div>
            </div>
        </div>

        {{-- PAYMENT SUMMARY --}}
        <div class="info-section">
            <div class="section-header">
                <span class="material-icons">payments</span>
                <h2>Payment Summary</h2>
            </div>

            <div class="info-row">
                <div class="info-label">Sub-Total</div>
                <div class="info-value">Rp. 250.000,00</div>
            </div>

            <div class="info-row">
                <div class="info-label">Delivery</div>
                <div class="info-value">Free</div>
            </div>

            <div class="info-row">
                <div class="info-label payment-total">Total</div>
                <div class="info-value payment-total">Rp. 250.000,00</div>
            </div>

            <div class="info-row">
                <div class="info-label">Payment Method</div>
                <div class="info-value">Cash on Delivery</div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-buttons">
            <button class="btn btn-secondary">
                <span class="material-icons">help</span>
                Need Help?
            </button>

            <button class="btn btn-primary">
                <span class="material-icons">repeat</span>
                Order Again
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
