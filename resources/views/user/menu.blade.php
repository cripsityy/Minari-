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
            {{-- CLOSE BUTTON --}}
            <a class="close-btn" href="#" onclick="history.back(); return false;" style="text-decoration: none;">&times;</a>
        </div>

        {{-- SEARCH BAR --}}
        <div class="mb-5">
            <div class="search-wrapper d-flex align-items-center">
                <i class="bi bi-arrow-left me-2" id="searchBackBtn" style="display: none; cursor: pointer; font-size: 1.5rem;"></i>
                <i class="bi bi-search search-icon" id="searchIcon"></i>
                <form action="{{ route('search') }}" method="GET" style="width: 100%;">
                    <input type="text" name="q" class="search-bar" placeholder="keywords" value="{{ request('q') }}">
                </form>
            </div>
        </div>

        {{-- SEARCH RECOMMENDATIONS (Hidden by default) --}}
        <div id="searchRecommendations" style="display: none;">
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Trending</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('search', ['q' => 'Celana Barrel']) }}" class="search-tag">Celana Barrel</a>
                    <a href="{{ route('search', ['q' => 'Koleksi Jeans']) }}" class="search-tag">Koleksi Jeans</a>
                    <a href="{{ route('search', ['q' => 'Koleksi Flannel']) }}" class="search-tag">Koleksi Flannel</a>
                    <a href="{{ route('search', ['q' => 'Winter Travel']) }}" class="search-tag">Winter Travel</a>
                    <a href="{{ route('search', ['q' => 'Kaos Kaki HEATTECH']) }}" class="search-tag">Kaos Kaki HEATTECH</a>
                    <a href="{{ route('search', ['q' => 'Limited Offer']) }}" class="search-tag">Limited Offer</a>
                    <a href="{{ route('search', ['q' => 'Sale']) }}" class="search-tag">Sale</a>
                </div>
            </div>
            
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Riwayat pencarian</h6>
                <p class="text-muted small">Anda dapat melihat riwayat pencarian Anda di sini.</p>
            </div>
        </div>

        {{-- CATEGORY SECTION --}}
        <div id="categorySection" class="section row row-cols-1 row-cols-md-3 g-5 pb-5">
            @foreach($categories as $category)
            <div class="col">
                <a href="{{ route('user.category', ['cat' => $category->slug]) }}" class="card-item text-decoration-none">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                    <h6>{{ $category->name }}</h6>
                </a>
            </div>
            @endforeach
            
            @if($categories->isEmpty())
                <div class="col-12 text-center">
                    <p class="text-muted">No categories found.</p>
                </div>
            @endif
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
