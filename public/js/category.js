// ------------------------
// Helper role (guest / logged in)
// ------------------------
function isGuestRole() {
  try {
    const r = window.NavbarRole?.getRole?.() || localStorage.getItem('role') || 'guest';
    return r === 'guest';
  } catch {
    return (localStorage.getItem('role') || 'guest') === 'guest';
  }
}

// ------------------------
// Data katalog per kategori
// cat = shirtblouse | pants | accessories | sweeter | tshirt | skirt
// ------------------------
const catalog = {
  shirtblouse: {
    title: 'Shirt and Blouse',
    heroImg: 'asset/Desain tanpa judul (11).png',
    products: [
      {name:'Yellow shirt', price:175000, img:'asset/minari produk/photo_1_2025-11-10_22-46-57.jpg'},
      {name:'Creamy white long sleeve shirt', price:275000, img:'asset/minari produk/photo_4_2025-11-10_22-46-57.jpg'},
      {name:'Choco blouse', price:199000, img:'asset/minari produk/photo_9_2025-11-10_22-46-57.jpg'},
      {name:'Blue shirt', price:215000, img:'asset/minari produk/photo_10_2025-11-10_22-46-57.jpg'},
      {name:'White blouse', price:239000, img:'asset/minari produk/photo_2_2025-11-10_22-46-57.jpg'},
      {name:'Blue linen roll-up sleeve shirt', price:189000, img:'asset/minari produk/photo_5_2025-11-10_22-46-57.jpg'},
      {name:'Stripped cream long sleeve shirt', price:259000, img:'asset/minari produk/photo_8_2025-11-10_22-46-57.jpg'},
      {name:'Soft brown long sleeve blouse', price:299000, img:'asset/minari produk/photo_11_2025-11-10_22-46-57.jpg'},
      {name:'Yellow with blue ribbon blouse', price:179000, img:'asset/minari produk/photo_3_2025-11-10_22-46-57.jpg'},
      {name:'Pink baloon shirt', price:189000, img:'asset/minari produk/photo_6_2025-11-10_22-46-57.jpg'},
      {name:'Green jeans crop blouse', price:225000, img:'asset/minari produk/photo_7_2025-11-10_22-46-57.jpg'},
      {name:'Pink long sleeve blouse', price:245000, img:'asset/minari produk/photo_12_2025-11-10_22-46-57.jpg'},
    ]
  },

  pants: {
    title: 'Pants',
    heroImg: 'asset/Desain tanpa judul (13).png',
    products: [
      {name:'Highwaist brown culottes', price:1250000, img:'asset/minari produk/photo_37_2025-11-10_22-46-57.jpg'},
      {name:'Cream trousers', price:200000, img:'asset/minari produk/photo_42_2025-11-10_22-46-57.jpg'},
      {name:'Bone white stripped jeans', price:250000, img:'asset/minari produk/photo_43_2025-11-10_22-46-57.jpg'},
      {name:'Pink sweatpants', price:175000, img:'asset/minari produk/photo_48_2025-11-10_22-46-57.jpg'},
      {name:'White jeans', price:200000, img:'asset/minari produk/photo_38_2025-11-10_22-46-57.jpg'},
      {name:'Light blue flare jeans', price:275000, img:'asset/minari produk/photo_41_2025-11-10_22-46-57.jpg'},
      {name:'Dark blue low rise flare jeans', price:300000, img:'asset/minari produk/photo_44_2025-11-10_22-46-57.jpg'},
      {name:'Light blue straight jeans', price:225000, img:'asset/minari produk/photo_47_2025-11-10_22-46-57.jpg'},
      {name:'Dark blue short jeans', price:250000, img:'asset/minari produk/photo_39_2025-11-10_22-46-57.jpg'},
      {name:'Black short pants', price:175000, img:'asset/minari produk/photo_40_2025-11-10_22-46-57.jpg'},
      {name:'White sweatpants', price:175000, img:'asset/minari produk/photo_45_2025-11-10_22-46-57.jpg'},
      {name:'Highwaist black trousers', price:200000, img:'asset/minari produk/photo_46_2025-11-10_22-46-57.jpg'},
    ]
  },

  accessories: {
    title: 'Accessories',
    heroImg: 'asset/Desain tanpa judul (17).png',
    products: [
      {name:'Crochet lace bonnet', price:75000, img:'asset/minari produk/photo_61_2025-11-10_22-46-57.jpg'},
      {name:'Floral pink organza shawl', price:150000, img:'asset/minari produk/photo_66_2025-11-10_22-46-57.jpg'},
      {name:'Floral baby pink scarf', price:175000, img:'asset/minari produk/photo_67_2025-11-10_22-46-57.jpg'},
      {name:'Floral drop pearl earrings', price:200000, img:'asset/minari produk/photo_72_2025-11-10_22-46-57.jpg'},
      {name:'Enamel Flower Drop Earrings', price:200000, img:'asset/minari produk/photo_62_2025-11-10_22-46-57.jpg'},
      {name:'Enamel Floral Bangles', price:150000, img:'asset/minari produk/photo_65_2025-11-10_22-46-57.jpg'},
      {name:'Pink Floral Shoulder Bag', price:300000, img:'asset/minari produk/photo_68_2025-11-10_22-46-57.jpg'},
      {name:'Baker Boy Hat', price:150000, img:'asset/minari produk/photo_71_2025-11-10_22-46-57.jpg'},
      {name:'Scarf with Apple Appliqué', price:150000, img:'asset/minari produk/photo_63_2025-11-10_22-46-57.jpg'},
      {name:'White Low-Heel Mary Jane Shoes', price:200000, img:'asset/minari produk/photo_64_2025-11-10_22-46-57.jpg'},
      {name:'Pink Platform Mary Jane Heels ', price:300000, img:'asset/minari produk/photo_69_2025-11-10_22-46-57.jpg'},
      {name:'Maroon Mary Jane Shoes', price:300000, img:'asset/minari produk/photo_70_2025-11-10_22-46-57.jpg'},
    ]
  },

  // SWEETER / SWEATER, CARDIGAN, FLEECE
  sweeter: {
    title: 'Sweaters, Cardigan, and Fleece',
    // ganti heroImg ini kalau kamu punya banner khusus
    heroImg: 'asset/Desain tanpa judul (12).png',
    products: [
      {name:'Blue sweater', price:175000, img:'asset/minari produk/photo_13_2025-11-10_22-46-57.jpg'},
      {name:'White crop fleece jacket', price:250000, img:'asset/minari produk/photo_18_2025-11-10_22-46-57.jpg'},
      {name:'Offwhite oversized cardigan', price:250000, img:'asset/minari produk/photo_19_2025-11-10_22-46-57.jpg'},
      {name:'Stripped cream sweater', price:200000, img:'asset/minari produk/photo_24_2025-11-10_22-46-57.jpg'},
      {name:'Dark blue cardigan', price:300000, img:'asset/minari produk/photo_14_2025-11-10_22-46-57.jpg'},
      {name:'Soft green cardigan', price:250000, img:'asset/minari produk/photo_17_2025-11-10_22-46-57.jpg'},
      {name:'Dark green fuzzy knit cardigan', price:300000, img:'asset/minari produk/photo_20_2025-11-10_22-46-57.jpg'},
      {name:'Tiger lily fleece jacket', price:260000, img:'asset/minari produk/photo_23_2025-11-10_22-46-57.jpg'},
      {name:'Cherry white fleece jacket', price:250000, img:'asset/minari produk/photo_15_2025-11-10_22-46-57.jpg'},
      {name:'Baby pinl bow oversized sweater', price:220000, img:'asset/minari produk/photo_16_2025-11-10_22-46-57.jpg'},
      {name:'Maroon bow sweater', price:200000, img:'asset/minari produk/photo_21_2025-11-10_22-46-57.jpg'},
      {name:'Heart rabit fleece jacket', price:300000, img:'asset/minari produk/photo_22_2025-11-10_22-46-57.jpg'},
    ]
  },

  tshirt: {
    title: 'T-Shirts and Polo',
    heroImg: 'asset/Desain tanpa judul (14).png', // bisa kamu ganti kalau perlu
    products: [
      {name:'Puppy off-shoulder T-shirt', price:200000, img:'asset/minari produk/photo_25_2025-11-10_22-46-57.jpg'},
      {name:'Black cat striped pink oversized T-shirt', price:225000, img:'asset/minari produk/photo_30_2025-11-10_22-46-57.jpg'},
      {name:'Grandma pups pink T-shirt', price:200000, img:'asset/minari produk/photo_31_2025-11-10_22-46-57.jpg'},
      {name:'Green apple long sleeve T-shirt', price:225000, img:'asset/minari produk/photo_36_2025-11-10_22-46-57.jpg'},
      {name:'White pearl crop T-shirt', price:250000, img:'asset/minari produk/photo_26_2025-11-10_22-46-57.jpg'},
      {name:'Stripped green polo fitted shirt', price:200000, img:'asset/minari produk/photo_29_2025-11-10_22-46-57.jpg'},
      {name:'Cream polo shirt', price:150000, img:'asset/minari produk/photo_32_2025-11-10_22-46-57.jpg'},
      {name:'Baby pink! polo shirt', price:150000, img:'asset/minari produk/photo_35_2025-11-10_22-46-57.jpg'},
      {name:'White knitted polo shirt', price:250000, img:'asset/minari produk/photo_27_2025-11-10_22-46-57.jpg'},
      {name:'Cream long sleeve T-shirt', price:200000, img:'asset/minari produk/photo_28_2025-11-10_22-46-57.jpg'},
      {name:'Dark blue babydoll T-shirt ', price:175000, img:'asset/minari produk/photo_33_2025-11-10_22-46-57.jpg'},
      {name:'Stripped pink long sleeve polo', price:175000, img:'asset/minari produk/photo_34_2025-11-10_22-46-57.jpg'},
    ]
  },

  skirt: {
    title: 'Skirt and Dress',
    heroImg: 'asset/Desain tanpa judul (16).png', // silakan sesuaikan dengan asset kamu
    products: [
      {name:'Asymmetrical ruffle midi denim skirt', price:275000, img:'asset/minari produk/photo_49_2025-11-10_22-46-57.jpg'},
      {name:'Polka brown midi dress', price:220000, img:'asset/minari produk/photo_54_2025-11-10_22-46-57.jpg'},
      {name:'Ivory tweed flare maxi skirt', price:300000, img:'asset/minari produk/photo_55_2025-11-10_22-46-57.jpg'},
      {name:'White Woven Pleated Midaxi Skirt', price:200000, img:'asset/minari produk/photo_60_2025-11-10_22-46-57.jpg'},
      {name:'Black mid-length dress', price:250000, img:'asset/minari produk/photo_50_2025-11-10_22-46-57.jpg'},
      {name:'Tartan maxi skirt', price:200000, img:'asset/minari produk/photo_53_2025-11-10_22-46-57.jpg'},
      {name:'Floral white maxi skirt', price:200000, img:'asset/minari produk/photo_56_2025-11-10_22-46-57.jpg'},
      {name:'Puff sleeve floral dress', price:250000, img:'asset/minari produk/photo_59_2025-11-10_22-46-57.jpg'},
      {name:'A-line denim maxi skirt', price:250000, img:'asset/minari produk/photo_51_2025-11-10_22-46-57.jpg'},
      {name:'Pinafore cream dress', price:275000, img:'asset/minari produk/photo_52_2025-11-10_22-46-57.jpg'},
      {name:'Rose linen dress', price:275000, img:'asset/minari produk/photo_57_2025-11-10_22-46-57.jpg'},
      {name:'Yellow floral dress', price:250000, img:'asset/minari produk/photo_58_2025-11-10_22-46-57.jpg'},
    ]
  }
};

// ------------------------
// Helper format Rupiah
// ------------------------
const fmtIDR = v =>
  new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
    .format(v)
    .replace('IDR', 'Rp.');

// ------------------------
// Init halaman
// ------------------------
document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const catKey = (params.get('cat') || 'shirtblouse').toLowerCase(); // default shirt & blouse

  const cat = catalog[catKey] || catalog.shirtblouse;

  // Set hero
  const heroImg   = document.getElementById('heroImg');
  const heroTitle = document.getElementById('heroTitle');

  if (heroImg) {
    heroImg.src = cat.heroImg;
    heroImg.alt = cat.title;
  }
  if (heroTitle) {
    heroTitle.textContent = cat.title;
  }

  // Render produk
  const grid = document.getElementById('productGrid');
  if (!grid) return;

  const frag = document.createDocumentFragment();
  cat.products.forEach(p => {
    const col = document.createElement('div');
    col.className = 'col-6 col-md-4 col-lg-3';

    col.innerHTML = `
      <a href="/detailproduk?product={{ urlencode($item->name) }}" class="p-card-link">
        <article class="p-card">
          <div class="p-thumb">
            <img src="${p.img}" alt="${p.name}" loading="lazy">
          </div>
          <div class="p-info">
            <div class="p-info-row">
              <div class="p-text">
                <h6 class="p-name">${p.name}</h6>
                <div class="p-price">${fmtIDR(p.price)}</div>
              </div>
              <div class="p-mini-actions">
                <button class="p-wish" aria-label="Wishlist">
                  <img src="images/whislist.png" alt="wishlist">
                </button>
                <button class="p-cart" aria-label="Add to cart">
                  <img src="images/chart.png" alt="cart">
                </button>
              </div>
            </div>
          </div>
        </article>
      </a>
    `;

    frag.appendChild(col);
  });
  grid.appendChild(frag);

  // Toast & modal
  const toastEl  = document.getElementById('miniToast');
  const toast    = new bootstrap.Toast(toastEl);
  const loginMdl = new bootstrap.Modal(document.getElementById('loginModal'));

  // Delegasi klik
  grid.addEventListener('click', (e) => {
    const wishBtn     = e.target.closest('.p-wish');
    const cartIconBtn = e.target.closest('.p-cart');
    const addBtn      = e.target.closest('.p-add'); // kalau nanti ada tombol Add

    const getName = (btn) =>
      btn?.closest('.p-card')?.querySelector('.p-name')?.textContent || 'Item';

    // Wishlist
    if (wishBtn) {
      e.preventDefault();
      e.stopPropagation();

      if (isGuestRole()) {
        loginMdl.show();
      } else {
        wishBtn.classList.toggle('active');
        toastEl.querySelector('.toast-body').textContent =
          `“${getName(wishBtn)}” has been added to your wishlist.`;
        toast.show();
      }
      return;
    }

    // Add to cart
    if (cartIconBtn || addBtn) {
      e.preventDefault();
      e.stopPropagation();

      toastEl.querySelector('.toast-body').textContent =
        `“${getName(cartIconBtn || addBtn)}” has been added to your cart.`;
      toast.show();
      return;
    }
  });
});
