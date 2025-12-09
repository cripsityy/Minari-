<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Shipping Address</title>

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
        <div class="address-list">

            <div class="address-item" id="houseAddress">
                <div class="address-checkbox">
                    <div class="checkmark"></div>
                </div>
                <div class="address-content">
                    <h4 class="address-name">House</h4>
                    <p class="address-contact">Aliyah Rahma | 0812-3416-7800</p>
                    <p class="address-details">Jl. Merdeka No. 123, Jakarta</p>
                </div>
            </div>

            <div class="address-item" id="officeAddress">
                <div class="address-checkbox">
                    <div class="checkmark"></div>
                </div>
                <div class="address-content">
                    <h4 class="address-name">Office</h4>
                    <p class="address-contact">Aliyah Rahma | 0812-3416-7800</p>
                    <p class="address-details">Gedung Perkantoran Plaza, Lt. 5, Jakarta</p>
                </div>
            </div>

            <div class="address-item add-new" id="addNewAddress">
                <div class="add-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="address-content">
                    <h4 class="address-name">Add new address</h4>
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
<script src="{{ asset('js/shippingadr.js') }}"></script>

</body>
</html>
