@extends('layouts.admin')

@section('title', 'Review')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Reviews</h2>
    </div>

    <div class="table-custom">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->product->name ?? 'Deleted Product' }}</td>
                    <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                    <td>
                        <span style="color: #f3a8a8;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                    </td>
                    <td>
                        <div style="max-width: 300px; white-space: normal;">{{ $review->comment }}</div>
                    </td>
                    <td>{{ $review->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No reviews found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection