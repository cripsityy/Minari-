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
                <form class="d-flex align-items-center" role="search" action="{{ route('admin.products') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 20px 0 0 20px; border-color: #eee; padding-left: 12px;">
                            <img src="{{ asset('images/searchnav.png') }}" width="16" height="16">
                        </span>
                        <input class="form-control border-start-0 ps-2 text-muted" type="search" name="search" placeholder="Search..." aria-label="Search" style="border-radius: 0 20px 20px 0; border-color: #eee; font-size: 13px; height: 32px;">
                    </div>
                </form>

                <!-- Notifications Dropdown -->
                <div class="dropdown d-flex align-items-center">
                    <a href="#" class="nav-icon d-flex align-items-center justify-content-center" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications" style="width: 32px; height: 32px;">
                        <img src="{{ asset('images/notification.png') }}" alt="Notifications" width="20" height="20">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notificationDropdown" style="min-width: 280px; border-radius: 12px;">
                        <li><h6 class="dropdown-header font-weight-bold">Notifications</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="text-center py-4">
                            <i class="far fa-bell-slash text-muted mb-2 fa-lg"></i>
                            <p class="text-muted small mb-0">Tidak ada notifikasi</p>
                        </li>
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
