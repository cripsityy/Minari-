@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="order-detail-header">
        <div>
            <a href="{{ route('admin.orders') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <h2 class="page-title mt-3">Order #{{ $order->order_number }}</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="order-status-badge {{ $order->payment_badge_class }}">
                {{ ucfirst($order->payment_status) }}
            </span>
            <span class="order-status-badge {{ $order->status_badge_class }}">
                {{ ucfirst($order->order_status) }}
            </span>
            <span class="detail-value">{{ $order->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    <div class="order-detail-grid">
        <div class="order-detail-card">
            <h5>Customer Information</h5>
            <div class="detail-row">
                <span class="detail-label">Customer</span>
                <span class="detail-value">{{ $order->customer_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $order->customer_email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $order->customer_phone ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">User ID</span>
                <span class="detail-value">{{ $order->user_id ? 'Registered User' : 'Guest' }}</span>
            </div>
        </div>

        <div class="order-detail-card">
            <h5>Shipping Address</h5>
            <div class="detail-value">
                {!! nl2br(e($order->shipping_address)) !!}<br>
                {{ $order->shipping_city }} {{ $order->shipping_postal_code }}
            </div>
        </div>
    </div>

    <div class="order-detail-card">
        <h5>Order Items</h5>
        @foreach($order->items as $item)
        <div class="product-item">
            <div class="product-info">
                <div class="product-img">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                    @else
                        <div style="width:60px; height:60px; background:#eee; display:flex; justify-content:center; align-items:center;">No Img</div>
                    @endif
                </div>
                <div>
                    <div class="product-name">{{ $item->product->name ?? 'Deleted Product' }}</div>
                    <div class="product-category">Size: {{ $item->size ?? 'N/A' }} | Color: {{ $item->color ?? 'N/A' }}</div>
                    <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                </div>
            </div>
            <div class="product-price">{{ 'Rp ' . number_format($item->price, 0, ',', '.') }}</div>
        </div>
        @endforeach
    </div>

    <div class="order-detail-grid">
        <div class="order-detail-card">
            <h5>Delivery Information</h5>
            <div class="detail-row">
                <span class="detail-label">Tracking Number</span>
                <span class="detail-value">{{ $order->tracking_number ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Shipping Cost</span>
                <span class="detail-value">{{ $order->formatted_shipping_cost }}</span>
            </div>
            
            @if($order->payment_status == 'paid')
                <div class="mt-4 pt-3 border-top">
                    <h6>Update Shipping Status</h6>
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Status</label>
                            <select name="order_status" class="form-select form-select-sm">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Tracking Number (Required for Shipped)</label>
                            <input type="text" name="tracking_number" class="form-control form-control-sm" value="{{ $order->tracking_number }}" placeholder="Enter receipt number">
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm w-100">Update Status</button>
                    </form>
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i> Payment Status is <strong>{{ ucfirst($order->payment_status) }}</strong>. Order processing is locked until payment is confirmed (Paid).
                </div>
            @endif
        </div>

        <div class="order-detail-card">
            <h5>Payment Summary</h5>
            <div class="detail-row">
                <span class="detail-label">Subtotal</span>
                <span class="detail-value">{{ $order->formatted_subtotal }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Delivery</span>
                <span class="detail-value">{{ $order->formatted_shipping_cost }}</span>
            </div>
            <div class="detail-row" style="border-top: 2px solid #f0f0f0; font-weight: 600;">
                <span class="detail-label">Grand Total</span>
                <span class="detail-value">{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3 mt-4">
        <button class="btn-cancel" onclick="window.print()">Print Invoice</button>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/orderdetailadmin.js') }}"></script>
@endpush