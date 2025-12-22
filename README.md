# MINARI E-Commerce 🛍️

MINARI adalah aplikasi e-commerce berbasis web yang dibangun menggunakan framework **Laravel**. Aplikasi ini menyediakan platform lengkap untuk pelanggan berbelanja produk fashion dan admin untuk mengelola toko.

---

## 🌟 Fitur Utama

### 👤 Halaman Pengunjung (Customer)
*   **Browsing Produk**: Homepage interaktif, filter Kategori, dan Pencarian produk.
*   **Detail Produk**: Galeri gambar, deskripsi, harga, dan rekomendasi produk terkait.
*   **Keranjang & Checkout**:
    *   Sistem Cart (Keranjang) yang dinamis.
    *   Penerapan **Kode Promo** (Diskon Tetap/Persen).
    *   Pilihan Pembayaran: COD (Cash on Delivery) & Transfer Bank (Simulasi).
    *   Manajemen Alamat Pengiriman.
*   **User Area**:
    *   **Login & Register** customer.
    *   **Wishlist**: Simpan produk favorit.
    *   **Riwayat Pesanan**: Lacak status pesanan (`Pending`, `Processing`, `Shipped`, `Delivered`).
    *   **Rating & Review**: 
        *   Tombol "Rate Product" muncul di halaman **Detail Order** setelah pesanan berstatus `Delivered` atau `Completed`.
        *   Review ditampilkan dalam bentuk list vertikal di halaman produk.

### 🛡️ Halaman Admin
*   **Dashboard**: Ringkasan statistik (Total Penjualan, Order Baru, Produk Terlaris).
*   **Manajemen Produk**: Tambah, Edit, Hapus produk (termasuk upload gambar).
*   **Manajemen Kategori**: Kelola kategori produk.
*   **Manajemen Promosi**: Buat dan atur kode voucher/diskon.
*   **Manajemen Pesanan**: Update status pesanan (Terima/Tolak/Kirim Resi) dan update status pembayaran.
*   **Manajemen Review**: Moderasi ulasan customer.
*   **Kotak Saran**: Melihat pesan/saran dari customer.
*   **Fitur Pencarian (Search)**:
    *   Tersedia di navbar atas untuk mencari Produk, Order, Review, dan Customer.
    *   Khusus di halaman **Dashboard**, fitur pencarian dinonaktifkan untuk menjaga tampilan ringkasan.

---

## 🛠️ Teknologi yang Digunakan

*   **Framework PHP**: Laravel 10.x
*   **Bahasa**: PHP, JavaScript (Vanilla/ES6)
*   **Database**: MySQL
*   **Frontend**: Blade Templates, Bootstrap 5, Custom CSS
*   **Icons**: Font Awesome

---

## 🚀 Cara Instalasi

Ikuti langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### Prasyarat
*   PHP >= 8.1
*   Composer
*   MySQL

### Langkah-langkah

1.  **Clone Repository** (atau ekstrak file zip)
    ```bash
    git clone https://github.com/username/minari.git
    cd minari
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Setup Environment**
    *   Duplikasi file `.env.example` menjadi `.env`.
    *   Sesuaikan konfigurasi database di file `.env`:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=db_minari  # Sesuaikan dengan nama database Anda
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrate & Seed Database**
    ```bash
    php artisan migrate:fresh --seed
    ```
    *(Perintah ini akan membuat tabel dan mengisi data dummy awal)*

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000` di browser Anda.

7.  **Setup Storage Link** (Agar gambar produk muncul)
    ```bash
    php artisan storage:link
    ```

---

## 🔑 Akun Default (Seeder)

Jika Anda menggunakan seeder bawaan, gunakan akun berikut untuk login:

**Admin:**
*   Email: `admin@paml.com`
*   Password: `password`

**User (Contoh):**
*   Email: `user@paml.com` (atau register akun baru)
*   Password: `password`

---

## 📝 Catatan Implementasi
*   **Pembayaran**: Status pembayaran default untuk metode transfer adalah `pending`. Admin perlu memverifikasi bukti bayar (manual) dan mengubah status menjadi `paid` di menu Orders. Untuk COD, status awal juga `pending`.
*   **Rating**: User hanya bisa memberikan rating satu kali per item pesanan.

---
*Created by Minari Team*
