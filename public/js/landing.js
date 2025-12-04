function redirectToLogin() {
    window.location.href = '/login';
}

function redirectToDashboard() {
    window.location.href = '/admin/dashboard';
}

function redirectToLanding() {
    window.location.href = '/';
}

function handleLogin(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    if (username === 'admin' && password === 'admin') {
        localStorage.setItem('adminLoggedIn', 'true');
        localStorage.setItem('role', 'admin');
        redirectToDashboard();
    } else {
        alert('Invalid username or password. Try: admin/admin');
    }
}

function handleLogout() {
    localStorage.removeItem('adminLoggedIn');
    localStorage.removeItem('role');
    redirectToLogin();
}

document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    
    if (navbar) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.style-scroll, .category-scroll').forEach(scrollArea => {
        let scrollInterval;
        
        scrollArea.addEventListener('mousemove', (e) => {
            const rect = scrollArea.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const center = rect.width / 2;
            
            clearInterval(scrollInterval);
            scrollInterval = setInterval(() => {
                const speed = 15;
                if (x > center + 50) {
                    scrollArea.scrollLeft += speed;
                } else if (x < center - 50) {
                    scrollArea.scrollLeft -= speed;
                }
            }, 20);
        });
        
        scrollArea.addEventListener('mouseleave', () => {
            clearInterval(scrollInterval);
        });
        
        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        prevBtn.className = 'scroll-btn scroll-prev';
        prevBtn.style.cssText = 'position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.8); border: none; border-radius: 50%; width: 40px; height: 40px; z-index: 10;';
        
        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        nextBtn.className = 'scroll-btn scroll-next';
        nextBtn.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.8); border: none; border-radius: 50%; width: 40px; height: 40px; z-index: 10;';
        
        scrollArea.parentElement.style.position = 'relative';
        scrollArea.parentElement.appendChild(prevBtn);
        scrollArea.parentElement.appendChild(nextBtn);
        
        prevBtn.addEventListener('click', () => {
            scrollArea.scrollLeft -= 300;
        });
        
        nextBtn.addEventListener('click', () => {
            scrollArea.scrollLeft += 300;
        });
    });
});

function checkLoginStatus() {
    const isLoggedIn = localStorage.getItem('adminLoggedIn');
    const currentPath = window.location.pathname;
    
    const adminPaths = [
        '/admin/dashboard',
        '/admin/products',
        '/admin/categories',
        '/admin/orders',
        '/admin/customers',
        '/admin/reviews',
        '/admin/promotions'
    ];
    
    if (adminPaths.includes(currentPath) && !isLoggedIn) {
        redirectToLogin();
        return false;
    }
    
    return true;
}

document.addEventListener("DOMContentLoaded", function() {
    const suggestionForm = document.querySelector('footer form');
    if (suggestionForm) {
        suggestionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = this.querySelector('input[name="message"]').value;
            
            if (message.trim() === '') {
                alert('Please enter your suggestion');
                return;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('Thank you for your suggestion!');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 15px 30px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.08)';
        });
    });
    
    const testimonials = document.querySelectorAll('.testimonial-card');
    if (testimonials.length > 0) {
        let currentTestimonial = 0;
        
        function showTestimonial(index) {
            testimonials.forEach((testimonial, i) => {
                testimonial.style.display = i === index ? 'block' : 'none';
            });
        }
        
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }, 5000);
    }
    
    if (window.location.pathname.includes('/admin/')) {
        checkLoginStatus();
    }
});