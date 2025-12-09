<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review - MINARI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/review.css') }}">
</head>

<body>

<header id="navMount"></header>

<section class="review-section">

    {{-- BACK BUTTON --}}
    <a href="{{ route('detailproduk') }}?product=Yellow%20shirt" class="back-btn">
        ← Back to Product
    </a>

    <h2 class="review-title">Reviews (5)</h2>

    {{-- Review Card 1 --}}
    <div class="review-card">
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
        </div>
        <div class="review-content">
            <h3>e*****s</h3>
            <div class="stars">★★★★☆</div>
            <p class="text">Bahannya gak kaku dan bagus banget! Warna sesuai foto juga, pengiriman cepat. Bakal order lagi.</p>
        </div>
    </div>

    {{-- Review Card 2 --}}
    <div class="review-card">
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
        </div>
        <div class="review-content">
            <h3>Aliyah Rahma</h3>
            <div class="stars">★★★★★</div>
            <p class="text">Keren kak! AKU SUKA BANGET!!!</p>
        </div>
    </div>

    {{-- Review Card 3 --}}
    <div class="review-card">
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
        </div>
        <div class="review-content">
            <h3>janejane</h3>
            <div class="stars">★★☆☆☆</div>
            <p class="text">Bagus sih, tapi ternyata aku kurang suka warnanya TT.</p>
        </div>
    </div>

    {{-- Review Card 4 --}}
    <div class="review-card">
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
        </div>
        <div class="review-content">
            <h3>lynlyn</h3>
            <div class="stars">★★★★★</div>
            <p class="text">WOW!!! I LIKE IT NEOMU NEOMU~</p>
        </div>
    </div>

    {{-- Review Card 5 --}}
    <div class="review-card">
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
        </div>
        <div class="review-content">
            <h3>A*****n</h3>
            <div class="stars">★★★☆☆</div>
            <p class="text">Menarik... tapi biasa aja sebenarnya.</p>
        </div>
    </div>

</section>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>

<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/review.js') }}"></script>

</body>
</html>
