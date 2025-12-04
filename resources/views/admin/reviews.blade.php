<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MINARI - Review</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
    </head>
    <body>
        <nav class="navbar-custom fixed-top">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center w-100 px-5">
                    <div class="logo">
                        <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                    </div>
                    <div class="navbar-icons">
                        <img src="{{ asset('images/notification.png') }}" alt="Favorite" width="24" height="24"></a>
                        <img src="{{ asset('images/searchnav.png') }}" alt="Search" width="24" height="24"></a>
                        <img src="{{ asset('images/email.png') }}" alt="Cart" width="24" height="24"></a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
                <i class="fas fa-table-columns"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products') }}" class="sidebar-item">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-item">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-item">
                <i class="fas fa-file-invoice"></i>
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.customers') }}" class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.reviews') }}" class="sidebar-item active">
                <i class="fas fa-thumbs-up"></i>
                <span>Review</span>
            </a>
            <a href="{{ route('admin.promotions') }}" class="sidebar-item">
                <i class="fas fa-ad"></i>
                <span>Promotions</span>
            </a>
        </div>
        
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Reviews</h2>
            </div>

            <div class="filter-section">
                <input type="text" class="search-box" placeholder="Search reviews...">
                <button class="filter-btn active">All Review</button>
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
                        <tr>
                            <td>White Jeans</td>
                            <td>Anneiza</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </td>
                            <td>Bahannya gak kaku dan bagus banget! Warna sesuai foto juga, pengiriman cepat. Bakal order lagi</td>
                            <td>28 Oct 2025</td>
                        </tr>
                        <tr>
                            <td>Blue Shirt</td>
                            <td>Lisa</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </td>
                            <td>Motifnya bagus tapi bahan agak tipis, jadi harus pakai inner. Semoga kualitas ditingkatkan ya</td>
                            <td>28 Oct 2025</td>
                        </tr>
                        <tr>
                            <td>Soft green cardigan</td>
                            <td>Aliyah</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </td>
                            <td>Modelnya lucu, cuma agak kebesaran di bagian bahu. Tapi overall oke banget buat outfit santai</td>
                            <td>27 Oct 2025</td>
                        </tr>
                        <tr>
                            <td>Cherry white long sleeve shirt</td>
                            <td>Karina</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span>
                            </td>
                            <td>Nyaman banget dipakai, bahan lembut tapi sedikit transparan. Tetap suka karena potongannya pas!</td>
                            <td>27 Oct 2025</td>
                        </tr>
                        <tr>
                            <td>Green jeans crop blouse</td>
                            <td>Elsa</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </td>
                            <td>Lucu banget crop top-nya! Bahannya lembut dan lentur, nggak panas dipakai.</td>
                            <td>25 Oct 2025</td>
                        </tr>
                        <tr>
                            <td>Dark blue low rise flare jeans</td>
                            <td>Cantika</td>
                            <td>
                                <span style="color: #f3a8a8;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </td>
                            <td>Sumpah ini jeans-nya nyaman banget dipakai! Bahannya stretch tapi tetap tebal</td>
                            <td>25 Oct 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <footer>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="logo">
                            <img src="{{ asset('images/logofix.png') }}" alt="Logo MINARI" style="height: 40px; width: auto;">
                        </div>
                        <p>Your everyday fashion boutique</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>Give us suggestions for future progress</p>
                        <div class="footer-form">
                            <input type="text" placeholder="your message . . .">
                            <button>Send</button>
                        </div>
                    </div>
                </div>
                <div class="footer-divider"></div>
                <div class="copyright">
                    © 2025 MINARI. All Rights Reserved.
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/navigation.js') }}"></script>
    </body>
</html>