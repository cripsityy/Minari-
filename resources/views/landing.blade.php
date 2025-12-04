<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Your Everyday Fashion Boutique</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    </head>
    <body>
        <header id="navMount"></header>
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="hero-content">
                            <h1>Your Everyday Fashion Boutique</h1>
                            <p>Discover the latest trends in fashion with our exclusive collections designed for your everyday style.</p>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="hero-images">
                            <i class="fas fa-tshirt hero-icon" style="top: 20px; left: 20px;"></i>
                            <i class="fas fa-dress hero-icon" style="bottom: 50px; right: 30px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="style-section">
            <div class="container-fluid">
                <h2 class="section-title">MINARI's Style</h2>
                <div class="style-scroll px-5">
                    @for($i = 1; $i <= 8; $i++)
                    <div class="style-item">
                        <img src="{{ asset('images/g' . $i . '.png') }}" alt="Style {{ $i }}">
                    </div>
                    @endfor
                </div>
            </div>
        </section>
        <section class="category-section" id="categories">
            <div class="container-fluid">
                <h2 class="section-title">Product Category</h2>
                <div class="category-scroll px-5">
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'shirtblouse']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/shirt.png') }}" alt="Shirt">
                            </div>
                            <h3>Shirt and Blouse</h3>
                        </a>
                    </div>
      
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'sweeter']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/sweaters.png') }}" alt="Sweaters">
                            </div>
                            <h3>Sweaters, Cardigan, and Fleece</h3>
                        </a>
                    </div> 
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'tshirt']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/tshirt.png') }}" alt="T-Shirt">
                            </div>
                            <h3>T-shirt and Polo</h3>
                        </a>
                    </div>               
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'pants']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/pants.png') }}" alt="Pants">
                            </div>
                            <h3>Pants</h3>
                        </a>
                    </div>               
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'skirt']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/dress.png') }}" alt="Dress">
                            </div>
                            <h3>Skirt and Dress</h3>
                        </a>
                    </div>              
                    <div class="category-card">
                        <a href="{{ route('category', ['cat' => 'accessories']) }}" style="text-decoration: none;">
                            <div class="category-image">
                                <img src="{{ asset('images/accessories.png') }}" alt="Accessories">
                            </div>
                            <h3>Accessories</h3>
                        </a>
                    </div>
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
            <div class="container">
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