<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Order History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @include('partials.navbar-scripts')
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<header id="navMount"></header>

<div class="main-content">
    <div class="container">
        <h1 class="page-title mb-4">Order History</h1>

        <div class="order-list">
            
            @if(isset($orders) && $orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-card fade-in">
                        <div class="order-header">
                            <div class="order-info">
                                <h3>Order {{ $order->order_number ?? '#'.$order->id }}</h3>
                                <span class="order-date">{{ $order->date ?? $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="order-status status-{{ strtolower($order->status) }}">
                                <span class="material-icons">
                                    @if($order->status == 'Sent')
                                        local_shipping
                                    @elseif($order->status == 'Delivered')
                                        check_circle
                                    @else
                                        schedule
                                    @endif
                                </span> 
                                {{ $order->status }}
                            </div>
                        </div>

                        <div class="order-content">
                            @foreach($order->items as $item)
                                <div class="product-info mb-3 border-bottom pb-3">
                                    <div class="product-image">
                                        <img src="{{ $item->product_image ?? ($item->product->image ? asset('storage/'.$item->product->image) : asset('images/default-product.jpg')) }}" alt="{{ $item->product_name }}">
                                    </div>
                                    <div class="product-details w-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h4>{{ $item->product_name }}</h4>
                                                <p class="product-specs">
                                                    Qty: {{ $item->quantity }} • 
                                                    Size: {{ $item->size ?? '-' }}
                                                </p>
                                                <p class="product-price">{{ $item->price }}</p>
                                            </div>
                                            
                                            {{-- Review Button --}}
                                            @if($order->status == 'Completed' || $order->status == 'Delivered' || $order->status == 'Sent')
                                                 @php
                                                    $hasReview = $item->product && $item->product->reviews->where('order_id', $order->id)->where('user_id', auth()->id())->first();
                                                @endphp
                                                
                                                @if(!$hasReview)
                                                    <button class="btn btn-sm btn-outline-warning" 
                                                            onclick="openReviewModal('{{ $order->id }}', '{{ $item->product_id }}', '{{ $item->product_name }}')">
                                                        Write Review
                                                    </button>
                                                @else
                                                    <span class="badge bg-success">Reviewed</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="order-summary mt-3">
                                <div class="delivery-info">
                                    <span class="material-icons">location_on</span> 
                                    Delivered to: {{ $order->delivery ?? ($order->shipping_address ?? 'Home') }}
                                </div>
                                <div class="payment-info">
                                    <span class="material-icons">payments</span> 
                                    {{ $order->payment_method ?? 'Cash on Delivery' }}
                                </div>
                                <div class="total-price">
                                    Total: {{ $order->total ?? ('Rp ' . number_format($order->total_amount ?? 0, 0, ',', '.')) }}
                                </div>
                            </div>
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('order.detail', ['id' => $order->id]) }}" class="btn-view-details">View Details</a>
                            <a href="{{ route('rating.page', ['order_id' => $order->id]) }}" class="btn btn-outline-warning ms-2">Rate Product</a>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Data statis jika tidak ada data dari controller --}}
                <!-- ORDER 1 STATIS -->
                <div class="order-card fade-in">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #0103</h3>
                            <span class="order-date">31 Oct 2025</span>
                        </div>
                        <div class="order-status status-sent">
                            <span class="material-icons">local_shipping</span> Sent
                        </div>
                    </div>

                    <div class="order-content">
                        <div class="product-info">
                            <div class="product-image">
                                <img src="{{ asset('images/cardigangreen.png') }}" alt="Soft green cardigan">
                            </div>
                            <div class="product-details">
                                <h4>Soft green cardigan</h4>
                                <p class="product-specs">Qty: 1 • Size: M</p>
                                <p class="product-price">Rp. 250.000,00</p>
                            </div>
                        </div>

                        <div class="order-summary">
                            <div class="delivery-info">
                                <span class="material-icons">location_on</span> Delivered to: Home
                            </div>
                            <div class="payment-info">
                                <span class="material-icons">payments</span> Cash on Delivery
                            </div>
                            <div class="total-price">
                                Total: Rp. 250.000,00
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="#" class="btn-view-details">View Details</a>
                    </div>
                </div>
                <!-- ... tambahkan order statis lainnya ... -->
            @endif
        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script> 
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}"; 
    window.APP_URL = "{{ url('/') }}";
</script>

<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script src="{{ asset('js/orderhistory.js') }}"></script>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Write a Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="reviewForm">
            <input type="hidden" id="reviewOrderId" name="order_id">
            <input type="hidden" id="reviewProductId" name="product_id">
            
            <p id="reviewProductName" class="fw-bold mb-3"></p>
            
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="rating-input h3 text-warning" style="cursor: pointer;">
                    <i class="far fa-star" data-value="1"></i>
                    <i class="far fa-star" data-value="2"></i>
                    <i class="far fa-star" data-value="3"></i>
                    <i class="far fa-star" data-value="4"></i>
                    <i class="far fa-star" data-value="5"></i>
                </div>
                <input type="hidden" name="rating" id="reviewRating" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea class="form-control" name="comment" rows="3" required></textarea>
            </div>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_anonymous" id="anonCheck">
                <label class="form-check-label" for="anonCheck">
                    Review anonymously
                </label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitReview()">Submit Review</button>
      </div>
    </div>
  </div>
</div>

<script>
    let reviewModal;
    
    document.addEventListener('DOMContentLoaded', () => {
        reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));
        
        // Star rating handler
        document.querySelectorAll('.rating-input i').forEach(star => {
            star.addEventListener('click', function() {
                const val = this.dataset.value;
                document.getElementById('reviewRating').value = val;
                
                // Update visuals
                document.querySelectorAll('.rating-input i').forEach((s, index) => {
                    if (index < val) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                    }
                });
            });
        });
    });

    function openReviewModal(orderId, productId, productName) {
        document.getElementById('reviewOrderId').value = orderId;
        document.getElementById('reviewProductId').value = productId;
        document.getElementById('reviewProductName').textContent = productName;
        document.getElementById('reviewForm').reset();
        
        // Reset stars
        document.querySelectorAll('.rating-input i').forEach(s => {
            s.classList.remove('fas');
            s.classList.add('far');
        });
        document.getElementById('reviewRating').value = '';
        
        reviewModal.show();
    }
    
    async function submitReview() {
        if (!document.getElementById('reviewRating').value) {
            alert('Please select a rating');
            return;
        }
        
        const form = document.getElementById('reviewForm');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        data.is_anonymous = document.getElementById('anonCheck').checked ? 1 : 0;
        
        try {
            const response = await fetch('/api/submit-review', { // Assuming this is the endpoint from UserController
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Review submitted successfully!');
                reviewModal.hide();
                location.reload();
            } else {
                alert(result.message || 'Failed to submit review');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
</script>

</body>
</html>