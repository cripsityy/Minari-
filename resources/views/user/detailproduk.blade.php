<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MINARI - Yellow Shirt</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@include('partials.navbar-scripts')
  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/detailproduk.css') }}">
</head>
<body>

  <header id="navMount"></header>

  <main class="container-detail">
    <div class="product">
      <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
      <div class="mdet">
        <div class="details">
          <h2>{{ $product->name }}</h2>
          <p class="price">Rp. {{ number_format($product->final_price ?? $product->price, 0, ',', '.') }}</p>

          <div>
            <h4>Description</h4>
            <p class="desc">
              {{ $product->description }}
            </p>
          </div>

          <div class="category">
            <h4>Category</h4>
            <span>{{ $product->category->name ?? 'Uncategorized' }}</span>
          </div>

          {{-- Rating removed as requested --}}
          {{-- 
          <div>
            Rating <br>
            <span class="rating">★★★★☆</span>
          </div>
          --}}



          <div class="quantity">
            <button id="minus">-</button>
            <span id="count">1</span>
            <button id="plus">+</button>
          </div>
          
          <style>
            .size-btn.active {
                background-color: #000;
                color: #fff;
            }
          </style>

          <div class="action-buttons">
              <button class="add-to-cart" id="addToCartBtn">Add to cart</button>
              
              <button class="btn-wishlist {{ in_array($product->id, $wishlistProductIds ?? []) ? 'active' : '' }}" 
                      onclick="addToWishlist({{ $product->id }}, this)"
                      aria-label="Add to wishlist">
                  <img src="{{ asset('images/whislist.png') }}" 
                       alt="Wishlist" style="width: 28px; height: 28px;">
              </button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let quantity = 1;
            const countSpan = document.getElementById('count');
            const minusBtn = document.getElementById('minus');
            const plusBtn = document.getElementById('plus');
            const addToCartBtn = document.getElementById('addToCartBtn');
            
            const maxStock = {{ $product->stock }};
            
            // Re-bind events since we replaced HTML or just to be safe
            if (minusBtn) {
                minusBtn.onclick = function() {
                    if (quantity > 1) {
                        quantity--;
                        countSpan.textContent = quantity;
                    }
                };
            }
            
            if (plusBtn) {
                plusBtn.onclick = function() {
                    if (quantity < maxStock) {
                        quantity++;
                        countSpan.textContent = quantity;
                    } else {
                        alert('Max quantity reached based on available stock.');
                    }
                };
            }
            
            if (addToCartBtn) {
                addToCartBtn.onclick = function(e) {
                    e.preventDefault();
                    
                    const quantity = parseInt(countSpan.textContent) || 1;
                    const maxStock = {{ $product->stock }};

                    if (quantity > maxStock) {
                        alert('Max quantity reached based on available stock.');
                        return;
                    }
                    
                    // Auto-assign size from product data
                    const selectedSize = "";
                    
                    const productId = {{ $product->id }};
                    const productName = "{{ $product->name }}";
                    const productPrice = {{ $product->final_price ?? $product->price }};
                    const productImage = "{{ $product->image_url }}"; 
                    
                    window.addToCart(productId, productName, productPrice, productImage, quantity, selectedSize);
                };
            }

            // --- Wishlist Logic ---
            // handleWishlistHover removed - using CSS filters instead

            window.addToWishlist = function(productId, btn) {
                const isGuest = "{{ Auth::check() ? 'false' : 'true' }}" === 'true';
                if (isGuest) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const img = btn.querySelector('img');
                const isActive = btn.classList.contains('active');
                
                // Optimistic UI update
                btn.classList.toggle('active');
                // Visual update handled by CSS on .active class

                const method = isActive ? 'DELETE' : 'POST';
                const url = isActive ? `/api/wishlist/${productId}` : '/api/wishlist';
                
                const body = isActive ? {} : { product_id: productId };

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(body)
                })
                .then(res => res.json())
                .then(data => {
                    const productName = "{{ addslashes($product->name) }}";
                    if (data.success) {
                        const msg = isActive 
                            ? `"${productName}" has been removed from your wishlist.` 
                            : `"${productName}" has been added to your wishlist.`;
                        window.showToast(msg, false, 'wishlist');
                    } else {
                        // Revert on failure
                        btn.classList.toggle('active');
                        window.showToast(data.message || 'Action failed', true);
                    }
                })
                .catch(err => {
                    console.error(err);
                    // Revert on error
                    btn.classList.toggle('active');
                });
            };

            // --- Global Toast Function ---
            window.showToast = function(message, isError = false, type = 'cart') {
                const toastEl = document.getElementById('miniToast');
                const toastBody = document.getElementById('toastMessage');
                const toastIcon = document.getElementById('toastIcon');
                
                if (toastEl && toastBody && toastIcon) {
                    toastBody.textContent = message;
                    
                    // Set Icon based on type
                    let iconHtml = '';
                    if (type === 'wishlist') {
                        // Heart outline for wishlist
                         iconHtml = `<i class="far fa-heart fa-lg" style="color: #333;"></i>`;
                        if (isError) iconHtml = `<i class="fas fa-exclamation-circle fa-lg text-danger"></i>`;
                    } else {
                        // Cart icon for cart
                        iconHtml = `<i class="fas fa-shopping-cart fa-lg" style="color: #bbb;"></i>`;
                        if (isError) iconHtml = `<i class="fas fa-exclamation-circle fa-lg text-danger"></i>`;
                    }
                    toastIcon.innerHTML = iconHtml;

                    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                    toast.show();
                }
            };
        });
    </script>
  </main>

  <section class="review-section">
    <h3>Review ({{ $reviews->count() }})</h3>
    
    @if($reviews->count() > 0)
        @foreach($reviews as $review)
        <div class="review-box">
          <div class="profile">
            {{-- Default placeholder or user avatar --}}
            <img src="{{ asset('images/akun.png') }}" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
          </div>
          <div class="review-content">
            <h4>{{ $review->display_name }}</h4>
            <div class="stars text-warning">{{ $review->stars }}</div>
            <p class="review-text">
              {{ $review->comment }}
            </p>
          </div>
        </div>
        @endforeach
    @else
        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
    @endif
  </section>

    <!-- Toast: Custom styling -->
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <div id="miniToast" class="toast align-items-center border-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 12px; background: #fff; min-width: 300px; max-width: 400px;">
            <div class="d-flex align-items-center p-3">
                <div class="toast-icon me-3" id="toastIcon">
                    <!-- Icon injected via JS -->
                </div>
                <div class="toast-body flex-grow-1" id="toastMessage" style="color: #333; font-size: 14px; line-height: 1.4;">
                    Item added to cart.
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- kirim role Laravel ke JS/navbar --}}
  <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
  </script>

  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
