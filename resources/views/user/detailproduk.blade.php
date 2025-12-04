<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MINARI - Yellow Shirt</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/detailproduk.css') }}">
</head>
<body>

  <header id="navMount"></header>

  <main class="container-detail">
    <div class="product">
      {{-- ganti path gambar sesuai file kamu --}}
      <img src="{{ asset('asset/yellow-shirt.jpg') }}" alt="Yellow Shirt">
      <div class="mdet">
        <div class="details">
          <h2>Yellow shirt</h2>
          <p class="price">Rp. 175.000,00</p>

          <div>
            <h4>Description</h4>
            <p class="desc">
              Kemeja wanita berlengan pendek berbahan katun lembut dengan motif kotak-kotak kuning,
              nyaman dipakai untuk gaya kasual sehari-hari.
            </p>
          </div>

          <div class="category">
            <h4>Category</h4>
            <span>Shirt and Blouse</span>
          </div>

          <div>
            Rating <br>
            <span class="rating">★★★★☆</span>
          </div>

          <div class="quantity">
            <button id="minus">-</button>
            <span id="count">0</span>
            <button id="plus">+</button>
          </div>

          <button class="add-to-cart">Add to cart</button>
        </div>
      </div>
    </div>
  </main>

  <section class="review-section">
    <h3>Review</h3>
    <div class="review-box">
      <div class="profile">
        <img src="{{ asset('asset/profile.jpg') }}" alt="Profile">
      </div>
      <div class="review-content">
        <h4>e*****s</h4>
        <div class="stars">★★★★☆</div>
        <p class="review-text">
          Bahannya gak kaku dan bagus banget! Warna sesuai foto juga, pengiriman cepat. Bakal order lagi.
        </p>
        <a class="lihat-lainnya" href="{{ route('user.review') }}">Lihat lainnya >></a>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- kirim role Laravel ke JS/navbar --}}
  <script>
    window.APP_ROLE = "{{ session('role') ?? 'guest' }}";
  </script>

  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/detailproduk.js') }}"></script>
</body>
</html>
