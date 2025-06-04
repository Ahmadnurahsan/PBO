@extends('layouts.app') {{-- Pastikan layout ini ada dan benar --}}

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 text-center"><i class="fas fa-sign-in-alt me-2"></i>Login to Your Account</h4>
                </div>

                <div class="card-body p-4">
                    {{-- Menampilkan error login global jika ada (misalnya dari AuthController) --}}
                    @if($errors->has('email') && !$errors->has('password')) {{-- Cek khusus untuk error 'email' global --}}
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('email') }}
                        </div>
                    @endif


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email', 'login') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@example.com">
                            @error('email', 'login') {{-- 'login' adalah nama error bag, bisa diabaikan jika tidak set di controller --}}
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input id="password" type="password" class="form-control @error('password', 'login') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                            @error('password', 'login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>

                        {{-- Opsional: Link lupa password --}}
                        {{-- @if (Route::has('password.request'))
                            <div class="text-center mb-3">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        @endif --}}

                        <hr>

                        <p class="text-center mb-0">
                            Don't have an account? <a href="{{ route('register') }}">Register here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection