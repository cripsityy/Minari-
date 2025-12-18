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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #fff;
        }
        
        #navMount { flex-shrink: 0; }
        
        .main-content {
            flex: 1 0 auto;
            padding-bottom: 40px;
        }

        .back-navigation {
            padding: 20px 0;
            background: transparent !important;
        }
        
        .back-link {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }
        .back-link:hover { color: #F99D84; }

        .address-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .account-card {
            border: none;
            background: #FFF6F0; /* Light beige/pink background like account */
            box-shadow: 0 6px 18px rgba(0,0,0,.06);
            border-radius: 12px;
            padding: 40px;
        }

        .address-card {
            background: #fff;
            border: 1px solid #E8D8D3;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
        }
        .address-card:hover {
            border-color: #F99D84;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
            padding: 12px 20px;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s;
        }
        .add-btn:hover {
            background-color: #f88c6f;
            transform: translateY(-1px);
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #F99D84;
            box-shadow: 0 0 0 0.25rem rgba(249, 157, 132, 0.25);
        }
        
        /* Footer Styles (Synced) */
        footer {
            background: #D9AF9C;
            margin-top: 10px;
            padding: 10px 0;
            flex-shrink: 0;
        }
        footer .container-fluid { padding: 0 8% !important; }
        footer .logo { font-size: 18px; color: #FFF3CC; display: flex; align-items: center; gap: 8px; margin-top: 0; }
        footer p { color: #FFF3CC; margin-top: 3px; font-size: 12px; }
        footer .text-end.input-end { text-align: right; display: flex; flex-direction: column; align-items: flex-end; }
        footer .text-end.input-end p { text-align: right; margin-bottom: 5px; width: 100%; }
        footer .text-end .footer-form { display: flex; justify-content: flex-end; gap: 8px; align-items: center; width: 100%; }
        footer .text-end .footer-form input { background: #FFFFFF; border: 2px solid #FFF3CC; border-radius: 6px; padding: 4px 10px; width: 180px; font-size: 11px; text-align: left; transition: all 0.3s; }
        footer .text-end .footer-form input:focus { outline: none; border-color: #FBAF99; }
        footer .text-end .footer-form button { background: #FBAF99; border: 2px solid #FFFFFF; border-radius: 6px; padding: 4px 12px; color: #1E1E1E; font-size: 11px; cursor: pointer; transition: all 0.3s; font-weight: 500; white-space: nowrap; }
        footer .text-end .footer-form button:hover { background: #F99D84; transform: translateY(-2px); }
        .footer-divider { border-top: 1px solid #FFF3CC; margin: 8px 0; opacity: 0.6; }
        .copyright { text-align: center; color: #FFF3CC; opacity: 0.8; font-size: 11px; margin-top: 2px; }
    </style>
</head>
<body>

<header id="navMount"></header>

<div class="main-content">
    <div class="back-navigation">
        <div class="container-fluid px-5">
            <a href="{{ route('user.account') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Account</span>
            </a>
        </div>
    </div>

    <div class="container address-container mb-5">
        <div class="card account-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0" style="font-family: 'Playfair Display', serif; font-weight: 700;">Shipping Address</h2>
            </div>

            {{-- Address List --}}
            <div id="addressList">
                @forelse($addresses as $address)
                    <div class="address-card {{ $address->is_primary ? 'active' : '' }}" data-id="{{ $address->id }}" onclick="selectAddress({{ $address->id }}, this)">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0 fw-bold">{{ $address->title }}</h5>
                            @if($address->is_primary)
                                <span class="badge bg-dark">Primary</span>
                            @endif
                        </div>
                        <p class="mb-1 fw-bold text-dark">{{ $address->recipient_name }} | {{ $address->phone }}</p>
                        <p class="mb-0 text-muted small">{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->postal_code }}</p>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted" style="font-size: 40px;">📍</div>
                        <p class="text-muted">You haven't saved any addresses yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- Add New Address Form (Toggle) --}}
            <div class="mt-4">
                <button class="btn btn-outline-dark w-100 py-2 border-2 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#addAddressForm" style="border-radius: 10px;">
                    <i class="fas fa-plus me-2"></i> Add New Address
                </button>

                <div class="collapse mt-3" id="addAddressForm">
                    <div class="card card-body border-0 shadow-sm bg-white p-4" style="border-radius: 12px;">
                        <h5 class="mb-4 fw-bold">New Address Details</h5>
                        <form action="{{ route('shipping.address.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="items" value="{{ request('items') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">ADDRESS LABEL</label>
                                <input type="text" name="title" class="form-control" required placeholder="e.g. Home, Office">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">RECIPIENT NAME</label>
                                    <input type="text" name="recipient_name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">PHONE NUMBER</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">FULL ADDRESS</label>
                                <textarea name="address_line1" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">CITY</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted">POSTAL CODE</label>
                                    <input type="text" name="postal_code" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="add-btn">Save Address</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Sync Footer --}}
<footer>
    <div class="container-fluid px-5">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="logo">
             <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
          </div>
          <p>Your everyday fashion boutique</p>
        </div>

        <div class="col-md-6 text-end input-end">
          <p>Give us suggestions for future progress</p>
          <div class="footer-form">
            <form action="{{ route('suggestion.store') }}" method="POST">
              @csrf
              <input type="text" name="message" placeholder="your message . . .">
              <button type="submit">Send</button>
            </form>
          </div>
        </div>
      </div>

      <div class="footer-divider"></div>
      <div class="copyright">
        ©{{ date('Y') }} MINARI. All Rights Reserved.
      </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    // Check URL params for current selection on load
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const currentId = urlParams.get('address_id');
        if (currentId) {
            // Highlight the card with this ID if present
            document.querySelectorAll('.address-card').forEach(card => {
                if (card.dataset.id === currentId) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });
        }
    });

    function selectAddress(addressId, element) {
       const urlParams = new URLSearchParams(window.location.search);
       const items = urlParams.get('items');
       
       if (items) {
           // We are in checkout selection mode
           // Redirect back to payment with selected address ID
           urlParams.set('address_id', addressId);
           window.location.href = "{{ route('payment') }}?" + urlParams.toString();
       } else {
           // Normal account management mode
           document.querySelectorAll('.address-card').forEach(c => c.classList.remove('active'));
           element.classList.add('active');
       }
    }
</script>

</body>
</html>
