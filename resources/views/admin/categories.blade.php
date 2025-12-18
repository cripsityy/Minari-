@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Categories</h2>
        <a href="{{ route('admin.categories.add') }}" class="btn-add" style="text-decoration: none;">
            <i class="fas fa-plus"></i> Add New Categories
        </a>
    </div>


    <div class="table-custom">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <div class="product-img">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="object-fit:cover; width:50px; height:50px;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="action-icons">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-decoration-none">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn p-0 border-0 bg-transparent" onclick="confirmDelete('{{ $category->id }}', '{{ addslashes($category->name) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>

    {{-- Single hidden delete form --}}
    <form id="deleteForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        let form = document.getElementById('deleteForm');
        form.action = '/admin/categories/' + id;
        form.submit();
    }
</script>
@endpush