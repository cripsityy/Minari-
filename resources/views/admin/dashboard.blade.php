@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2>Dashboard</h2>
            <p class="text-muted">Welcome back, Admin</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon-wrapper blue">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <h3>{{ $stats['total_orders'] }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon-wrapper green">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon-wrapper purple">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h3>{{ $stats['total_products'] }}</h3>
                    <p>Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon-wrapper orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h3>{{ $stats['pending_orders'] }}</h3>
                    <p>Pending Orders</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>
                                        {{ ucfirst($order->order_status) }}
                                    </td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Top Products</h5>
                </div>
                <div class="card-body">
                    @foreach($topProducts as $product)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded me-3" width="50" height="50" style="object-fit: cover">
                        <div>
                            <h6 class="mb-0">{{ $product->name }}</h6>
                            <small class="text-muted">{{ $product->order_items_sum_quantity ?? 0 }} sold</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection