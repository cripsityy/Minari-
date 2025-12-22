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

<div class="header-spacer" style="height: 60px;"></div> {{-- Spacer for fixed navbar --}}

<div class="main-content">
    <div class="container">
        <div class="confirmation-content" style="min-height: 50vh; justify-content: flex-start; padding-top: 40px;">

            {{-- Custom Success Icon (Inline SVG for reliability) --}}
            <div class="confirmation-icon-container mb-4">
                 <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="40" fill="#F3E5DC"/>
                    <path d="M24 40L34.6667 50.6667L56 29.3333" stroke="#8B7E74" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="confirmation-title mb-3" style="font-size: 32px; color: #1D1B20;">Payment successful!</h1>
            <p class="confirmation-message mb-5" style="color: #625B71;">Your order will be processed shortly</p>
            
            @if($latestOrder)
                <div class="order-number-badge mb-5" style="background: #FFF6F0; padding: 10px 20px; border-radius: 50px; display: inline-block;">
                    <p class="m-0" style="font-family: 'Playfair Display'; font-size: 18px; color: #5a4b45;">
                        Order #{{ $latestOrder->order_number }}
                    </p>
                </div>
            @endif

            <div class="d-flex gap-3 justify-content-center flex-wrap mb-4">
                <a href="{{ url('/') }}" class="back-to-collection-btn text-decoration-none" style="background: #1D1B20; color: #fff; border: 1px solid #1D1B20;">
                    Continue Shopping
                </a>
                <a href="{{ route('order.history') }}" class="back-to-collection-btn text-decoration-none" style="background: transparent; border: 1px solid #1D1B20; color: #1D1B20;">
                    View My Orders
                </a>
            </div>
            


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
