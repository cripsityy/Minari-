/* Wishlist page logic - Integrated with Laravel API */

// Configuration
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
const IS_AUTHENTICATED = window.IS_AUTHENTICATED || false;

// Format price to IDR
const fmtIDR = (v) => {
    if (!v) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(v).replace('IDR', 'Rp').replace(/\s/g, '');
};

// Helper functions
function showToast(msg) {
    const el = document.getElementById('miniToast');
    if (!el) return;
    el.querySelector('.toast-body').textContent = msg;
    new bootstrap.Toast(el).show();
}

function asset(path) {
    return new URL(path, location.origin).toString();
}

// API functions
async function fetchWishlist() {
    try {
        const response = await fetch('/api/wishlist', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.status === 401) {
            return null; // Unauthorized
        }

        if (!response.ok) throw new Error('Failed to fetch wishlist');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        return [];
    }
}

async function removeFromWishlist(id) {
    try {
        const response = await fetch(`/api/wishlist/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        });
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        return { success: false, message: 'Network error' };
    }
}

async function addToCart(productId) {
    try {
        const response = await fetch('/api/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1,
                size: '',
                color: ''
            })
        });
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        return { success: false, message: 'Network error' };
    }
}

// Render functions
function renderGuestView() {
    const content = document.getElementById('wishContent');
    if (!content) return;

    content.innerHTML = `
        <div class="container">
            <h1 class="wish-title">Wishlist</h1>
            <div class="guest-message text-center py-5">
                <h3 class="mb-3">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Log in to save your favorite items</p>
                <a href="/login" class="btn btn-primary">Log In</a>
                <a href="/register" class="btn btn-outline-primary ms-2">Sign Up</a>
            </div>
        </div>
    `;
}

function renderWishlistItems(items) {
    const root = document.getElementById('wishList');
    const counter = document.getElementById('resultCount');

    if (!root || !counter) return;

    counter.textContent = `Results: ${items.length} product${items.length !== 1 ? 's' : ''}`;

    if (items.length === 0) {
        root.innerHTML = `
            <div class="empty-wishlist text-center py-5">
                <h3 class="mb-3">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Start adding items you love!</p>
                <a href="/category" class="btn btn-primary">Browse Products</a>
            </div>
        `;
        return;
    }

    root.innerHTML = items.map(item => {
        const product = item.product || item;
        // Use image_url from API if available, otherwise fallback
        // const imageUrl = product.image_url || ((product.image && product.image.startsWith('http')) ? product.image : `/storage/${product.image}`);

        return `
            <article class="w-item" data-id="${product.id}" data-wishlist-id="${item.id}" data-slug="${product.slug}" style="cursor: pointer;">
                <div class="w-img">
                    <img src="${product.image_url || product.image}" alt="${product.name}" 
                         onerror="this.src='/images/default-product.jpg'">
                </div>
                <div class="w-info">
                    <h6 class="w-name">${product.name}</h6>
                    <div class="w-meta">
                        <span class="price">${fmtIDR(product.final_price || product.price)}</span>
                        ${product.size ? `<span>Size: ${product.size}</span>` : ''}
                    </div>
                </div>
                <div class="w-actions">
                    <button class="w-btn js-addcart" data-id="${product.id}">
                        Add to cart
                    </button>
                    <button class="w-remove js-remove" data-id="${item.id}" title="Remove from wishlist">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </article>
        `;
    }).join('');
}

// Main
document.addEventListener('DOMContentLoaded', async () => {
    if (!IS_AUTHENTICATED) {
        renderGuestView();
        return;
    }

    const items = await fetchWishlist();
    if (items === null) {
        // Session expired
        renderGuestView();
        return;
    }

    renderWishlistItems(items);

    // Event listeners
    const wishListContainer = document.getElementById('wishList');
    if (wishListContainer) {
        wishListContainer.addEventListener('click', async (e) => {
            const removeBtn = e.target.closest('.js-remove');
            const addCartBtn = e.target.closest('.js-addcart');
            const card = e.target.closest('.w-item');

            if (!card) return;

            if (removeBtn) {
                const wishlistId = card.dataset.wishlistId;
                // Immediate UI feedback
                const previousHtml = card.outerHTML;
                card.style.opacity = '0.5';

                const result = await removeFromWishlist(wishlistId);
                if (result.success) {
                    showToast(result.message || 'Removed from wishlist');

                    // Update navbar badge
                    if (result.wishlist_count !== undefined && window.NavbarRole && window.NavbarRole.updateWishlistCount) {
                        window.NavbarRole.updateWishlistCount(result.wishlist_count);
                    }

                    // Refresh list or remove item from DOM
                    card.remove();

                    // If empty, re-check to show empty state
                    const remainingItems = document.querySelectorAll('.w-item');
                    if (remainingItems.length === 0) {
                        const items = await fetchWishlist(); // Fetch to be sure/render empty state
                        renderWishlistItems(items || []);
                    } else {
                        // Update count text manually if not refetching
                        const counter = document.getElementById('resultCount');
                        if (counter) counter.textContent = `Results: ${remainingItems.length} product${remainingItems.length !== 1 ? 's' : ''}`;
                    }

                } else {
                    card.style.opacity = '1';
                    showToast(result.message);
                }
                return; // Stop here, don't navigate
            }

            if (addCartBtn) {
                const productId = card.dataset.id;
                const result = await addToCart(productId);
                if (result.success) {
                    showToast('Added to cart');
                    // Update navbar badge
                    if (result.cart_count !== undefined && window.NavbarRole && window.NavbarRole.updateCartCount) {
                        window.NavbarRole.updateCartCount(result.cart_count);
                    }
                } else {
                    showToast(result.message);
                }
                return; // Stop here, don't navigate
            }

            // Navigation (if not clicking buttons)
            if (card.dataset.slug) {
                window.location.href = `/product/${card.dataset.slug}`;
            }
        });
    }
});