<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Payment</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

<header id="navMount"></header>

{{-- ORDER HEADER --}}
<div class="order-header-section">
    <div class="container">
        <div class="order-header-content">
            <h1 class="order-title" id="orderTitle">Order #0103</h1>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content">
    <div class="container">

        {{-- PRODUCT SECTION --}}
        <div class="product-section" id="productSection">
            <div class="product-item">
                <div class="product-image">
                    <img src="{{ asset('images/cardigangreen.png') }}" alt="Soft green cardigan">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Soft green cardigan</h3>
                    <p class="product-price">Rp. 250.000,00</p>
                </div>
            </div>
        </div>

        {{-- SHIPPING --}}
        <div class="info-section">
            <div class="section-header clickable" id="shippingSection">
                <h3 class="section-title">Shipping to</h3>
                <div class="section-action">
                    <span class="address-name" id="selectedAddress">House</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="info-section">
            <h3 class="section-title">Subtotal product</h3>
            <div class="summary-details">
                <div class="summary-row">
                    <span class="summary-label" id="productCount">1 Product</span>
                    <span class="summary-value" id="subtotalAmount">Rp. 250.000,00</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Discount</span>
                    <span class="summary-value">Rp. 0,00</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Shipping fee</span>
                    <span class="summary-value">Rp. 0,00</span>
                </div>
                <div class="summary-row total-row">
                    <span class="summary-label">Total</span>
                    <span class="summary-value" id="totalAmount">Rp. 250.000,00</span>
                </div>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="info-section">
            <div class="section-header clickable" id="paymentSection">
                <h3 class="section-title">Payment method</h3>
                <div class="section-action">
                    <span class="payment-method" id="selectedPayment">Cash on Delivery</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- FOOTER CHECKOUT --}}
<div class="checkout-footer">
    <div class="container">
        <div class="checkout-content">
            <div class="total-price">
                <span class="total-amount" id="footerTotalAmount">Rp. 250.000,00</span>
            </div>
            <button class="checkout-btn" id="checkoutBtn">Check Out</button>
        </div>
    </div>
</div>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- SYNC ROLE DARI BACKEND --}}
<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
    window.ROUTE_SHIPPING = "{{ route('shippingadr') }}";
    window.ROUTE_PAYMENT_METHOD = "{{ route('paymentmeth') }}";
</script>



{{-- JS --}}
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/detailorder.js') }}"></script>

</body>
</html>
