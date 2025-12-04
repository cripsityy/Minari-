const Role = { GUEST: 'guest', USER: 'user', ADMIN: 'admin' };

function getRole() { 
    try {
        return localStorage.getItem('role') || Role.GUEST; 
    } catch (e) {
        return Role.GUEST;
    }
}

function setRole(r) { 
    try {
        localStorage.setItem('role', r); 
    } catch (e) {
        console.error('Error setting role:', e);
    }
}

function clearRole() { 
    try {
        localStorage.removeItem('role'); 
        localStorage.removeItem('adminLoggedIn');
    } catch (e) {
        console.error('Error clearing role:', e);
    }
}

function tplGuest() {
    const isAdminPage = window.location.pathname.includes('/admin/');
    
    if (isAdminPage) {
        return '';
    }
    
    return `
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
            </a>

            <div class="d-flex align-items-center ms-auto gap-3">
                <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Account">
                    <img src="/images/akun.png" alt="User" width="24" height="24">
                </button>
                <a href="/user/whislist"><img src="/images/whislist.png" alt="Favorite" width="24" height="24"></a>
                <a href="/user/search"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
                <a href="/user/cart"><img src="/images/chart.png" alt="Cart" width="24" height="24"></a>
                <a href="/user/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
            </div>
        </div>
    </nav>

    <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
        <div class="accmini__row">
            <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
            <a id="accMiniName" href="/user/account/guest" class="accmini__name">Guest</a>
        </div>
        <a id="accMiniBtn" class="accmini__btn" href="/login">Log in</a>
    </div>`;
}

function tplUser() {
    return `
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
            </a>

            <div class="d-flex align-items-center ms-auto gap-3">
                <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Account">
                    <img src="/images/akun.png" alt="User" width="24" height="24">
                </button>
                <a href="/user/whislist"><img src="/images/whislist.png" alt="Favorite" width="24" height="24"></a>
                <a href="/user/search"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
                <a href="/user/cart"><img src="/images/chart.png" alt="Cart" width="24" height="24"></a>
                <a href="/user/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
            </div>
        </div>
    </nav>

    <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
        <div class="accmini__row">
            <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
            <a class="accmini__link" href="/user/account" style="text-decoration: none; color: black;">Account</a>
        </div>
        
        <div class="accmini__row">
            <img src="/images/order history.png" width="16" height="16" class="accmini__icon" alt="">
            <a class="accmini__link" href="/user/order-history" style="text-decoration: none; color: black;">Order history</a>
        </div>
       
        <a id="accMiniBtn" class="accmini__btn" href="/logout">Log out</a>
    </div>`;
}

function tplAdmin() {
    const isAdminPage = window.location.pathname.includes('/admin/');
    
    if (!isAdminPage) {
        return '';
    }
    
    return `
    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logofix.png" alt="MINARI Logo" width="100" height="auto" class="me-2">
            </a>

            <div class="d-flex align-items-center ms-auto gap-3">
                <button id="accBtn" class="btn p-0 border-0 bg-transparent" aria-label="Admin">
                    <img src="/images/akun.png" alt="Admin" width="24" height="24">
                </button>
                <a href="/user/search"><img src="/images/searchnav.png" alt="Search" width="24" height="24"></a>
                <a href="/admin/dashboard"><img src="/images/add.png" alt="dashboard" width="24" height="24"></a>
                <a href="/user/menu"><img src="/images/menu.png" alt="Menu" width="24" height="24"></a>
            </div>
        </div>
    </nav>

    <div id="accMini" class="accmini" aria-hidden="true" role="dialog">
        <div class="accmini__row">
            <img src="/images/akun.png" width="16" height="16" class="accmini__icon" alt="">
            <a class="accmini__link" href="/admin/account" style="text-decoration: none; color: black;">Account</a>
        </div>
        
        <div class="accmini__row">
            <img src="/images/add.png" width="16" height="16" class="accmini__icon" alt="">
            <a class="accmini__link" href="/admin/dashboard" style="text-decoration: none; color: black;">Dashboard</a>
        </div>
       
        <a id="accMiniBtn" class="accmini__btn" href="/logout">Log out</a>
    </div>`;
}

function renderNavbar() {
    const mount = document.getElementById('navMount');
    if (!mount) return;

    let role = getRole();
    
    if (window.location.pathname.includes('/admin/')) {
        role = Role.ADMIN;
    }
    
    const html = role === Role.ADMIN ? tplAdmin() :
                 role === Role.USER ? tplUser() :
                 tplGuest();
    
    if (html) {
        mount.innerHTML = html;
    } else {
        mount.innerHTML = '';
        return;
    }

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
    const accBtn = document.getElementById('accBtn');

    function positionMenu(){
        if (!accMini || !accBtn) return;
        const r = accBtn.getBoundingClientRect();
        accMini.style.top = `${r.bottom + 10}px`;
        accMini.style.left = `${r.left - (220 - r.width)}px`;
    }

    function openMenu(){
        if (!accMini || !accBtn) return;
        positionMenu();
        accMini.classList.add('show');

        document.addEventListener('click', onDocClick, true);
        document.addEventListener('keydown', onKey);
        window.addEventListener('resize', positionMenu);
        window.addEventListener('scroll', positionMenu, { passive: true });
    }

    function closeMenu(){
        if (!accMini) return;
        accMini.classList.remove('show');
        document.removeEventListener('click', onDocClick, true);
        document.removeEventListener('keydown', onKey);
        window.removeEventListener('resize', positionMenu);
        window.removeEventListener('scroll', positionMenu);
    }

    function onDocClick(e){
        if (accMini?.contains(e.target) || accBtn?.contains(e.target)) return;
        closeMenu();
    }

    function onKey(e){ if (e.key === 'Escape') closeMenu(); }

    if (accBtn && accMini) {
        accBtn.addEventListener('click', (e) => {
            e.preventDefault();
            accMini.classList.contains('show') ? closeMenu() : openMenu();
        });
    }

    setTimeout(() => {
        const nav = document.querySelector('#navMount .navbar');
        if (nav) {
            const h = nav.offsetHeight;
            document.documentElement.style.setProperty('--nav-h', h + 'px');
        }
    }, 100);
}

document.addEventListener('DOMContentLoaded', renderNavbar);

window.NavbarRole = { setRole, getRole, clearRole, Role };