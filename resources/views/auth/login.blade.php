<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINARI | Login</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- CSS kamu --}}
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
  <header id="navMount"></header>

  <!-- Login Section -->
  <section class="login-section d-flex align-items-center justify-content-center">
    <div class="login-box p-4 shadow-lg rounded-4">
      <h3 class="text-center fw-bold mb-4">Login Account</h3>

      {{-- Alert error umum (dari Laravel) --}}
      @if ($errors->any())
        <div class="alert alert-danger py-2">
          {{ $errors->first() }}
        </div>
      @endif

      <form id="loginForm" action="{{ route('login.post') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input
            type="text"
            class="form-control @error('username') is-invalid @enderror"
            id="username"
            name="username"
            value="{{ old('username') }}"
            required
        >
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            class="form-control @error('password') is-invalid @enderror"
            id="password"
            name="password"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-dark w-100">
        Log In
    </button>
</form>


      <div class="text-center my-3 text-muted">— Or —</div>

      <button class="btn w-100 google-btn" type="button">
        Login with Google
      </button>

      <p class="text-center mt-3">
        Don’t have an account? <a href="{{ url('/register') }}">Sign Up</a>
      </p>

      <div style="height: 30px;"></div>
    </div>
  </section>

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Kalau login.js mau dipakai nanti, disable dulu supaya tidak ganggu POST ke Laravel --}}
  {{-- <script src="{{ asset('js/login.js') }}"></script> --}}

  {{-- Sinkron role dari session Laravel ke navbar.js (optional, kalau navbar mau beda guest/user/admin) --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (!window.NavbarRole) return;

      @if(session('role') === 'admin')
        window.NavbarRole.setRole(window.NavbarRole.Role.ADMIN);
      @elseif(session('role') === 'user')
        window.NavbarRole.setRole(window.NavbarRole.Role.USER);
      @else
        window.NavbarRole.clearRole();
      @endif
    });
  </script>
  <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
