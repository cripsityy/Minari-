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
      <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg') }}" alt="{{ $product->name }}">
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

          <button class="add-to-cart" id="addToCartBtn">Add to cart</button>
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
                    const productImage = ""; 
                    
                    window.addToCart(productId, productName, productPrice, productImage, quantity, selectedSize);
                };
            }
        });
    </script>
  </main>

  <section class="review-section">
    <h3>Review ({{ $reviews->total() }})</h3>
    
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
        
        {{ $reviews->links() }} {{-- Pagination links if needed --}}
        
        <div class="mt-3">
             <a class="lihat-lainnya" href="#">Lihat lainnya >></a>
        </div>
    @else
        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
    @endif
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- kirim role Laravel ke JS/navbar --}}
  <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
  </script>

  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/cart.js') }}"></script>
</body>
</html>
