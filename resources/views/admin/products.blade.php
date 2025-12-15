@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Products</h2>
        <a href="{{ route('admin.products.add') }}" class="btn-add" style="text-decoration: none;">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    <div class="table-custom">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="product-img">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" onerror="this.src='{{ asset('images/logofix.png') }}'">
                        </div>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->status == 'active' && $product->stock > 0)
                            <span class="badge-status badge-active">Active</span>
                        @else
                            <span class="badge-status badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td class="action-icons">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-decoration-none">
                            <i class="fas fa-edit" title="Edit"></i>
                        </a>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn p-0 border-0 bg-transparent text-danger">
                                <i class="fas fa-trash" title="Delete"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    

@endsection

@push('scripts')
<script>
    function confirmDelete(productName) {
        if (confirm('Are you sure you want to delete "' + productName + '"?')) {
            alert(productName + ' deleted successfully!');
        }
    }
</script>
@endpush