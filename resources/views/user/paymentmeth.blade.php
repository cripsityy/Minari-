<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Payment Method</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

<header id="navMount"></header>

<div class="back-navigation">
    <div class="container">
        <a href="{{ route('payment.page') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to order</span>
        </a>
    </div>
</div>

<div class="main-content">
    <div class="container">

        <div class="payment-methods-list">

            <div class="payment-method-item" id="codMethod">
                <div class="payment-checkbox"><div class="checkmark"></div></div>
                <div class="payment-content">
                    <h4 class="payment-name">Cash on Delivery</h4>
                </div>
            </div>

            <div class="payment-method-item" id="virtualMethod">
                <div class="payment-checkbox"><div class="checkmark"></div></div>
                <div class="payment-content">
                    <h4 class="payment-name">Virtual account transfer</h4>
                </div>
            </div>

            <div class="payment-method-item" id="ewalletMethod">
                <div class="payment-checkbox"><div class="checkmark"></div></div>
                <div class="payment-content">
                    <h4 class="payment-name">E-wallet</h4>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>

<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/paymentmeth..js') }}"></script>

</body>
</html>
