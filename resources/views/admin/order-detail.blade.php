@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <!-- Print Styles -->
    <style>
        .print-only { display: none; }
        @media print {
        @media print {
            /* Hide UI elements */
            .sidebar, .navbar, .back-btn, .btn, .btn-cancel, .alert, form, .no-print {
                display: none !important;
            }
            /* Layout adjustments for single page */
            body, .main-content {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                color: black !important;
                font-size: 12px !important; /* Smaller font for compact fit */
            }
            .order-detail-grid {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 15px !important;
                margin-bottom: 20px !important;
            }
            /* Items section formatting */
            .product-item {
                border-bottom: 1px solid #ddd;
                padding: 8px 0;
                page-break-inside: avoid;
            }
            /* Images visible but small */
            .product-img {
                display: block !important; /* Ensure visible */
                width: 40px !important;
                height: 40px !important;
            }
            .product-img img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
            
            /* Hide Delivery Info as requested */
            .order-detail-card:has(h5:contains("Delivery Information")),
            .delivery-info-card {
                display: none !important;
            }
            
            .order-detail-card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                padding: 10px !important;
                break-inside: avoid;
            }
            .page-title {
                font-size: 18px !important;
                margin-bottom: 5px !important;
            }
            /* Branding Header Compact */
            .print-only {
                display: block !important;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 5px;
            }
            .invoice-brand {
                font-size: 24px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
            
            /* Compact margins generally */
            h5 { font-size: 14px !important; margin-bottom: 8px !important; font-weight: bold; }
            .detail-row { margin-bottom: 4px !important; }
        }
    </style>

    <!-- Print Header (Visible only in print) -->
    <div class="print-only">
        <div class="d-flex justify-content-between align-items-end">
            <div>
                <div class="invoice-brand">MINARI</div>
                <div class="invoice-subtitle">Official Invoice & Receipt</div>
            </div>
            <div class="text-end">
                <div>Date: {{ now()->format('d M Y') }}</div>
                <div>Order #: {{ $order->order_number }}</div>
            </div>
        </div>
    </div>

    <div class="order-detail-header">
        <div class="no-print"> <!-- Hide header logic in print, use Print Header instead -->
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
                <div class="product-img"> <!-- Images visible in print -->
                    @if($item->product && $item->product->image)
                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
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
        <!-- Delivery Info Card (Class added for Print targeting) -->
        <div class="order-detail-card delivery-info-card"> 
            <h5>Delivery Information</h5>
            <div class="detail-row">
                <span class="detail-label">Tracking Number</span>
                <span class="detail-value" id="trackingNumberDisplay">{{ $order->tracking_number ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Shipping Cost</span>
                <span class="detail-value">{{ $order->formatted_shipping_cost }}</span>
            </div>
            
            @if($order->payment_status == 'paid' || $order->payment_method == 'cash_on_delivery')
                <div class="mt-4 pt-3 border-top no-print"> <!-- Hide forms in print -->
                    <h6>Update Status</h6>
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        
                        <!-- Order Status -->
                        <div class="mb-3">
                            <label class="form-label small">Order Status</label>
                            <select name="order_status" class="form-select form-select-sm">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Status (For COD or Admin Override) -->
                        <div class="mb-3">
                            <label class="form-label small">Payment Status</label>
                            <select name="payment_status" class="form-select form-select-sm">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="returned" {{ $order->payment_status == 'returned' ? 'selected' : '' }}>Returned</option>
                            </select>
                            @if($order->payment_method == 'cash_on_delivery')
                                <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> COD Order: Update to "Paid" when money is received.</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Tracking Number (Required for Shipped)</label>
                            <input type="text" name="tracking_number" class="form-control form-control-sm" value="{{ $order->tracking_number }}" placeholder="Enter receipt number" {{ $order->tracking_number ? 'readonly' : '' }}>
                        </div>
                        <button type="submit" class="btn btn-dark btn-sm w-100">Update Status</button>
                    </form>
                </div>
            @else
                <div class="alert alert-warning mt-3 no-print">
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
    
    <!-- Hide Delivery Info via CSS class logic update -->
    <style>
        @media print {
            .delivery-info-card { display: none !important; }
        }
    </style>

    <div class="d-flex justify-content-end gap-3 mt-4 no-print">
        <button class="btn-cancel" onclick="window.print()">Print Invoice</button>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trackingInput = document.querySelector('input[name="tracking_number"]');
        const trackingDisplay = document.getElementById('trackingNumberDisplay');

        if (trackingInput && !trackingInput.value) {
            // Generate random tracking number: TRK + Timestamp + Random 3 chars
            const timestamp = Date.now().toString().substr(-6);
            const random = Math.random().toString(36).substring(2, 5).toUpperCase();
            const newCode = 'TRK' + timestamp + random;
            
            trackingInput.value = newCode;
            
            // Sync to display if it exists and is currently empty/-
            if (trackingDisplay) {
                trackingDisplay.innerText = newCode;
            }
        }
    });
</script>
{{-- <script src="{{ asset('js/orderdetailadmin.js') }}"></script> --}}
@endpush