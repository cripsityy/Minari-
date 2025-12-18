<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Rating - MINARI</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.navbar-scripts')
    @include('partials.toast-notifications')
    {{-- Role Sync --}}
    <script>
        window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
        window.ROUTE_HOME = "{{ url('/b') }}"; 
    </script>
</head>
<body>

<header id="navMount"></header>

<main>
    <div class="page-title">Product Rating</div>

    @if(isset($order) && $order->items->count() > 0)
        @foreach($order->items as $item)
            @php
                // Check if already reviewed (optional optimization, or handled by API)
                $existingReview = $item->product ? $item->product->reviews()->where('order_id', $order->id)->where('user_id', auth()->id())->first() : null;
            @endphp
            
            <div class="product-box mb-5" id="review-box-{{ $item->product_id }}">
                {{-- Product Info --}}
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('images/default-product.jpg') }}" 
                         alt="{{ $item->product->name }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                    <div>
                        <div class="product-name fw-bold" style="font-size: 1.1rem;">{{ $item->product->name }}</div>
                        <div class="product-price text-muted">Rp. {{ number_format($item->price, 0, ',', '.') }}</div>
                    </div>
                </div>

                @if($existingReview)
                    <div class="reviewed-state text-center py-4">
                        <div class="mb-2" style="color: #625B71; font-weight: 500;">
                            <i class="fas fa-check-circle" style="color: #D9AF9C;"></i> Reviewed
                        </div>
                        <div class="mb-3" style="color: #e5a391; font-size: 24px; letter-spacing: 5px;">
                            @for($i=0; $i<$existingReview->rating; $i++) ★ @endfor
                        </div>
                        <div class="fst-italic" style="color: #8B7E74; font-family: 'Playfair Display', serif; font-size: 16px;">
                            "{{ $existingReview->comment }}"
                        </div>
                    </div>
                @else
                    {{-- Rating Form --}}
                    <div class="rating-section p-0 border-0 bg-transparent shadow-none w-100">
                        <div class="rating-label">Product Quality</div>
                        <div class="stars rating-input" data-product-id="{{ $item->product_id }}">
                            <span class="star" data-value="1">★</span>
                            <span class="star" data-value="2">★</span>
                            <span class="star" data-value="3">★</span>
                            <span class="star" data-value="4">★</span>
                            <span class="star" data-value="5">★</span>
                        </div>
                        <input type="hidden" id="rating-value-{{ $item->product_id }}" value="0">

                        <div class="rating-label mt-3">Comment</div>
                        <textarea id="comment-{{ $item->product_id }}" class="form-control mb-3" rows="3" placeholder="Write your review here..."></textarea>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="checkbox">
                                <input type="checkbox" id="hide-user-{{ $item->product_id }}">
                                <label for="hide-user-{{ $item->product_id }}">Hide My Username</label>
                            </div>
                            <button class="btn-submit" 
                                    onclick="submitProductReview('{{ $order->id }}', '{{ $item->product_id }}')">
                                Submit Review
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <p>No order items found to rate.</p>
            <a href="{{ route('order.history') }}" class="btn btn-dark">Back to History</a>
        </div>
    @endif
</main>

<footer>
            <div class="container-fluid px-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/rating.js') }}"></script>

</body>
</html>
