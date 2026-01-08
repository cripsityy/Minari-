{{-- Toast Notifications Partial --}}
@if(session('success'))
    <div class="toast-notification success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="toast-notification error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast-notification');
        toasts.forEach(toast => {
            // Show animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Auto hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300); // Remove from DOM after transition
            }, 3000);
        });
    });

    // Global Toast Function
    window.showToast = function(message, type = 'success') {
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        // Remove existing toasts to prevent stacking (optional, but cleaner)
        const existingToasts = document.querySelectorAll('.toast-notification');
        existingToasts.forEach(t => t.remove());

        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <i class="fas ${icon}"></i>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        // Animation
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };
</script>

<style>
    .toast-notification {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 99999; /* Higher z-index to ensure it's above everything */
        background: white;
        padding: 12px 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        transform: translateX(150%);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-size: 14px;
        font-weight: 500;
        max-width: 350px;
    }
    .toast-notification.show {
        transform: translateX(0);
    }
    .toast-notification.success {
        border-left: 4px solid #198754;
        color: #0f5132;
    }
    .toast-notification.error {
        border-left: 4px solid #dc3545;
        color: #842029;
    }
    .toast-notification i {
        font-size: 18px;
    }
</style>
