@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Orders</h2>
    </div>

    <div class="table-custom">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment Status</th>
                    <th>Shipping Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr onclick="window.location='{{ route('admin.orders.detail', $order->id) }}'" style="cursor: pointer;">
                    <td><strong>#{{ $order->order_number }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        @if($order->items->count() > 0)
                            {{ $order->items->first()->product->name ?? 'Item' }}
                            @if($order->items->count() > 1)
                                <small class="text-muted">(+{{ $order->items->count() - 1 }} others)</small>
                            @endif
                        @else
                            <span class="text-muted">No items</span>
                        @endif
                    </td>
                    <td>{{ $order->formatted_total }}</td>
                    <td>
                        <span class="badge-status {{ $order->payment_badge_class }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-status {{ $order->status_badge_class }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d.m.Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
@endsection