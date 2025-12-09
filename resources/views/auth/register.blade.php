<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MINARI | Register</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
    <!-- Navbar -->
    <header id="navMount"></header>

    <!-- Register Section -->
    <section class="login-section d-flex align-items-center justify-content-center">
        <div class="login-box p-4 shadow-lg rounded-4">
            <h3 class="text-center fw-bold mb-4">Sign Up Account</h3>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registerForm" method="POST" action="{{ route('register.post') }}" novalidate>
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           placeholder="Enter your name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Enter username" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Enter your email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="birth_date" class="form-label">Birthday date</label>
                    <input type="date" class="form-control" id="birth_date" name="birth_date" 
                           value="{{ old('birth_date') }}" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2" 
                              placeholder="Enter your address" required>{{ old('address') }}</textarea>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Create your password" required>
                    <button type="button" class="toggle-pass" aria-label="Show/Hide password">👁️</button>
                </div>

                <div class="mb-3 position-relative">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" 
                           name="password_confirmation" placeholder="Confirm your password" required>
                </div>

                <div id="formErrors" class="text-danger small mb-2" style="min-height:18px;"></div>

                <button type="submit" class="btn w-100 login-btn">Sign up</button>
            </form>

            <div class="text-center my-3 text-muted">— Or —</div>

            <a href="{{ route('login') }}" class="btn w-100 google-btn">
                Already have an account? Log in
            </a>

            <!-- Tambah sedikit space bawah -->
            <div style="height: 30px;"></div>
        </div>
    </section>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.APP_ROLE = "{{ Auth::check() ? (Auth::user()->hasRole('admin') ? 'admin' : 'user') : 'guest' }}";
        window.IS_AUTHENTICATED = {{ Auth::check() ? 'true' : 'false' }};
    </script>

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>