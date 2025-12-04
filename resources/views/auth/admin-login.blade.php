<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
    </head>
    <body>
        <div class="login-container">
            <div class="login-left">
                <h1>MINARI</h1>
                <p>Your everyday fashion boutique</p>
                <p style="margin-top: 30px; font-size: 14px;">Admin Panel - Manage Your Fashion Empire</p>
                <p style="margin-top: 10px; font-size: 12px; opacity: 0.8;">Control inventory, orders, and customer experience</p>
            </div>
            <div class="login-right">
                <h2>Welcome Back!</h2>
                <p>Sign in to access admin panel</p>
                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" id="username" name="username" placeholder="Enter admin username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" id="password" name="password" placeholder="Enter admin password" required>
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>
                <div class="back-link">
                    <a href="{{ route('landing') }}">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-muted small">Login as User</a>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/admin-login.js') }}"></script>
    </body>
</html>