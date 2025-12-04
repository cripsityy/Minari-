<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>

<header id="navMount"></header>

<div class="main-content">
    <div class="container">
        <h1 class="page-title mb-4">Order History</h1>

        <div class="order-list">

            {{-- ORDER 1 --}}
            <div class="order-card fade-in">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Order #0103</h3>
                        <span class="order-date">31 Oct 2025</span>
                    </div>
                    <div class="order-status status-sent">
                        <span class="material-icons">local_shipping</span> Sent
                    </div>
                </div>

                <div class="order-content">
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

                    <div class="order-summary">
                        <div class="delivery-info">
                            <span class="material-icons">location_on</span> Delivered to: Home
                        </div>
                        <div class="payment-info">
                            <span class="material-icons">payments</span> Cash on Delivery
                        </div>
                        <div class="total-price">
                            Total: Rp. 250.000,00
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('order.detail') }}" class="btn-view-details">View Details</a>
                </div>
            </div>

            {{-- ORDER 2 --}}
            <div class="order-card fade-in">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Order #0102</h3>
                        <span class="order-date">28 Oct 2025</span>
                    </div>
                    <div class="order-status status-delivered">
                        <span class="material-icons">check_circle</span> Delivered
                    </div>
                </div>

                <div class="order-content">
                    <div class="product-info">
                        <div class="product-image">
                            <img src="{{ asset('images/whitetshirt.png') }}" alt="White shirt">
                        </div>
                        <div class="product-details">
                            <h4>White pearl crop T-shirt</h4>
                            <p class="product-specs">Qty: 2 • Size: L</p>
                            <p class="product-price">Rp. 250.000,00</p>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="delivery-info">
                            <span class="material-icons">location_on</span> Delivered to: Office
                        </div>
                        <div class="payment-info">
                            <span class="material-icons">credit_card</span> Credit Card
                        </div>
                        <div class="total-price">
                            Total: Rp. 250.000,00
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('order.detail') }}" class="btn-view-details">View Details</a>
                </div>
            </div>

            {{-- ORDER 3 --}}
            <div class="order-card fade-in">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Order #0101</h3>
                        <span class="order-date">25 Oct 2025</span>
                    </div>
                    <div class="order-status status-processing">
                        <span class="material-icons">schedule</span> Processing
                    </div>
                </div>

                <div class="order-content">
                    <div class="product-info">
                        <div class="product-image">
                            <img src="{{ asset('images/dress.jpg') }}" alt="Summer dress">
                        </div>
                        <div class="product-details">
                            <h4>Summer floral dress</h4>
                            <p class="product-specs">Qty: 1 • Size: S</p>
                            <p class="product-price">Rp. 320.000,00</p>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="delivery-info">
                            <span class="material-icons">location_on</span> Home
                        </div>
                        <div class="payment-info">
                            <span class="material-icons">payments</span> Bank Transfer
                        </div>
                        <div class="total-price">
                            Total: Rp. 320.000,00
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="{{ route('order.detail') }}" class="btn-view-details">View Details</a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script> window.APP_ROLE = "{{ session('role') ?? 'guest' }}"; </script>

<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/orderhistory.js') }}"></script>

</body>
</html>
