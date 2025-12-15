@extends('layouts.admin')

@section('title', 'User Suggestions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #4A3B34;">Suggestions</h4>
                        <p class="text-muted mb-0">Feedback from users and guests</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-secondary" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">User Info</th>
                                <th class="border-0 px-4 py-3 text-secondary" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Message</th>
                                <th class="border-0 px-4 py-3 text-secondary" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                                <th class="border-0 px-4 py-3 text-secondary text-end" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suggestions as $s)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <div class="fw-bold text-dark">{{ $s->name ?? 'Anonymous' }}</div>
                                        @if(!$s->name || !$s->email)
                                            <span class="badge bg-secondary" style="font-size: 0.7rem; padding: 2px 8px;">Guest</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small">{{ $s->email ?? 'No Email' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="mb-0 text-secondary" style="white-space: pre-wrap; max-width: 500px;">{{ $s->message }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-secondary small">
                                        <i class="far fa-clock me-1"></i> {{ $s->created_at->format('d M Y, H:i') }} WIB
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <form action="{{ route('admin.suggestions.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this suggestion?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="mb-3">
                                        <i class="far fa-comment-alt fa-3x text-light"></i>
                                    </div>
                                    No suggestions found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 px-3">
                    {{ $suggestions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection