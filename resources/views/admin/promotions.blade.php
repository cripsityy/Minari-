@extends('layouts.admin')

@section('title', 'Promotions')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Promotions</h2>
        <a href="{{ route('admin.promotions.add') }}" class="btn-add" style="text-decoration: none;">
            <i class="fas fa-plus"></i> Add New Promotion
        </a>
    </div>

    <div class="table-custom">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Promo Code</th>
                    <th>Description</th>
                    <th>Discount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promo)
                <tr>
                    <td><strong>{{ $promo->code }}</strong></td>
                    <td>{{ $promo->description }}</td>
                    <td>{{ $promo->formatted_value }}</td>
                    <td>{{ $promo->start_date->format('d M Y') }}</td>
                    <td>{{ $promo->end_date->format('d M Y') }}</td>
                    <td>
                        <span class="badge-status {{ $promo->status_badge_class }}">
                            {{ $promo->status }}
                        </span>
                    <td class="text-center">
                        <div class="action-icons justify-content-center">
                            <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="text-decoration-none text-primary me-2">
                                <i class="fas fa-edit" title="Edit"></i>
                            </a>
                            <button type="button" class="btn btn-link p-0 text-danger" onclick="confirmDelete('{{ $promo->id }}', '{{ $promo->code }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No promotions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <form id="deleteForm" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, code) {
        let form = document.getElementById('deleteForm');
        form.action = '/admin/promotions/' + id;
        form.submit();
    }
</script>
@endpush