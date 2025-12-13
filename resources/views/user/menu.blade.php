<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MINARI</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @include('partials.navbar-scripts')
  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>

    <div class="menu"></div>

    <div class="container  pb-5">
        <div class="search-container mb-4">

            {{-- LOGO --}}
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logofix.png') }}" alt="MINARI Logo" class="logo-img">
            </a>

            {{-- CLOSE BUTTON --}}
            <a class="close-btn" href="{{ route('home') }}" style="text-decoration: none;">&times;</a>
        </div>

        {{-- SEARCH BAR --}}
        <div class="mb-5">
            <div class="search-wrapper">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-bar" placeholder="keywords">
            </div>
        </div>

        {{-- CATEGORY SECTION --}}
        <div class="section row row-cols-1 row-cols-md-3 g-5  pb-5">

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 'shirt-blouse']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/shirt.png') }}" alt="Shirt and Blouse">
                    <h6>Shirts and Blouse</h6>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 'sweater-cardigan']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/sweaters.png') }}" alt="Sweaters, Cardigan, Fleece">
                    <h6>Sweaters, Cardigan, and Fleece</h6>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 't-shirt-polo']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/tshirt.png') }}" alt="T-Shirts and Polo">
                    <h6>T-Shirts and Polo</h6>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 'pants']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/pants.png') }}" alt="Pants">
                    <h6>Pants</h6>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 'skirt-dress']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/dress.png') }}" alt="Skirt and Dress">
                    <h6>Skirt and Dress</h6>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('user.category', ['cat' => 'accessories']) }}" class="card-item text-decoration-none">
                    <img src="{{ asset('images/accessories.png') }}" alt="Accessories">
                    <h6>Accessories</h6>
                </a>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SYNC ROLE --}}
    <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>
<script src="{{ asset('js/navbar.js') }}"></script>


    {{-- NAVBAR JS --}}
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
