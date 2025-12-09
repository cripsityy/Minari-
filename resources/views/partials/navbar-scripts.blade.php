<!-- resources/views/partials/navbar-scripts.blade.php -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    // SET ROLE DARI LARAVEL SESSION
    window.APP_ROLE = "{{ auth()->check() ? (auth()->user()->role ?? 'user') : 'guest' }}";
    window.APP_URL = "{{ url('/') }}";
    window.CSRF_TOKEN = "{{ csrf_token() }}";
    
    // Debug info
    console.log('Navbar Role:', '{{ session('role', 'guest') }}');
    console.log('Is Logged In:', {{ auth()->check() ? 'true' : 'false' }});
</script>