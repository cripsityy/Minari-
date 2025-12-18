<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search - MINARI</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @include('partials.navbar-scripts')
  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <style>
    .search-tag {
        display: inline-block;
        padding: 8px 16px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 99px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    .search-tag:hover {
        background-color: #f5f5f5;
        border-color: #ccc;
        color: #000;
    }
  </style>
</head>

<body>

    <div class="menu"></div>

    <div class="container pb-5" style="padding-top: 20px;">
        <div class="search-container mb-4 d-flex justify-content-between align-items-center">
            {{-- LOGO --}}
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logofix.png') }}" alt="MINARI Logo" class="logo-img">
            </a>

            {{-- CLOSE BUTTON (To Home) --}}
            {{-- CLOSE BUTTON (To Previous Page) --}}
            <a href="#" onclick="history.back(); return false;" class="text-dark" style="text-decoration: none; font-size: 2rem; line-height: 1;">&times;</a>
        </div>

        {{-- SEARCH BAR --}}
        <div class="mb-5">
            <div class="search-wrapper d-flex align-items-center">
                {{-- Back Button (To Previous/Home) --}}
                <a href="javascript:history.back()" class="text-reset me-3" style="text-decoration: none; font-size: 1.5rem;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                
                <form action="{{ route('search') }}" method="GET" style="width: 100%;">
                    <input type="text" name="q" class="search-bar" placeholder="keywords" autofocus>
                </form>
            </div>
        </div>

        {{-- SEARCH RECOMMENDATIONS --}}
        <div>
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Trending</h6>
                <div class="d-flex flex-wrap gap-2">
                    @if(isset($trending) && $trending->count() > 0)
                        @foreach($trending as $item)
                            <a href="{{ route('search', ['q' => $item->name]) }}" class="search-tag">{{ $item->name }}</a>
                        @endforeach
                    @else
                        {{-- Fallback if no products --}}
                        <span class="text-muted small">Belum ada produk trending saat ini.</span>
                    @endif
                </div>
            </div>
            
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Riwayat pencarian</h6>
                @if(isset($history) && count($history) > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($history as $item)
                            <a href="{{ route('search', ['q' => $item]) }}" class="search-tag">{{ $item }}</a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted small">Anda dapat melihat riwayat pencarian Anda di sini.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
    </script>

    
    <script>
        // Auto focus search input
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('.search-bar');
            if(input) input.focus();
        });
    </script>
</body>
</html>
