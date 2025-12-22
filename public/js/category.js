// ------------------------
// Helper role (guest / logged in)
// ------------------------
function isGuestRole() {
  try {
    const r = window.NavbarRole?.getRole?.() || window.APP_ROLE || 'guest';
    return r === 'guest';
  } catch {
    return (window.APP_ROLE || 'guest') === 'guest';
  }
}

// ------------------------
// Helper format Rupiah
// ------------------------
const fmtIDR = v => {
  if (!v) return 'Rp 0';
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' })
    .format(v)
    .replace('IDR', 'Rp')
    .replace(/\s/g, '');
};

// ------------------------
// Cart & Wishlist Functions
// ------------------------

// addToCart is now handled by cart.js (window.addToCart)

/**
 * Updates the visual state of the wishlist button
 * @param {HTMLElement} btn - The button element
 * @param {boolean} isActive - Desired state (true = active/red, false = inactive/default)
 */
function updateWishlistUI(btn, isActive) {
  if (!btn) return;

  if (isActive) {
    btn.classList.add('active');

    // Image
    const img = btn.querySelector('img');
    if (img) img.src = "/images/whislist-active.png";

    // Icon
    const icon = btn.querySelector('i');
    if (icon) {
      icon.classList.remove('far');
      icon.classList.add('fas', 'text-danger');
    }
  } else {
    btn.classList.remove('active');

    // Image
    const img = btn.querySelector('img');
    if (img) img.src = "/images/whislist.png";

    // Icon
    const icon = btn.querySelector('i');
    if (icon) {
      icon.classList.remove('fas', 'text-danger');
      icon.classList.add('far');
    }
  }
}

// Main entry point for wishlist button click
function addToWishlist(productId, buttonElement) {
  if (isGuestRole()) {
    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
    loginModal.show();
    return;
  }

  // Get product name for toast message
  const productCard = buttonElement?.closest('[data-product-id]');
  const productName = productCard ? productCard.querySelector('.p-name')?.textContent : 'Product';

  // Check current state to decide action
  const isCurrentlyActive = buttonElement.classList.contains('active');

  if (isCurrentlyActive) {
    // User wants to REMOVE
    removeFromWishlist(productId, buttonElement, productName);
  } else {
    // User wants to ADD
    performAddWishlist(productId, buttonElement, productName);
  }
}

function performAddWishlist(productId, buttonElement, productName) {
  // Optimistic UI Update: Set to Active
  updateWishlistUI(buttonElement, true);

  // Optimistic Badge Update
  if (window.NavbarRole?.updateWishlistCount) {
    const current = Number(window.WISHLIST_COUNT || 0);
    window.NavbarRole.updateWishlistCount(current + 1);
  }

  fetch('/api/wishlist', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.CSRF_TOKEN || document.querySelector('meta[name="csrf-token"]')?.content
    },
    body: JSON.stringify({ product_id: productId })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast(`"${productName}" has been added to your wishlist.`);
      } else {
        // Failed (e.g. already exists, or error)
        if (data.message && (data.message.includes('already') || data.message.includes('sudah ada'))) {
          // It's already there. Ensure UI is active.
          updateWishlistUI(buttonElement, true);
          showToast(`"${productName}" is already in your wishlist.`);
          // Revert badge if we optimistic incremented
          if (window.NavbarRole?.updateWishlistCount) {
            const current = Number(window.WISHLIST_COUNT || 0);
            window.NavbarRole.updateWishlistCount(Math.max(0, current - 1));
          }
        } else {
          // Generic error, revert UI
          updateWishlistUI(buttonElement, false);
          showToast(data.message || 'Failed to add to wishlist.', true);
          // Revert badge
          if (window.NavbarRole?.updateWishlistCount) {
            const current = Number(window.WISHLIST_COUNT || 0);
            window.NavbarRole.updateWishlistCount(Math.max(0, current - 1));
          }
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Revert UI on network error
      updateWishlistUI(buttonElement, false);
      showToast('An error occurred. Please try again.', true);
      // Revert badge
      if (window.NavbarRole?.updateWishlistCount) {
        const current = Number(window.WISHLIST_COUNT || 0);
        window.NavbarRole.updateWishlistCount(Math.max(0, current - 1));
      }
    });
}

function removeFromWishlist(productId, buttonElement, productName) {
  // Optimistic UI Update: Set to Inactive
  updateWishlistUI(buttonElement, false);

  // Optimistic Badge Update
  if (window.NavbarRole?.updateWishlistCount) {
    const current = Number(window.WISHLIST_COUNT || 0);
    window.NavbarRole.updateWishlistCount(Math.max(0, current - 1));
  }

  fetch(`/api/wishlist/${productId}`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': window.CSRF_TOKEN || document.querySelector('meta[name="csrf-token"]')?.content
    }
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showToast(`"${productName}" removed from wishlist.`);
        // Update navbar count with server truth
        if (window.NavbarRole?.updateWishlistCount && data.wishlist_count !== undefined) {
          window.NavbarRole.updateWishlistCount(data.wishlist_count);
        }
      } else {
        // Failed to remove, revert UI to Active
        updateWishlistUI(buttonElement, true);
        showToast(data.message || 'Failed to remove from wishlist.', true);
        // Revert badge (increment back)
        if (window.NavbarRole?.updateWishlistCount) {
          const current = Number(window.WISHLIST_COUNT || 0);
          window.NavbarRole.updateWishlistCount(current + 1);
        }
      }
    })
    .catch(error => {
      console.error('Error:', error);
      // Revert UI
      updateWishlistUI(buttonElement, true);
      // Revert badge
      if (window.NavbarRole?.updateWishlistCount) {
        const current = Number(window.WISHLIST_COUNT || 0);
        window.NavbarRole.updateWishlistCount(current + 1);
      }
    });
}

// ------------------------
// Toast Function
// ------------------------
function showToast(message, isError = false) {
  const toastEl = document.getElementById('miniToast');
  const toastBody = document.getElementById('toastMessage');

  if (!toastEl || !toastBody) return;

  // Update message
  toastBody.textContent = message;

  // Change color for error messages
  if (isError) {
    toastEl.querySelector('.toast-body').style.color = 'var(--danger)';
  } else {
    toastEl.querySelector('.toast-body').style.color = '';
  }

  // Show toast
  const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
  toast.show();
}

// ------------------------
// Initialize Event Listeners
// ------------------------
document.addEventListener('DOMContentLoaded', () => {
  // Initialize Bootstrap toast
  const toastEl = document.getElementById('miniToast');
  if (toastEl) {
    toastEl.addEventListener('hidden.bs.toast', () => {
      const toastBody = document.getElementById('toastMessage');
      if (toastBody) toastBody.style.color = '';
    });
  }

  // Add hover effects for wishlist buttons
  const wishButtons = document.querySelectorAll('.p-wish');
  wishButtons.forEach(button => {
    // Check initial state (if product is already in wishlist)
    // This would require an API call to check - for simplicity, we'll assume not

    button.addEventListener('mouseenter', function () {
      if (!this.classList.contains('active')) {
        const img = this.querySelector('img');
        if (img) {
          img.src = "/images/whislist-hover.png";
        }
      }
    });

    button.addEventListener('mouseleave', function () {
      if (!this.classList.contains('active')) {
        const img = this.querySelector('img');
        if (img) {
          img.src = "/images/whislist.png";
        }
      }
    });
  });

  // Add click animation for cart buttons
  const cartButtons = document.querySelectorAll('.p-cart');
  cartButtons.forEach(button => {
    button.addEventListener('click', function (e) {
      // Add bounce animation
      this.style.transform = 'scale(0.9)';
      setTimeout(() => {
        this.style.transform = '';
      }, 200);
    });
  });
});