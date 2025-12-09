<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order Confirmation</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

<header id="navMount"></header>

<div class="order-header-section">
    <div class="container">
        <div class="order-header-content">
            <h1 class="order-title" id="orderTitle">Order #----</h1>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="container">
        <div class="confirmation-content">

            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <h1 class="confirmation-title">Payment successful!</h1>
            <p class="confirmation-message">Your order will be processed shortly</p>

            <button class="back-to-collection-btn" id="backToHomeBtn">
                back to our collection
            </button>

            <button class="button" id="reviewBtn">
                rate our product
            </button>

        </div>
    </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Laravel Sync Role --}}
<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
    window.ROUTE_HOME = "{{ url('/b') }}";
    window.ROUTE_REVIEW = "{{ route('rating.page') }}";
</script>

{{-- JS --}}
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/orderconfirm.js') }}"></script>

</body>
</html>
