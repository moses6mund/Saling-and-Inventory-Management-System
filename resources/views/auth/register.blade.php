@extends('layouts.app')

@section('content')
<div class="account-content p-4">
    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-userset">
                <div class="login-userheading text-center mb-4">
                    <h3 class="text-primary font-weight-bold">Create an Account</h3>
                    <h4 class="text-muted">Please fill in your information</h4>
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-login mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="form-addons input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                            </div>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   placeholder="Enter your full name"
                                   required />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-login mb-3">
                        <label for="email" class="form-label">Email Address</label>
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
                                   value="{{ old('email') }}"
                                   placeholder="Enter your email address"
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

                    <div class="form-login mb-4">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <div class="pass-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                            </div>
                            <input type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   id="password-confirm"
                                   placeholder="Confirm your password"
                                   required />
                            <div class="input-group-append">
                                <span class="input-group-text bg-white cursor-pointer toggle-confirm-password">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-login mb-4">
                        <button type="submit" class="btn btn-primary btn-block py-2 shadow-sm">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="signinform text-center mb-4">
                    <h4 class="text-muted">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary ml-2 text-decoration-none">
                            Sign In
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="login-img">
            <img src="{{ asset('assets/img/login.jpg') }}" alt="img" class="img-fluid" />
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

.toggle-password,
.toggle-confirm-password {
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
document.addEventListener('DOMContentLoaded', function() {
    // Get all form elements
    const nameInput = document.querySelector('#name');
    const emailInput = document.querySelector('#email');
    const passwordInput = document.querySelector('#password');
    const confirmPasswordInput = document.querySelector('#password-confirm');
    const togglePassword = document.querySelector('.toggle-password');
    const toggleConfirmPassword = document.querySelector('.toggle-confirm-password');

    // Password toggle functionality
    function togglePasswordVisibility(toggleButton, inputField) {
        if (toggleButton && inputField) {
            toggleButton.addEventListener('click', function() {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                
                // Toggle icon
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            });
        }
    }

    // Apply password toggle to both password fields
    togglePasswordVisibility(togglePassword, passwordInput);
    togglePasswordVisibility(toggleConfirmPassword, confirmPasswordInput);

    // Keyboard navigation between fields
    if (nameInput && emailInput) {
        nameInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                emailInput.focus();
            }
        });
    }

    if (emailInput && passwordInput) {
        emailInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                passwordInput.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                nameInput.focus();
            }
        });
    }

    if (passwordInput && confirmPasswordInput) {
        passwordInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                confirmPasswordInput.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                emailInput.focus();
            }
        });
    }

    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                passwordInput.focus();
            }
        });
    }
});
</script>
@endsection
