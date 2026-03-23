@extends('layouts.app')

@section('title', __('auth.login'))

@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <!-- Header Section -->
        <div class="login-header">
            <div class="logo-container">
                <!-- Replace src with the actual logo image -->
                <img src="{{ asset('images/logo.png') }}" alt="IL2 Logo" class="logo" onerror="this.src='https://placehold.co/180x90/ffffff/0f2b60?text=IL%C2%B2+Logo'">
            </div>
            <h1 class="login-title">{{ __('auth.login') }}</h1>
        </div>

        <!-- Role Switch Toggle -->
        <div class="role-toggle-container">
            <div class="role-toggle">
                <input type="radio" id="role-learner" name="role" value="learner" checked>
                <label for="role-learner" class="toggle-btn" id="label-learner">{{ __('auth.learner') }}</label>

                <input type="radio" id="role-guide" name="role" value="guide">
                <label for="role-guide" class="toggle-btn" id="label-guide">{{ __('auth.guide') }}</label>

                <div class="toggle-slider"></div>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('login.post') }}" method="POST" class="auth-form" id="loginForm">
            @csrf

            @if (session('status'))
                <div style="color: #166534; background: #dcfce7; border: 1px solid #86efac; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px; font-size: 13px;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color: #991b1b; background: #fee2e2; border: 1px solid #fca5a5; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px; font-size: 13px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="input-group">
                <input type="text" id="username" name="username" placeholder="{{ __('auth.email') }}" required>
            </div>

            <div class="input-group password-group">
                <input type="password" id="password" name="password" placeholder="{{ __('auth.password') }}" required>
                <button type="button" class="toggle-password" aria-label="Toggle Password Visibility">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>

            <div class="forgot-password-container">
                <a href="{{ route('password.request') }}" class="forgot-password-link">{{ __('auth.forgot_password') }}</a>
            </div>

            <div class="form-actions row-actions">
                <button type="submit" class="btn btn-primary">{{ __('auth.login') }}</button>
                <span class="divider-text">{{ __('common.or') ?? 'OR' }}</span>
                <button type="button" class="btn btn-google">
                    <svg viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ __('auth.login_google') ?? 'Login with Google' }}
                </button>
            </div>
        </form>

        <div class="signup-container">
            <p>{{ __('auth.no_account') ?? "Don't have an Account?" }} <a href="{{ route('register') }}" class="signup-link">{{ __('auth.sign_up') }}</a></p>
        </div>

    </div>
</div>
@endsection

