<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINARI | Cart</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @include('partials.navbar-scripts')

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>
    @include('partials.toast-notifications')
<header id="navMount"></header>

<div class="container mb-5">
    <div class="cart-card p-3 p-md-4">
        
        @if($cartItems->isEmpty())
            <div class="text-center py-5">
                <h3 class="mb-3">Your cart is empty</h3>
                <p class="text-muted mb-4">Add some items to your cart</p>
                <a href="{{ route('category') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        @else
            {{-- Guest notification --}}
            @if(!Auth::check())
            <div class="alert alert-info d-flex align-items-center mb-3">
                <i class="bi bi-info-circle me-2"></i>
                <div>
                    You're shopping as a guest. 
                    <a href="{{ route('login') }}" class="alert-link">Log in</a> 
                    to save your cart and checkout faster.
                </div>
            </div>
            @endif

            {{-- Select All --}}
            <div class="d-flex align-items-center gap-2 mb-2">
                <input type="checkbox" id="selectAll" class="form-check-input" />
                <label for="selectAll" class="form-check-label fw-semibold">Select All</label>
            </div>
            <hr>

            {{-- Cart List --}}
            <div id="cartList" class="vstack gap-4">
                @foreach($cartItems as $index => $item)
                    @php
                        $isGuest = !Auth::check();
                        $itemId = $isGuest ? $item->id : $item->id;
                        $productId = $isGuest ? $item->product_id : $item->product_id;
                        $itemName = $isGuest ? $item->product->name : $item->product->name;
                        $itemPrice = $isGuest ? $item->product->price : ($item->product->final_price ?? $item->product->price);
                        $itemImage = $isGuest ? $item->product->image : ($item->product->image ? asset('storage/' . $item->product->image) : asset('images/default-product.jpg'));
                        $itemQuantity = $item->quantity;
                    @endphp
                    
                    <div class="cart-item d-grid align-items-center"
                         style="grid-template-columns: 24px 100px 1fr auto; gap:12px;"
                         data-id="{{ $itemId }}"
                         data-product-id="{{ $productId }}"
                         data-price="{{ $itemPrice }}"
                         data-is-guest="{{ $isGuest ? 'true' : 'false' }}">
                        <input type="checkbox" class="form-check-input item-check"/>
                        <img src="{{ $itemImage }}" class="item-thumb" alt="{{ $itemName }}">
                        <div>
                            <div class="fw-semibold">{{ $itemName }}</div>
                            <div class="text-muted small">Rp {{ number_format($itemPrice, 0, ',', '.') }}</div>
                            @if($item->size || $item->color)
                            <div class="text-muted small mt-1">
                                @if($item->size) Size: {{ $item->size }} @endif
                                @if($item->color) | Color: {{ $item->color }} @endif
                            </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="qty-wrap">
                                <button class="qty-btn btnMinus">−</button>
                                <input type="number" class="qty-input item-qty" min="1" value="{{ $itemQuantity }}"/>
                                <button class="qty-btn btnPlus">+</button>
                            </div>
                            <button class="btn btn-link text-danger remove-item p-0 border-0" style="text-decoration:none;" title="Remove Item">
                                <i class="fas fa-trash-alt fa-lg"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- STICKY TOTAL BAR --}}
@if(!$cartItems->isEmpty())
<div class="sticky-total">
    <div class="container-fluid px-5 d-flex align-items-center justify-content-between">
        <div>
            <span class="text-muted">Total:</span>
            <span class="ms-2 fw-bold price" id="totalPrice">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <button id="checkoutBtn" class="btn btn-dark px-4">Check out</button>
    </div>
</div>
@endif

{{-- LOGIN MODAL --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title fw-bold">Please Log In</h5>
            </div>
            <div class="modal-body text-center">
                <p>Please log in to proceed with checkout.</p>
                <p class="small text-muted">Your cart items will be saved after login.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{ route('login') }}" class="btn btn-dark">Log In</a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Continue as Guest</button>
            </div>
        </div>
    </div>
</div>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.js"></script>



<script src="{{ asset('js/navbar.js') }}"></script>
{{-- JS --}}
<script src="{{ asset('js/cart.js') }}?v={{ time() }}"></script>
</body>
</html>