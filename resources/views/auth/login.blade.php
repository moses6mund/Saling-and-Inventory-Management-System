@extends('layouts.app')

@section('content')
<div class="account-content p-4">
    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-userset">
                <div class="login-userheading text-center mb-4">
                    <h3 class="text-primary font-weight-bold">Sign In</h3>
                    <h4 class="text-muted">Please login to your account</h4>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-login mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="form-addons input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                            </div>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" 
                                   id="email" 
                                   placeholder="Enter your email address"
                                   value="{{ old('email') }}"
                                   required />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-login mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="pass-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                            </div>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   id="password"
                                   placeholder="Enter your password"
                                   required />
                            <div class="input-group-append">
                                <span class="input-group-text bg-white cursor-pointer toggle-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-login mb-3">
                        <div class="d-flex justify-content-end">
                            <a href="#" class="text-primary text-decoration-none">Forgot Password?</a>
                        </div>
                    </div>

                    <div class="form-login mb-4">
                        <button class="btn btn-primary btn-block py-2 shadow-sm" type="submit">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="signinform text-center mb-4">
                    <h4 class="text-muted">
                        Don't have an account?
                        @if (Route::has('register'))
                            <a class="text-primary ml-2 text-decoration-none" href="{{ route('register') }}">
                                Sign Up
                            </a>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        <div class="login-img">
            <img src="assets/img/login.jpg" alt="img" class="img-fluid" />
        </div>
    </div>
</div>

<style>
.account-content {
    min-height: 100vh;
}

.login-wrapper {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    background: #eceaea;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.login-content {
    flex: 1;
    padding: 3rem;
}

.login-img {
    flex: 1;
    display: none;
}

@media (min-width: 992px) {
    .login-img {
        display: block;
    }
    
    .login-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

.login-userheading h3 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.login-userheading h4 {
    font-size: 1rem;
}

.form-addons .input-group-text {
    border-right: 0;
}

.form-addons .form-control {
    border-left: 0;
}

.form-control:focus {
    box-shadow: none;
    border-color: #ced4da;
}

.toggle-password {
    cursor: pointer;
}

.btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-primary:hover {
    background-color: #218838;
    border-color: #218838;
}

.text-primary {
    color: #28a745 !important;
}

.cursor-pointer {
    cursor: pointer;
}

.form-sociallink .btn {
    padding: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.form-sociallink .btn:hover {
    transform: translateY(-2px);
}
</style>

<script>
// Password visibility toggle
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');
    const emailInput = document.querySelector('#email');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the icon
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            }
        });
    }

    // Keyboard navigation from email to password
    if (emailInput && passwordInput) {
        emailInput.addEventListener('keydown', function(e) {
            // Check if the key pressed is the down arrow key
            if (e.key === 'ArrowDown') {
                e.preventDefault(); // Prevent default behavior
                passwordInput.focus(); // Focus on password field
            }
        });
        
        // Keyboard navigation from password to email
        passwordInput.addEventListener('keydown', function(e) {
            // Check if the key pressed is the up arrow key
            if (e.key === 'ArrowUp') {
                e.preventDefault(); // Prevent default behavior
                emailInput.focus(); // Focus on email field
            }
        });
    }
});
</script>
@endsection
