@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="height: 100vh; max-width: 400px;">
    <div class="card shadow-lg w-100" style="border-radius: 20px; background-color: #f4ede3;">
        <div class="card-body text-center">
            <h2 class="mb-4" style="color: #002d25; font-weight: bold;">Welcome, <br> Sign up!</h2>
            <form method="POST" action="{{ route('register') }}" id="registerForm" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <input id="name" type="text" name="name" class="form-control" placeholder="Name" required autofocus style="border-radius: 10px;">
                    <span class="text-danger" id="nameError"></span>
                </div>
                <div class="mb-3">
                    <input id="email" type="email" name="email" class="form-control" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" style="border-radius: 10px;" oninput="validateEmail()">
                    <span class="text-danger" id="emailError"></span>
                </div>
                <div class="mb-3 position-relative">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required style="border-radius: 10px;">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                        👁️
                    </span>
                    <span class="text-danger" id="passwordError"></span>
                </div>
                <div class="mb-3 position-relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required style="border-radius: 10px;">
                    <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                        👁️
                    </span>
                </div>
                <button type="submit" class="btn btn-dark w-100 mt-3" style="border-radius: 10px; font-weight: bold; background-color: #002d25;">Sign up</button>
            </form>
            <p class="mt-4">
                <span class="text-muted">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-dark" style="font-weight: bold; text-decoration: none;">Sign in</a>
            </p>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #002d25;
    }
    .form-control {
        border: 1px solid #ced4da;
    }
</style>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        // Reset error messages and disable submit button
        clearErrors();
        const submitButton = event.target.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        if (!validateEmail()) {
            submitButton.disabled = false;
            return;
        }

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.ok) {
                window.location.href = "{{ route('login') }}";
            } else {
                const errorData = await response.json();
                showErrors(errorData.errors);
                submitButton.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            submitButton.disabled = false;
        }
    });

    function validateEmail() {
        const emailField = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(emailField.value)) {
            emailError.textContent = 'Invalid email format';
            return false;
        }
        emailError.textContent = '';
        return true;
    }

    function showErrors(errors) {
        if (errors.name) document.getElementById('nameError').textContent = errors.name[0];
        if (errors.email) document.getElementById('emailError').textContent = errors.email[0];
        if (errors.password) document.getElementById('passwordError').textContent = errors.password[0];
    }

    function clearErrors() {
        document.getElementById('nameError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
    }

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
