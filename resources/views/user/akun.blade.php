<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINARI | Account</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/akum.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>

  <!-- Navbar -->
  <header id="navMount"></header>

  <!-- Account Card -->
  <section class="account-wrapper">
    <div class="container">
      <div class="card account-card mx-auto">
        <div class="card-body p-4 p-md-5">

          <!-- icon user -->
          <div class="text-center mb-4">
            <div class="user-circle mx-auto">
              <span class="user-emoji" id="userEmoji">👩‍🦰</span>
            </div>
            <div class="mt-2 small text-muted" id="roleBadge" aria-live="polite"></div>
          </div>

          <!-- fields -->
          <div class="row gx-5">
            <div class="col-12 col-md-6">
              <div class="acc-field">
                <div class="acc-label">NAME</div>
                <div class="acc-value" id="fieldName">-</div>
              </div>

              <div class="acc-field">
                <div class="acc-label">TELEPHONE NO.</div>
                <div class="acc-value" id="fieldPhone">-</div>
              </div>

              <div class="acc-field">
                <div class="acc-label">EMAIL</div>
                <div class="acc-value" id="fieldEmail">-</div>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="acc-field">
                <div class="acc-label">BIRTHDAY DATE</div>
                <div class="acc-value" id="fieldBirth">-</div>
              </div>

              <div class="acc-field">
                <div class="acc-label">ADDRESS</div>
                <div class="acc-value" id="fieldAddress">-</div>
              </div>

              <a href="#" id="addAddressLink" class="acc-add-address">ADD NEW SHIPPING ADDRESS</a>
            </div>
          </div>

          <!-- actions -->
          <div class="mt-4 d-grid gap-2">
            <a href="{{ route('login') }}" id="primaryAction" class="btn btn-account w-100">LOG IN</a>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="logo">
            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" class="logo-img">
          </div>
          <p>Your everyday fashion boutique</p>
        </div>

        <div class="col-md-6 text-end input-end">
          <p>Give us suggestions for future progress</p>
          <div class="footer-form">
            <form action="{{ route('suggestion.store') }}" method="POST">
              @csrf
              <input type="text" name="message" placeholder="your message . . .">
              <button type="submit">Send</button>
            </form>
          </div>
        </div>
      </div>

      <div class="footer-divider"></div>
      <div class="copyright">
        © {{ date('Y') }} MINARI. All Rights Reserved.
      </div>
    </div>
  </footer>

  {{-- JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>
<script src="{{ asset('js/navbar.js') }}"></script>

      <script src="{{ asset('js/akun.js') }}"></script>
  <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
