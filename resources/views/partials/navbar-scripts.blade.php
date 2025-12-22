<!-- resources/views/partials/navbar-scripts.blade.php -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-role" content="{{ Auth::check() ? (Auth::user()->hasRole('admin') ? 'admin' : 'user') : 'guest' }}">

<script>
    // SET ROLE DARI LARAVEL SESSION
    window.APP_ROLE = "{{ auth()->check() ? (auth()->user()->role ?? 'user') : 'guest' }}";
    window.APP_URL = "{{ url('/') }}";
    window.CSRF_TOKEN = "{{ csrf_token() }}";
    window.IS_AUTHENTICATED = {{ auth()->check() ? 'true' : 'false' }};
    
    console.log('APP_ROLE set to:', window.APP_ROLE);
    
    // Inject counts
    window.WISHLIST_COUNT = {{ auth()->check() ? auth()->user()->wishlist_count : 0 }};
    window.CART_COUNT = {{ auth()->check() ? auth()->user()->cart_count : 0 }};
    
    // Debug info
    console.log('Navbar Role:', '{{ session('role', 'guest') }}');
    console.log('Is Logged In:', {{ auth()->check() ? 'true' : 'false' }});
    console.log('Counts:', { wishlist: window.WISHLIST_COUNT, cart: window.CART_COUNT });
</script>