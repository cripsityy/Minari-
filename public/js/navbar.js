// ====== Role utils ======
const Role = {
  GUEST: 'guest',
  USER: 'user',
  ADMIN: 'admin'
};

function getRole() {
  // Ambil dari Laravel (window.APP_ROLE), default guest
  return window.APP_ROLE || Role.GUEST;
}
function setRole(r) {
  window.APP_ROLE = r;
}
function clearRole() {
  window.APP_ROLE = Role.GUEST;
}

// ====== Templates ======
function tplGuest() {
  return `
  <nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">
      <a class="navbar-brand" href="/b">
        <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
      </a>

      <div class="d-flex align-items-center ms-auto gap-3">
        <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Account">
          <img src="/images/akun.png" alt="User" width="24" height="24">
        </button>
        <a href="/wishlist"><img src="/images/whislist.png" alt="Favorite" width="24" height="24"></a>
        <a href="/menu"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
        <a href="/cart"><img src="/images/chart.png" alt="Cart" width="24" height="24"></a>
        <a href="/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
      </div>
    </div>
  </nav>

  <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
    <div class="accmini__row">
      <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
      <a id="accMiniName" class="accmini__name" href="/account">Guest</a>
    </div>
    <a id="accMiniBtn" class="accmini__btn" href="/login">Log in</a>
  </div>`;
}

function tplUser() {
  return `
  <nav class="navbar navbar-expand-lg sticky-top py-3">
    <div class="container">
      <a class="navbar-brand" href="/b">
        <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
      </a>

      <div class="d-flex align-items-center ms-auto gap-3">
        <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Account">
          <img src="/images/akun.png" alt="User" width="24" height="24">
        </button>
        <a href="/wishlist"><img src="/images/whislist.png" alt="Favorite" width="24" height="24"></a>
        <a href="/menu"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
        <a href="/cart"><img src="/images/chart.png" alt="Cart" width="24" height="24"></a>
        <a href="/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
      </div>
    </div>
  </nav>

  <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
    <div class="accmini__row">
      <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
      <a id="accMiniName" class="accmini__link" href="/akun" style="text-decoration: none; color: black;">Account</a>
    </div>

    <div class="accmini__row">
      <img src="/images/order history.png" width="16" height="16" class="accmini__icon" alt="">
      <a class="accmini__link" href="/orders/history" style="text-decoration: none; color: black;">Order history</a>
    </div>

    <a id="accMiniBtn" class="accmini__btn" href="#">Log out</a>
  </div>`;
}

function tplAdmin() {
  return `
  <nav class="navbar navbar-expand-lg sticky-top py-3">
    <div class="container">
      <a class="navbar-brand" href="/b">
        <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
      </a>

      <div class="d-flex align-items-center ms-auto gap-3">
        <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Admin">
          <img src="/images/akun.png" alt="Admin" width="24" height="24">
        </button>
        <a href="/menu"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
        <a href="/admin/dashboard"><img src="/images/add.png" alt="dashboard" width="24" height="24"></a>
        <a href="/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
      </div>
    </div>
  </nav>

  <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
    <div class="accmini__row">
      <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
      <a id="accMiniName" class="accmini__link" href="/user/account" style="text-decoration: none; color: black;">Admin</a>
    </div>

    <div class="accmini__row">
      <img src="/images/add.png" width="16" height="16" class="accmini__icon" alt="">
      <a class="accmini__link" href="/admin/dashboard" style="text-decoration: none; color: black;">Dashboard</a>
    </div>

    <a id="accMiniBtn" class="accmini__btn" href="#">Log out</a>
  </div>`;
}

// ====== Render + Interaksi ======
function renderNavbar() {
  const mount = document.getElementById('navMount');
  if (!mount) return;

  const role = getRole();

  mount.innerHTML =
    role === Role.ADMIN ? tplAdmin()
  : role === Role.USER  ? tplUser()
  : tplGuest();

  const navbar = mount.querySelector('.navbar');
  if (navbar) {
    const onScroll = () => {
      if (window.scrollY > 50) navbar.classList.add('scrolled');
      else navbar.classList.remove('scrolled');
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  const accMini = document.getElementById('accMini');
  const accBtn  = document.getElementById('accBtn');
  const nameEl  = document.getElementById('accMiniName');
  const btn     = document.getElementById('accMiniBtn');

  function doLogout() {
    clearRole();
    closeMenu();
    location.href = '/logout'; // <-- route logout Laravel
  }

  function syncUI() {
    if (!nameEl || !btn) return;

    const r = getRole();

    if (r === Role.USER) {
      nameEl.textContent = 'Account';
      btn.textContent = 'Log out';
      btn.onclick = (e) => {
        e.preventDefault();
        doLogout();
      };
    } else if (r === Role.ADMIN) {
      nameEl.textContent = 'Admin';
      btn.textContent = 'Log out';
      btn.onclick = (e) => {
        e.preventDefault();
        doLogout();
      };
    } else {
      nameEl.textContent = 'Guest';
      btn.textContent = 'Log in';
      btn.setAttribute('href', '/login');
      btn.onclick = null;
    }
  }

  function positionMenu() {
    if (!accMini || !accBtn) return;
    const r = accBtn.getBoundingClientRect();
    accMini.style.top  = `${r.bottom + 10}px`;
    accMini.style.left = `${r.left - (220 - r.width)}px`;
  }

  function onDocClick(e) {
    if (accMini.contains(e.target) || accBtn.contains(e.target)) return;
    closeMenu();
  }
  function onKey(e) {
    if (e.key === 'Escape') closeMenu();
  }

  function openMenu() {
    if (!accMini || !accBtn) return;
    syncUI();
    positionMenu();
    accMini.classList.add('show');

    document.addEventListener('click', onDocClick, true);
    document.addEventListener('keydown', onKey);
    window.addEventListener('resize', positionMenu);
    window.addEventListener('scroll', positionMenu, { passive: true });
  }

  function closeMenu() {
    if (!accMini) return;
    accMini.classList.remove('show');

    document.removeEventListener('click', onDocClick, true);
    document.removeEventListener('keydown', onKey);
    window.removeEventListener('resize', positionMenu);
    window.removeEventListener('scroll', positionMenu);
  }

  if (accBtn && accMini) {
    accBtn.addEventListener('click', (e) => {
      e.preventDefault();
      accMini.classList.contains('show') ? closeMenu() : openMenu();
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('#navMount .navbar');
    if (!nav) return;
    const h = nav.offsetHeight;
    document.documentElement.style.setProperty('--nav-h', h + 'px');
  });
}

document.addEventListener('DOMContentLoaded', renderNavbar);

// Expose (kalau mau dipakai di halaman lain)
window.NavbarRole = { setRole, getRole, clearRole, Role };
