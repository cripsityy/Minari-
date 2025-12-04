<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI | Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body>
        <header id="navMount"></header>
        <section class="login-section d-flex align-items-center justify-content-center">
            <div class="login-box p-4 shadow-lg rounded-4">
                <h3 class="text-center fw-bold mb-4">Login Account</h3>
                <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn w-100 login-btn">Login</button>
                </form>
                <div class="text-center my-3 text-muted">— Or —</div>
                <button class="btn w-100 google-btn" id="googleLogin">
                    Login with Google
                </button>
                <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.login') }}" class="text-muted small">Admin Login</a>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/navbar.js') }}"></script>
        <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>