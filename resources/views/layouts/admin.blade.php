<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    @stack('styles')
</head>
<body>
    @include('admin.partials.navbar')

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-table-columns"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.products') }}" class="sidebar-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Product</span>
        </a>
        <a href="{{ route('admin.categories') }}" class="sidebar-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i>
            <span>Categories</span>
        </a>
        <a href="{{ route('admin.orders') }}" class="sidebar-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.reviews') }}" class="sidebar-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
            <i class="fas fa-thumbs-up"></i>
            <span>Review</span>
        </a>
        <a href="{{ route('admin.promotions') }}" class="sidebar-item {{ request()->routeIs('admin.promotions*') ? 'active' : '' }}">
            <i class="fas fa-ad"></i>
            <span>Promotions</span>
        </a>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navigation.js') }}"></script>
    <script src="{{ asset('js/admin-navbar.js') }}"></script>
    @stack('scripts')
</body>
</html>
