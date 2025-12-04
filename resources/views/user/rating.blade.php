<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Rating - MINARI</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    {{-- Role Sync --}}
    <script>
        window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
        window.ROUTE_HOME = "{{ url('/b') }}"; 
    </script>
</head>
<body>

<header id="navMount"></header>

<main>
    <div class="page-title">Product Rating</div>

    {{-- PRODUCT BOX --}}
    <div class="product-box">
        <img src="{{ asset('images/cardigangreen.png') }}" alt="Soft green cardigan">
        <div class="product-name">Soft green cardigan</div>
        <div class="product-price">Rp. 250.000,00</div>
    </div>

    {{-- RATING SECTION --}}
    <div class="rating-section">
        <div class="rating-label">Product Quality</div>
        <div class="stars" id="stars">
            <span class="star" data-value="1">★</span>
            <span class="star" data-value="2">★</span>
            <span class="star" data-value="3">★</span>
            <span class="star" data-value="4">★</span>
            <span class="star" data-value="5">★</span>
        </div>

        <div class="rating-label">Comment</div>
        <textarea id="comment" placeholder="Tulis pendapatmu di sini..."></textarea>

        <div class="checkbox">
            <input type="checkbox" id="hideUsername">
            <label for="hideUsername">Hide My Username</label>
        </div>

        <div class="btn-container">
            <button class="btn-submit" id="submitRatingBtn">Kirim</button>
        </div>
    </div>
</main>

<footer>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                        </div>
                        <p>Your everyday fashion boutique</p>
                    </div>
                    <div class="col-md-6 text-end input-end">
                        <p>Give us suggestions for future progress</p>
                        <div class="footer-form">
                            <form action="{{ route('suggestion.store') }}" method="POST">
                                @csrf
                                <input type="text" name="message" placeholder="your message . . .">
                                <button type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="footer-divider"></div>
                <div class="copyright">
                    © {{ date('Y') }} MINARI. All Rights Reserved.
                </div>
            </div>
        </footer>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/rating.js') }}"></script>

</body>
</html>
