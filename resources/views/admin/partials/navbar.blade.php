<nav class="navbar-custom fixed-top">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center w-100 px-5">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 35px; width: auto;">
                </a>
            </div>
            
            <div class="navbar-icons d-flex align-items-center gap-3">
                <!-- Search Bar -->
                @php
                    $currentRoute = Route::currentRouteName();
                    $searchAction = route('admin.products'); // Default
                    $searchPlaceholder = 'Search Products...';

                    if (Str::startsWith($currentRoute, 'admin.categories')) {
                        $searchAction = route('admin.categories');
                        $searchPlaceholder = 'Search Categories...';
                    } elseif (Str::startsWith($currentRoute, 'admin.orders')) {
                        $searchAction = route('admin.orders');
                        $searchPlaceholder = 'Search Customers...';
                    } elseif (Str::startsWith($currentRoute, 'admin.promotions')) {
                        $searchAction = route('admin.promotions');
                        $searchPlaceholder = 'Search Promotions...';
                    } elseif (Str::startsWith($currentRoute, 'admin.suggestions')) {
                         $searchAction = route('admin.suggestions.index');
                         $searchPlaceholder = 'Search Suggestions...';
                    } elseif (Str::startsWith($currentRoute, 'admin.reviews')) {
                         $searchAction = route('admin.reviews');
                         $searchPlaceholder = 'Search Reviews...';
                    } elseif ($currentRoute == 'admin.dashboard') {
                        // Explicitly disable for dashboard
                        $searchAction = null;
                        $searchPlaceholder = '';
                    } else {
                        // Default fallback (usually products or whatever is set initially)
                        // Do not clear it here unless we want to hide it for ALL unspecified pages.
                        // Since line 14 sets default to Admin Products, we keep it.
                        // Or we can say if it's not one of specific pages, hide it?
                        // User said "di product tetep ada tap di dashboard aja yang diilangin"
                        // So we should respect the default, or explicitly set Products if not set.
                        // Because line 14 sets it, we just do nothing here.
                    }
                @endphp
                @if($searchAction)
                <form class="d-flex align-items-center" role="search" action="{{ $searchAction }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-color: #eee; padding-left: 12px;">
                            <img src="{{ asset('images/searchnav.png') }}" width="16" height="16">
                        </span>
                        <input class="form-control border-start-0 ps-2 text-muted" type="search" name="search" placeholder="{{ $searchPlaceholder }}" aria-label="Search" style="border-radius: 0 20px 20px 0; border-color: #eee; font-size: 13px; height: 32px;" value="{{ request('search') }}">
                    </div>
                </form>
                @else
                <div style="width: 220px;"></div> {{-- Spacer to keep layout balanced if needed, or just nothing --}}
                @endif

                <!-- Notifications Dropdown -->
                @php
                    $pendingOrders = \App\Models\Order::whereIn('order_status', ['pending', 'processing'])->latest()->take(7)->get();
                    $pendingCount = \App\Models\Order::whereIn('order_status', ['pending', 'processing'])->count();
                @endphp
                <div class="dropdown d-flex align-items-center">
                    <a href="#" class="nav-icon d-flex align-items-center justify-content-center position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications" style="width: 32px; height: 32px;">
                        <img src="{{ asset('images/notification.png') }}" alt="Notifications" width="20" height="20">
                        @if($pendingCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px; padding: 2px 4px;">
                                {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notificationDropdown" style="min-width: 320px; border-radius: 12px; max-height: 400px; overflow-y: auto;">
                        <li>
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <h6 class="dropdown-header font-weight-bold mb-0 p-0 text-dark">Notifications</h6>
                                @if($pendingCount > 0)
                                <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="text-decoration-none" style="font-size: 11px;">View All</a>
                                @endif
                            </div>
                        </li>
                        <li><hr class="dropdown-divider m-0"></li>
                        
                        @forelse($pendingOrders as $nOrder)
                        <li>
                            <a href="{{ route('admin.orders.detail', $nOrder->id) }}" class="dropdown-item py-2 px-3 border-bottom">
                                <div class="d-flex align-items-start">
                                    <div class="bg-light rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-shopping-bag text-primary" style="font-size: 14px;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-1 fw-bold text-dark" style="font-size: 13px;">New Order #{{ $nOrder->order_number }}</p>
                                        <p class="mb-1 text-muted small" style="font-size: 11px;">
                                            Customer: {{ $nOrder->user->name ?? $nOrder->customer_name }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-xs text-muted">{{ $nOrder->created_at->diffForHumans() }}</span>
                                            <span class="badge {{ $nOrder->order_status == 'pending' ? 'bg-warning' : 'bg-info' }} rounded-pill" style="font-size: 9px;">{{ ucfirst($nOrder->order_status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="text-center py-4">
                            <i class="far fa-bell-slash text-muted mb-2 fa-lg"></i>
                            <p class="text-muted small mb-0">Tidak ada notifikasi pesanan baru</p>
                        </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Suggestions / Email -->
                <a href="{{ route('admin.suggestions.index') }}" class="nav-icon d-flex align-items-center justify-content-center" title="Customer Suggestions" style="width: 32px; height: 32px;">
                    <img src="{{ asset('images/email.png') }}" alt="Messages" width="20" height="20">
                </a>

                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline mb-0 d-flex align-items-center">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 nav-icon d-flex align-items-center justify-content-center text-dark" title="Logout" style="width: 32px; height: 32px;">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #333;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
