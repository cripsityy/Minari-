<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Your Everyday Fashion Boutique</title>
        @include('partials.navbar-scripts')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    </head>
    <body class="landing-page">
        @include('partials.toast-notifications')
        <header id="navMount"></header>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="hero-content">
                            <h1>Discover Your Style with Us</h1>
                            <p>Explore the latest fashion trends, styles, and our collections</p>
                            <!-- Optional Button if needed -->
                            <!-- <a href="#categories" class="btn btn-dark rounded-pill px-4 py-2">Shop Now</a> -->
                        </div>
                    </div>
                    <div class="col-md-7 position-relative">
                        <div class="hero-images">
                            <!-- Main Bag Object -->
                            <img src="{{ asset('images/tes.png') }}" class="hero-obj hero-obj-main" alt="Fashion Bag">
                            
                            <!-- Floating Elements -->
                            <img src="{{ asset('images/test1.png') }}" class="hero-obj hero-obj-1" alt="Fire Icon">
                            <img src="{{ asset('images/test2.png') }}" class="hero-obj hero-obj-2" alt="Like Icon">
                            <img src="{{ asset('images/test3.png') }}" class="hero-obj hero-obj-3" alt="Coin Icon">
                            
                            <!-- Optional: Selection Box Overlay (Static for design match) -->
                            <!-- <div class="hero-obj-info">105 x 118</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if(isset($promotions) && $promotions->count() > 0)
        <section class="promotion-section py-5 bg-white">
            <div class="container">
                <h2 class="section-title text-center mb-5" style="font-family: 'Playfair Display', serif;">Special Offers</h2>
                <div class="row g-4 justify-content-center">
                    @foreach($promotions as $promo)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 promo-card" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                            <div class="card-body text-center p-4" style="background: #FFF6F0;">
                                <div class="badge bg-dark mb-3 px-3 py-2" style="font-weight: 500; letter-spacing: 1px;">
                                    {{ $promo->type == 'percentage' ? $promo->value . '% OFF' : 'Rp ' . number_format($promo->value, 0, ',', '.') . ' OFF' }}
                                </div>
                                <h4 class="fw-bold mb-2" style="color: #333;">{{ $promo->code }}</h4>
                                <p class="text-muted mb-3 small">{{ $promo->description }}</p>
                                <div class="expiry-date text-danger small">
                                    <i class="far fa-clock me-1"></i> Valid until {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                                </div>
                                <button class="btn btn-sm btn-outline-dark mt-3" onclick="navigator.clipboard.writeText('{{ $promo->code }}'); alert('Code copied!')">Copy Code</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <section class="style-section">
            <div class="container-fluid">
                <h2 class="section-title">MINARI's Style</h2>
                <div class="style-scroll-container">
                    <div class="style-scroll-track">
                        {{-- First set of items --}}
                        @for($i = 1; $i <= 8; $i++)
                        <div class="style-item">
                            <img src="{{ asset('images/g' . $i . '.png') }}" alt="Style {{ $i }}">
                        </div>
                        @endfor
                        
                        {{-- Duplicate set for seamless looping --}}
                        @for($i = 1; $i <= 8; $i++)
                        <div class="style-item">
                            <img src="{{ asset('images/g' . $i . '.png') }}" alt="Style {{ $i }}">
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
        <section class="category-section" id="categories">
            <div class="container-fluid">
                <h2 class="section-title">Product Category</h2>
                <div class="category-scroll-wrapper position-relative">
                    <button class="scroll-btn scroll-left" id="scrollLeftBtn"><i class="fas fa-chevron-left"></i></button>
                    <div class="category-scroll px-5" id="categoryScroll">
                        @foreach($categories as $category)
                        <a href="{{ route('user.category', ['cat' => $category->slug]) }}" class="category-card text-decoration-none d-block">
                            <div class="category-image">
                                <!-- Use image_url accessor which handles default -->
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                            </div>
                            <h3>{{ $category->name }}</h3>
                        </a>
                        @endforeach
                        
                        @if($categories->isEmpty())
                            <div class="text-center w-100 p-5">
                                <p class="text-muted">No categories available at the moment.</p>
                            </div>
                        @endif
                    </div>
                    <button class="scroll-btn scroll-right" id="scrollRightBtn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
        <section class="slogan-section">
            <div class="container">
                <h2>Effortless Chic,</h2>
                <div class="subtitle">EVERYDAY</div>
            </div>
        </section>
        <section class="testimonial-section">
            <div class="container">
                <h2>Our Customers Say</h2>
                <div class="row g-4">
                    @php
                        $testimonials = [
                            [
                                'text' => "Kualitas bahan pakaian Minari sangat bagus dan nyaman dipakai seharian. Desainnya juga selalu up to date dengan tren terkini.",
                                'name' => "Dina Kartika",
                                'title' => "Fashion Enthusiast"
                            ],
                            [
                                'text' => "Saya suka sekali dengan koleksi Minari. Harganya terjangkau tapi kualitasnya premium. Pengiriman juga cepat dan packingnya rapi.",
                                'name' => "Sarah Wijaya",
                                'title' => "Content Creator"
                            ],
                            [
                                'text' => "Sebagai wanita bekerja, saya membutuhkan pakaian yang nyaman tapi tetap stylish. Minari menjawab kebutuhan saya dengan sempurna.",
                                'name' => "Irene Kusuma",
                                'title' => "Marketing Manager"
                            ]
                        ];
                    @endphp                
                    @foreach($testimonials as $testimonial)
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <p>"{{ $testimonial['text'] }}"</p>
                            <div class="customer-info">
                                <div class="customer-avatar"><i class="fas fa-user"></i></div>
                                <div class="customer-details">
                                    <div class="customer-name">{{ $testimonial['name'] }}</div>
                                    <div class="customer-title">{{ $testimonial['title'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
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
                    © {{ date('Y') }} MINARI. All Rights Reserved.
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
</script>
             
        <script src="{{ asset('js/navbar.js') }}"></script>
        <script src="{{ asset('js/landing.js') }}"></script>                
    </body>
</html>