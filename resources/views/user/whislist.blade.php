<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MINARI | Wishlist</title>
    @include('partials.navbar-scripts')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/whislist.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
    @include('partials.toast-notifications')
    <header id="navMount"></header>
    
    <main id="gate" class="gate-wrap" style="display: none;">
        <div class="container">
            <div class="gate-panel mx-auto">
                <h1 class="gate-title">
                    You haven't logged in yet<br>
                    Please log in to continue
                </h1>
                <a id="loginBtn" class="gate-btn" href="{{ route('login') }}">Log in</a>
            </div>
        </div>
    </main>
    
    <section id="wishContent" class="wish-wrap">
        <div class="container">
            <!-- Title -->
            <h1 class="wish-title">Wishlist</h1>
            
            <!-- Top meta line -->
            <div class="wish-meta">
                <div>
                    <span id="resultCount">Results: 0 product</span>
                </div>
            </div>
            
            <hr class="wish-sep">
            
            <!-- Wishlist items will be rendered here -->
            <div id="wishList" class="wish-list"></div>
        </div>
    </section>
    
    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="miniToast" class="toast align-items-center" data-bs-delay="1600" role="status" aria-live="polite">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.IS_AUTHENTICATED = {{ Auth::check() ? 'true' : 'false' }};
    </script>
    
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/whislist.js') }}"></script>
</body>
</html>