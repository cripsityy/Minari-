document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    
    if (form) {
        form.addEventListener('submit', (e) => {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            
            if (username === 'user' && password === 'user') {
                localStorage.setItem('role', 'user');
                localStorage.setItem('displayName', 'User');
                return true;
            }
            
            if (username === 'admin' && password === 'admin') {
                localStorage.setItem('role', 'admin');
                localStorage.setItem('adminLoggedIn', 'true');
                return true;
            }
            
            return true;
        });
    }
    
    const googleBtn = document.getElementById('googleLogin');
    if (googleBtn) {
        googleBtn.addEventListener('click', () => {
            alert('Google login would be implemented here');
        });
    }
    
    const inputs = document.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.createElement('button');
    toggleBtn.type = 'button';
    toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
    toggleBtn.className = 'btn btn-outline-secondary';
    toggleBtn.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent;';
    
    if (passwordInput) {
        passwordInput.parentElement.style.position = 'relative';
        passwordInput.parentElement.appendChild(toggleBtn);
        
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    }
    
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        setTimeout(() => {
            usernameInput.focus();
        }, 100);
    }
});