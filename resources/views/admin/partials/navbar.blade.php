<nav class="navbar-custom fixed-top">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center w-100 px-5">
            <div class="logo">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                </a>
            </div>
            
            <div class="navbar-icons d-flex align-items-center gap-3">
                <!-- Search Bar -->
                <form class="d-flex" role="search" action="{{ route('admin.products') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-color: #eee;">
                            <img src="{{ asset('images/searchnav.png') }}" width="16" height="16">
                        </span>
                        <input class="form-control border-start-0 ps-0 text-muted" type="search" name="search" placeholder="Search..." aria-label="Search" style="border-radius: 0 20px 20px 0; border-color: #eee; font-size: 13px;">
                    </div>
                </form>

                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <a href="#" class="nav-icon" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                        <img src="{{ asset('images/notification.png') }}" alt="Notifications" width="24" height="24">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notificationDropdown" style="min-width: 280px; border-radius: 12px;">
                        <li><h6 class="dropdown-header font-weight-bold">Notifications</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Dynamic Notification Logic (Currently Empty State) -->
                        <li class="text-center py-4">
                            <i class="far fa-bell-slash text-muted mb-2 fa-lg"></i>
                            <p class="text-muted small mb-0">Tidak ada notifikasi</p>
                        </li>
                    </ul>
                </div>

                <!-- Suggestions / Email -->
                <a href="{{ route('admin.suggestions.index') }}" class="nav-icon" title="Customer Suggestions">
                    <img src="{{ asset('images/email.png') }}" alt="Messages" width="24" height="24">
                </a>

                <!-- Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline mb-0">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 nav-icon text-dark" title="Logout">
                        <i class="fas fa-sign-out-alt fa-lg" style="color: #333;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
