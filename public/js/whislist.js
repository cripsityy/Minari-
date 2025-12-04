/* Wishlist page logic
   Storage keys:
   - role: 'guest' | 'user' | 'admin'
   - wishlistItems: [{id,name,price,size,img}]
   - cartItems: [{id,name,price,size,img,qty}]
*/
// Bangun URL absolut yang aman (spasi dll) relatif ke halaman saat ini
function imgUrl(relPath) {
  return new URL(relPath, document.baseURI).toString();
}
function asset(pathFromRoot) {
  // menerima path yang diawali '/' mis: '/asset/xxx.jpg'
  return new URL(pathFromRoot, location.origin).toString();
}


function getRoleSafe(){
  try { return window.NavbarRole?.getRole?.() || localStorage.getItem('role') || 'guest'; }
  catch { return localStorage.getItem('role') || 'guest'; }
}

const fmtIDR = (v)=> new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR'})
  .format(v).replace('IDR','Rp').replace(/\s/g,'');

function readWishlist(){
  try { return JSON.parse(localStorage.getItem('wishlistItems')||'[]'); }
  catch { return []; }
}
function writeWishlist(data){
  localStorage.setItem('wishlistItems', JSON.stringify(data));
}
function readCart(){
  try { return JSON.parse(localStorage.getItem('cartItems')||'[]'); }
  catch { return []; }
}
function writeCart(data){
  localStorage.setItem('cartItems', JSON.stringify(data));
}




function showToast(msg){
  const el = document.getElementById('miniToast');
  if (!el) return;
  el.querySelector('.toast-body').textContent = msg;
  new bootstrap.Toast(el).show();
}

function renderList(items){
  const root = document.getElementById('wishList');
  const counter = document.getElementById('resultCount');
  if (!root) return;

  counter.textContent = `Results: ${items.length} product${items.length!==1?'s':''}`;

  root.innerHTML = items.map(p => {
    const src = asset(p.img); // pastikan absolut
    const fallback = asset('/asset/placeholder.png'); // <-- pastikan file ini ada
    return `
      <article class="w-item" data-id="${p.id}">
        <div class="w-img">
          <img src="${src}" alt="${p.name}"
               onerror="console.error('IMG 404:', this.src); this.onerror=null; this.src='${fallback}';">
        </div>
        <div class="w-info">
          <h6 class="w-name">${p.name}</h6>
          <div class="w-meta"><span>${fmtIDR(p.price)}</span></div>
        </div>
        <div class="w-actions">
          <button class="w-btn js-addcart">Add to shopping cart</button>
          <button class="w-heart js-remove" title="Remove from wishlist" aria-label="Remove">
            <svg viewBox="0 0 24 24"><path d="M12 21s-6.716-4.297-9.428-7.009C.842 12.261.5 10.34 1.414 8.9 2.55 7.14 4.92 6.69 6.57 7.86 7.37 8.43 8 9.3 8 9.3s.63-.87 1.43-1.44c1.65-1.17 4.02-.72 5.16 1.04.91 1.44.57 3.36-1.16 5.1C18.716 16.703 12 21 12 21z"/></svg>
          </button>
        </div>
      </article>
    `;
  }).join('');
}


function sortItems(arr, type){
  const a = [...arr];
  switch(type){
    case 'price-asc':  a.sort((x,y)=>x.price-y.price); break;
    case 'price-desc': a.sort((x,y)=>y.price-x.price); break;
    case 'name-asc':   a.sort((x,y)=>x.name.localeCompare(y.name)); break;
    case 'name-desc':  a.sort((x,y)=>y.name.localeCompare(x.name)); break;
    default: break; // recent (do nothing)
  }
  return a;
}

document.addEventListener('DOMContentLoaded', () => {
  const role = getRoleSafe();

  const gate = document.getElementById('gate');
  const content = document.getElementById('wishContent');

  if (role === 'guest'){
    gate.style.display = '';
    content.style.display = 'none';
    const loginBtn = document.getElementById('loginBtn');
    if (loginBtn) loginBtn.href = '/login';
    return;
  }

  // Logged in
  gate.style.display = 'none';
  content.style.display = '';

  ensureDemoData();

  let items = readWishlist();
  renderList(items);

  // sort
  const sortSel = document.getElementById('sortSelect');
  sortSel.addEventListener('change', ()=>{
    renderList(sortItems(items, sortSel.value));
  });

  // delegate actions
  document.getElementById('wishList').addEventListener('click', (e)=>{
    const card = e.target.closest('.w-item');
    if (!card) return;
    const id = card.dataset.id;

    // Remove (heart)
    if (e.target.closest('.js-remove')){
      items = items.filter(x=>x.id!==id);
      writeWishlist(items);
      renderList(sortItems(items, sortSel.value));
      showToast('Removed from wishlist.');
      return;
    }

    // Add to cart
    if (e.target.closest('.js-addcart')){
      const item = items.find(x=>x.id===id);
      const cart = readCart();
      const idx = cart.findIndex(c=>c.id===id && (c.size||'')===(item.size||''));
      if (idx>-1) cart[idx].qty += 1;
      else cart.push({...item, qty:1});
      writeCart(cart);
      showToast('Added to shopping cart.');
    }
  });
});
