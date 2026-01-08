<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Payment</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>

<header id="navMount"></header>

{{-- ORDER HEADER --}}
<div class="order-header-section" style="background: none;">
    <div class="container">
        <div class="order-header-content">
            <h1 class="order-title" id="orderTitle">Checkout</h1>
        </div>
    </div>
</div>

<form action="{{ route('place.order') }}" method="POST" id="checkoutForm">
    @csrf
    <input type="hidden" name="selected_items" value="{{ implode(',', $selectedIds) }}">
    <input type="hidden" name="shipping_address" id="inputShippingAddress" value="">
    <input type="hidden" name="shipping_city" id="inputShippingCity" value="">
    <input type="hidden" name="shipping_postal_code" id="inputShippingPostalCode" value="">
    <input type="hidden" name="payment_method" id="inputPaymentMethod" value="cash_on_delivery">
    <input type="hidden" name="notes" value="">

    {{-- MAIN CONTENT --}}
    <div class="main-content">
        <div class="container">

            {{-- PRODUCT SECTION --}}
            <div class="product-section" id="productSection">
                @foreach($cartItems as $item)
                <div class="product-item">
                    <div class="product-image">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $item->product->name }}</h3>
                        <p class="product-price">Rp {{ number_format($item->product->final_price ?? $item->product->price, 0, ',', '.') }}</p>
                        <p class="product-quantity">Quantity: {{ $item->quantity }}</p>
                        @if($item->size) <p class="small text-muted">Size: {{ $item->size }}</p> @endif
                        @if($item->color) <p class="small text-muted">Color: {{ $item->color }}</p> @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- SHIPPING --}}
            {{-- SHIPPING --}}
            <div class="info-section">
                <div class="section-header clickable" onclick="window.location.href='{{ route('user.shipping.address') }}' + window.location.search">
                    <h3 class="section-title">Shipping to</h3>
                    <div class="section-action">
                        @php
                            $selectedId = request('address_id');
                            if ($selectedId) {
                                $primaryAddress = $addresses->firstWhere('id', $selectedId);
                            } else {
                                $primaryAddress = null; // Default to empty as requested
                            }
                        @endphp
                        
                        @if($primaryAddress)
                            <div class="text-end">
                                <span class="address-name d-block fw-bold" id="selectedAddressDisplay">{{ $primaryAddress->title }} ({{ $primaryAddress->recipient_name }})</span>
                                <span class="small text-muted d-block text-truncate" style="max-width: 200px;" id="selectedAddressDetails">{{ $primaryAddress->address_line1 }}, {{ $primaryAddress->city }}</span>
                                
                                {{-- Pre-fill hidden inputs --}}
                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        document.getElementById('inputShippingAddress').value = "{{ $primaryAddress->address_line1 }}";
                                        document.getElementById('inputShippingCity').value = "{{ $primaryAddress->city }}";
                                        document.getElementById('inputShippingPostalCode').value = "{{ $primaryAddress->postal_code }}";
                                    });
                                </script>
                            </div>
                        @else
                            <span class="address-name text-muted">Shipping Address</span>
                        @endif
                        <i class="fas fa-chevron-right ms-2"></i>
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="info-section">
                <h3 class="section-title">Subtotal product</h3>
                <div class="summary-details">
                    <div class="summary-row">
                        <span class="summary-label">{{ $cartItems->sum('quantity') }} Product(s)</span>
                        <span class="summary-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping fee</span>
                        <span class="summary-value">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                    @if(isset($discount) && $discount > 0)
                    <div class="summary-row text-success">
                        <span class="summary-label">Discount</span>
                        <span class="summary-value">- Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-row total-row">
                        <span class="summary-label">Total</span>
                        <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- PAYMENT --}}
            <div class="info-section">
                <div class="section-header clickable" onclick="window.location.href='{{ route('payment.method') }}' + window.location.search">
                    <h3 class="section-title">Payment method</h3>
                    <div class="section-action">
                        <span class="payment-method" id="selectedPaymentDisplay">Cash on Delivery</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- FOOTER CHECKOUT --}}
    <div class="checkout-footer">
        <div class="container-fluid px-5">
            <div class="checkout-content">
                <div class="total-price">
                    <span class="total-amount">Total: Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <button type="button" class="checkout-btn" id="realCheckoutBtn">Check Out</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Listener moved to external js/detailorder.js
</script>

{{-- BOOTSTRAP --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- SYNC ROLE DARI BACKEND --}}
<script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
    window.ROUTE_SHIPPING = "{{ route('user.shipping.address') }}";
    window.ROUTE_PAYMENT_METHOD = "{{ route('payment.method') }}";
</script>



{{-- JS --}}
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/detailorder.js') }}"></script>

</body>
</html>
