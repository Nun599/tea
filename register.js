class FormAnimator {
    constructor() {
        this.registerForm = document.getElementById('registerForm');
        this.loginForm = document.getElementById('loginForm');
        this.showRegisterLink = document.getElementById('showRegister');
        this.showLoginLink = document.getElementById('showLogin');
        
        this.initEvents();
    }
    
    initEvents() {
        if (this.showRegisterLink) {
            this.showRegisterLink.addEventListener('click', (e) => {
                e.preventDefault();
                this.showRegister();
            });
        }
        
        if (this.showLoginLink) {
            this.showLoginLink.addEventListener('click', (e) => {
                e.preventDefault();
                this.showLogin();
            });
        }
    }
    
    showRegister() {
        // Add slide animation to login form
        this.loginForm.classList.add('slide-left');
        
        // Show register form after a delay
        setTimeout(() => {
            this.loginForm.classList.remove('form-visible');
            this.loginForm.classList.add('form-hidden');
            this.loginForm.classList.remove('slide-left');
            
            this.registerForm.classList.remove('form-hidden');
            this.registerForm.classList.add('form-visible');
            this.registerForm.classList.add('fade-in');
            
            // Remove fade-in class after animation
            setTimeout(() => {
                this.registerForm.classList.remove('fade-in');
            }, 600);
        }, 300);
    }
    
    showLogin() {
        // Add slide animation to register form
        this.registerForm.classList.add('slide-left');
        
        // Show login form after a delay
        setTimeout(() => {
            this.registerForm.classList.remove('form-visible');
            this.registerForm.classList.add('form-hidden');
            this.registerForm.classList.remove('slide-left');
            
            this.loginForm.classList.remove('form-hidden');
            this.loginForm.classList.add('form-visible');
            this.loginForm.classList.add('fade-in');
            
            // Remove fade-in class after animation
            setTimeout(() => {
                this.loginForm.classList.remove('fade-in');
            }, 600);
        }, 300);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new FormAnimator();
});

// Form validation functions
function validateRegisterForm() {
    const form = document.getElementById('registerForm');
    const firstName = form.querySelector('input[name="first_name"]').value.trim();
    const lastName = form.querySelector('input[name="last_name"]').value.trim();
    const email = form.querySelector('input[name="email"]').value.trim();
    const password = form.querySelector('input[name="password"]').value;
    
    // Final validation before submission
    const nameRegex = /^[A-Z][a-zA-Z]*$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/;
    
    if (!nameRegex.test(firstName)) {
        alert('First name must start with capital letter and contain only letters.');
        return false;
    }
    
    if (!nameRegex.test(lastName)) {
        alert('Last name must start with capital letter and contain only letters.');
        return false;
    }
    
    if (!emailRegex.test(email)) {
        alert('Email must be a valid Gmail address (ending with @gmail.com).');
        return false;
    }
    
    if (!passwordRegex.test(password)) {
        alert('Password must have at least 1 uppercase, 1 lowercase, 1 number, 1 special character and minimum 8 characters.');
        return false;
    }
    
    return true;
}

function validateLoginForm() {
    const email = document.querySelector('#loginForm input[name="email"]').value;
    const password = document.querySelector('#loginForm input[name="password"]').value;
    
    if (!email || !password) {
        alert('Please fill in all fields.');
        return false;
    }
    
    return true;
}
