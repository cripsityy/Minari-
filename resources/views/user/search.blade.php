<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Search: {{ $query }} - MINARI</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/category.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
  @include('partials.toast-notifications')
  <!-- Navbar mount -->
  <header id="navMount"></header>

  <!-- Hero -->
  <!-- Hero -->
  <section class="hero" style="min-height: 150px; display: flex; align-items: center; justify-content: center; background-image: url('{{ asset('images/aesthetic_search_bg.png') }}'); background-size: cover; background-position: center; padding: 0 5%; text-align: center;">
    <div id="heroTitle" style="color: #5a4b45; font-size: 28px; font-weight: 700; font-family: 'Playfair Display', serif; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.8);">Search Results: "{{ $query }}"</div>
  </section>

  <!-- Grid produk -->
  <main class="container-fluid p-0">
    <div id="productGrid" class="row g-0">
        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3" data-product-id="{{ $product->id }}">
                    <a href="{{ route('product.detail', $product->slug) }}" class="p-card-link">
                        <article class="p-card">
                            @if($product->discount_price)
                                <div class="discount-badge">
                                    -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                </div>
                            @endif
                            
                            <div class="p-thumb">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                            </div>
                            <div class="p-info">
                                <div class="p-info-row">
                                    <div class="p-text">
                                        <h6 class="p-name">{{ $product->name }}</h6>
                                        <div class="p-meta">
                                            <div class="p-price">
                                                @if($product->discount_price)
                                                    <span class="old-price">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="current-price">
                                                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="current-price">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($product->average_rating > 0)
                                                <div class="product-rating">
                                                    <i class="fas fa-star"></i> {{ number_format($product->average_rating, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        @if(!$product->is_in_stock)
                                            <small class="out-of-stock-text">
                                                <i class="fas fa-times-circle"></i> Out of Stock
                                            </small>
                                        @endif
                                    </div>
                                    <div class="p-mini-actions">
                                        <button class="p-wish {{ in_array($product->id, $wishlistProductIds ?? []) ? 'active' : '' }}" aria-label="Wishlist" 
                                                onclick="event.preventDefault(); addToWishlist({{ $product->id }}, this)">
                                            <i class="{{ in_array($product->id, $wishlistProductIds ?? []) ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                                        </button>
                                        <button class="p-cart" aria-label="Add to cart" 
                                                onclick="event.preventDefault(); window.addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->final_price ?? $product->price }}, '{{ asset('storage/' . $product->image) }}')">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="product-empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>There are no products available in this category at the moment.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 back-home-btn">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->

  </main>

  <!-- Toast: added to cart -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="miniToast" class="toast align-items-center" data-bs-delay="1600" role="status" aria-live="polite">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">Item has been added to your cart.</div>
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
    window.APP_ROLE = "{{ Auth::check() ? (Auth::user()->hasRole('admin') ? 'admin' : 'user') : 'guest' }}";
    window.CSRF_TOKEN = "{{ csrf_token() }}";
  </script>

  <!-- Navbar script -->
  <script src="{{ asset('js/navbar.js') }}"></script>

  <!-- Script kategori -->
  <script src="{{ asset('js/cart.js') }}"></script>
  <!-- Script kategori visual only -->
  <script src="{{ asset('js/category.js') }}"></script>
</body>
</html>