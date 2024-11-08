@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="height: 100vh; max-width: 400px;">
    <div class="card shadow-lg w-100" style="border-radius: 20px; background-color: #f4ede3;">
        <div class="card-body text-center">
            <h2 class="mb-4" style="color: #002d25; font-weight: bold;">Welcome Back, <br> Log In!</h2>

            <!-- Displaying error messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="on">
                @csrf
                <div class="mb-3">
                    <input id="email" type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus style="border-radius: 10px;">
                </div>
                <div class="mb-3">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required style="border-radius: 10px;">
                    <input type="checkbox" id="show-password" onclick="togglePassword()"> Show Password
                </div>
                <button type="submit" class="btn btn-dark w-100 mt-3" style="border-radius: 10px; font-weight: bold; background-color: #002d25;">Log In</button>
            </form>
            <p class="mt-4">
                <span class="text-muted">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-dark" style="font-weight: bold; text-decoration: none;">Sign up</a>
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
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const passwordInputType = passwordField.getAttribute('type');

        if (passwordInputType === 'password') {
            passwordField.setAttribute('type', 'text');
        } else {
            passwordField.setAttribute('type', 'password');
        }
    }
</script>
@endsection
