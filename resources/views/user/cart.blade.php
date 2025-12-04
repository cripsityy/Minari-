<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINARI | Cart</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>

<header id="navMount"></header>

<div class="container mb-5">
    <div class="cart-card p-3 p-md-4">

      {{-- Select All --}}
      <div class="d-flex align-items-center gap-2 mb-2">
        <input type="checkbox" id="selectAll" class="form-check-input" />
        <label for="selectAll" class="form-check-label fw-semibold">Select All</label>
      </div>
      <hr>

      {{-- Cart List --}}
      <div id="cartList" class="vstack gap-4">

        {{-- ITEM 1 --}}
        <div class="cart-item d-grid align-items-center"
             style="grid-template-columns: 24px 80px 1fr auto; gap:12px;"
             data-id="1" data-price="250000">
          <input type="checkbox" class="form-check-input item-check"/>
          <img src="{{ asset('asset/image_2025-11-09_23-00-581.png') }}" class="item-thumb">
          <div>
            <div class="fw-semibold">Soft green cardigan</div>
            <div class="text-muted small">Rp. 250.000,00</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="qty-wrap">
              <button class="qty-btn btnMinus">−</button>
              <input type="number" class="qty-input item-qty" min="1" value="1"/>
              <button class="qty-btn btnPlus">+</button>
            </div>
          </div>
        </div>

        {{-- ITEM 2 --}}
        <div class="cart-item d-grid align-items-center"
             style="grid-template-columns: 24px 80px 1fr auto; gap:12px;"
             data-id="2" data-price="275000">
          <input type="checkbox" class="form-check-input item-check"/>
          <img src="{{ asset('asset/image_2025-11-09_23-00-58.png') }}" class="item-thumb">
          <div>
            <div class="fw-semibold">Light blue flare jeans</div>
            <div class="text-muted small">Rp. 275.000,00</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="qty-wrap">
              <button class="qty-btn btnMinus">−</button>
              <input type="number" class="qty-input item-qty" min="1" value="1"/>
              <button class="qty-btn btnPlus">+</button>
            </div>
          </div>
        </div>

        {{-- ITEM 3 --}}
        <div class="cart-item d-grid align-items-center"
             style="grid-template-columns: 24px 80px 1fr auto; gap:12px;"
             data-id="3" data-price="150000">
          <input type="checkbox" class="form-check-input item-check"/>
          <img src="{{ asset('asset/image_2025-11-09_23-00-582.png') }}" class="item-thumb">
          <div>
            <div class="fw-semibold">Crochet lace bonnet</div>
            <div class="text-muted small">Rp. 150.000,00</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="qty-wrap">
              <button class="qty-btn btnMinus">−</button>
              <input type="number" class="qty-input item-qty" min="1" value="2"/>
              <button class="qty-btn btnPlus">+</button>
            </div>
          </div>
        </div>

      </div>
    </div>
</div>

{{-- STICKY TOTAL BAR --}}
<div class="sticky-total">
  <div class="container d-flex align-items-center justify-content-between">
    <div class="ms-auto me-3 price" id="totalPrice">Rp. 0</div>
    <button id="checkoutBtn" class="btn btn-dark px-4" disabled>Check out</button>
  </div>
</div>

{{-- LOGIN MODAL --}}
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
        <a href="{{ route('login') }}" class="btn btn-dark">Log In</a>
      </div>
    </div>
  </div>
</div>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>
<script src="{{ asset('js/navbar.js') }}"></script>
{{-- JS --}}
<script src="{{ asset('js/cart.js') }}"></script>

</body>
</html>
