<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINARI | Products</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/category.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
  <!-- Navbar mount -->
  <header id="navMount"></header>

  <!-- Hero -->
  <section class="hero">
    <img id="heroImg" src="" alt="" class="hero__img">
    <div id="heroTitle" class="hero__title"></div>
  </section>

  <!-- Grid produk -->
  <main class="container-fluid p-0">
    <div id="productGrid" class="row g-0"></div>
  </main>

  <!-- Toast: added to cart -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="miniToast" class="toast align-items-center" data-bs-delay="1600" role="status" aria-live="polite">
      <div class="d-flex">
        <div class="toast-body">Item has been added to your cart.</div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Modal: please log in -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header justify-content-center">
          <h5 class="modal-title fw-bold">Please Log In</h5>
        </div>
        <div class="modal-body text-center">
          Please log in to continue
        </div>
        <div class="modal-footer justify-content-center">
          <a href="{{ route('login') }}" class="btn btn-login-soft">Log In</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Sync role dari Laravel ke JS untuk navbar --}}
  <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
  </script>

  <!-- Navbar script -->
  <script src="{{ asset('js/navbar.js') }}"></script>

  <!-- Script kategori -->
  <script src="{{ asset('js/category.js') }}"></script>
</body>
</html>
