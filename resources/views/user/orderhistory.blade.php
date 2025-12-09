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
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
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
                            <div class="product-info">
                                <div class="product-image">
                                    @if(isset($order->items[0]->product_image))
                                        <img src="{{ asset($order->items[0]->product_image) }}" alt="Product">
                                    @else
                                        {{-- Default images berdasarkan order id --}}
                                        @if($order->id == '0103')
                                            <img src="{{ asset('images/cardigangreen.png') }}" alt="Soft green cardigan">
                                        @elseif($order->id == '0102')
                                            <img src="{{ asset('images/whitetshirt.png') }}" alt="White shirt">
                                        @else
                                            <img src="{{ asset('images/dress.jpg') }}" alt="Product">
                                        @endif
                                    @endif
                                </div>
                                <div class="product-details">
                                    <h4>{{ $order->items[0]->product_name ?? 'Product Name' }}</h4>
                                    <p class="product-specs">
                                        Qty: {{ $order->items[0]->quantity ?? 1 }} • 
                                        Size: {{ $order->items[0]->size ?? 'M' }}
                                    </p>
                                    <p class="product-price">{{ $order->items[0]->price ?? 'Rp. 0,00' }}</p>
                                </div>
                            </div>

                            <div class="order-summary">
                                <div class="delivery-info">
                                    <span class="material-icons">location_on</span> 
                                    Delivered to: {{ $order->delivery ?? 'Home' }}
                                </div>
                                <div class="payment-info">
                                    <span class="material-icons">payments</span> 
                                    {{ $order->payment_method ?? 'Cash on Delivery' }}
                                </div>
                                <div class="total-price">
                                    Total: {{ $order->total ?? 'Rp. 0,00' }}
                                </div>
                            </div>
                        </div>

                        <div class="order-actions">
                            <a href="{{ route('orderdetail', ['id' => $order->id]) }}" class="btn-view-details">View Details</a>
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
                        <a href="/orderdetail/0103" class="btn-view-details">View Details</a>
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
<script src="{{ asset('js/orderhistory.js') }}"></script>

</body>
</html>