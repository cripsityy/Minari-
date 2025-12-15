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
        <div class="section row row-cols-1 row-cols-md-3 g-5 pb-5">
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
