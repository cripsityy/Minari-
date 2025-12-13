<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINARI - Shipping Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @include('partials.navbar-scripts')
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    
    <style>
        .address-card {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .address-card:hover {
            border-color: #F99D84;
            background-color: #fff9f6;
        }
        .address-card.active {
            border-color: #F99D84;
            background-color: #fff9f6;
            border-width: 2px;
        }
        .add-btn {
            background-color: #F99D84;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
        }
        .form-control:focus {
            border-color: #F99D84;
            box-shadow: 0 0 0 0.25rem rgba(249, 157, 132, 0.25);
        }
    </style>
</head>
<body>

<header id="navMount"></header>

<div class="back-navigation">
    <div class="container">
        <a href="javascript:history.back()" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to order</span>
        </a>
    </div>
</div>

<div class="container mt-5 pt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4" style="font-family: 'Playfair Display', serif;">Shipping Address</h2>

            {{-- Address List --}}
            <div id="addressList">
                @forelse($addresses as $address)
                    <div class="address-card {{ $address->is_primary ? 'active' : '' }}" onclick="selectAddress({{ $address }}, this)">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-1">{{ $address->title }}</h5>
                            @if($address->is_primary)
                                <span class="badge bg-secondary">Primary</span>
                            @endif
                        </div>
                        <p class="mb-1 fw-bold">{{ $address->recipient_name }} | {{ $address->phone }}</p>
                        <p class="mb-0 text-muted">{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->postal_code }}</p>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        No addresses found. Please add one.
                    </div>
                @endforelse
            </div>

            {{-- Add New Address Form (Toggle) --}}
            <button class="btn btn-outline-secondary w-100 mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#addAddressForm">
                + Add New Address
            </button>

            <div class="collapse" id="addAddressForm">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="mb-3">New Address</h5>
                    <form action="{{ route('shipping.address.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Address Label (e.g. Home, Office)</label>
                            <input type="text" name="title" class="form-control" required placeholder="Home">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address_line1" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="add-btn">Save Address</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const savedData = localStorage.getItem('selectedAddressData');
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                // Try to find the card matching this title
                const cards = document.querySelectorAll('.address-card');
                let found = false;
                cards.forEach(card => {
                    card.classList.remove('active');
                    const titleEl = card.querySelector('.address-name');
                    if (titleEl && data.display_name.startsWith(titleEl.textContent)) {
                        card.classList.add('active');
                        found = true;
                    }
                });
            } catch(e) {}
        }
    });

    function selectAddress(address, element) {
        // Save full address details for display and form submission
        const addressData = {
            display_name: `${address.title} (${address.recipient_name})`,
            details: `${address.address_line1}, ${address.city}`,
            // Fields for form submission
            address_line1: address.address_line1,
            city: address.city,
            postal_code: address.postal_code
        };
        localStorage.setItem('selectedAddressData', JSON.stringify(addressData));
        
        // Visual indicator
        document.querySelectorAll('.address-card').forEach(card => card.classList.remove('active'));
        
        // If element is passed (we will update the HTML to pass 'this')
        if (element) {
            element.classList.add('active');
        } else {
             // Fallback if 'this' wasn't passed, though we will update the HTML to do so.
             const cards = document.querySelectorAll('.address-card');
             cards.forEach(card => {
                if (card.querySelector('.address-name').textContent === address.title) {
                    card.classList.add('active');
                }
             });
        }
        
        // Redirect back to order detail (payment page) immediately with current query params
        const currentParams = window.location.search;
        window.location.href = "{{ route('payment') }}" + currentParams;
    }
</script>

</body>
</html>
