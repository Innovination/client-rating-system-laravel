@extends('layouts.app')

@section('styles')
<style>
    :root {
        --ink: #13232f;
        --muted: #55707f;
        --line: #d6e2e4;
        --card: #ffffff;
        --brand: #0f766e;
        --brand-2: #1d9f7a;
    }

    body.login-page {
        background:
            radial-gradient(circle at 12% 10%, rgba(15, 118, 110, 0.12), transparent 35%),
            radial-gradient(circle at 90% 90%, rgba(29, 159, 122, 0.1), transparent 30%),
            #eef5f4;
    }

    .auth-shell {
        min-height: calc(100vh - 48px);
        display: grid;
        place-items: center;
        padding: 22px 0;
    }

    .auth-stage {
        width: 100%;
        max-width: 980px;
        border-radius: 22px;
        border: 1px solid var(--line);
        background: var(--card);
        box-shadow: 0 24px 56px rgba(9, 34, 40, 0.15);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .auth-side {
        position: relative;
        padding: 34px 30px;
        background:
            radial-gradient(circle at 18% 20%, rgba(255, 255, 255, 0.25), transparent 40%),
            radial-gradient(circle at 90% 100%, rgba(255, 255, 255, 0.15), transparent 46%),
            linear-gradient(160deg, #0f766e 0%, #0f5f66 52%, #1f8b5f 100%);
        color: #ecfffb;
    }

    .auth-pill {
        display: inline-flex;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 999px;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
    }

    .auth-side h2 {
        margin: 14px 0 10px;
        font-size: 30px;
        line-height: 1.1;
        letter-spacing: -0.02em;
        color: #fff;
    }

    .auth-side p {
        margin: 0;
        color: rgba(239, 255, 252, 0.88);
        line-height: 1.65;
        max-width: 32ch;
    }

    .auth-list {
        margin: 20px 0 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 10px;
    }

    .auth-list li {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .auth-dot {
        width: 18px;
        height: 18px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.22);
        display: inline-grid;
        place-items: center;
        font-size: 11px;
    }

    .auth-form-wrap {
        padding: 34px 30px;
        background: #fcfefe;
    }

    .auth-title {
        margin: 0;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .auth-sub {
        margin: 8px 0 20px;
        color: var(--muted);
        font-size: 14px;
    }

    .auth-field {
        margin-bottom: 13px;
    }

    .auth-label {
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #2a4654;
    }

    .auth-input {
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #fff;
        padding: 11px 13px;
        width: 100%;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .auth-input:focus {
        outline: none;
        border-color: #7fb8a8;
        box-shadow: 0 0 0 4px rgba(31, 139, 95, 0.14);
    }

    .auth-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .auth-btn {
        border: 0;
        border-radius: 12px;
        padding: 11px 16px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--brand), var(--brand-2));
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.27);
    }

    .auth-links a {
        color: #0f5f66;
        text-decoration: none;
        font-weight: 600;
        margin-left: 12px;
        font-size: 13px;
    }

    .auth-links a:first-child {
        margin-left: 0;
    }

    .alert-soft {
        border-radius: 12px;
        border: 1px solid #f2d39f;
        background: #fff6e8;
        color: #8a5a08;
        padding: 10px 12px;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .error-text {
        margin-top: 5px;
        color: #c0362c;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .auth-stage {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="auth-shell">
    <section class="auth-stage">
        <aside class="auth-side">
            <span class="auth-pill">Agency Portal</span>
            <h2>Welcome back to {{ trans('panel.site_title') }}</h2>
            <p>Sign in to monitor client reputation, review disputes, and stay on top of approval and moderation activity.</p>
            <ul class="auth-list">
                <li><span class="auth-dot">1</span> Search client history before accepting projects</li>
                <li><span class="auth-dot">2</span> Submit disputes and track responses</li>
                <li><span class="auth-dot">3</span> Receive notifications in one place</li>
            </ul>
        </aside>

        <div class="auth-form-wrap">
            <h3 class="auth-title">Login</h3>
            <p class="auth-sub">Use your agency account to continue.</p>

            @if(session('message'))
                <div class="alert-soft">{{ session('message') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label class="auth-label" for="email">{{ trans('global.login_email') }}</label>
                    <input id="email" name="email" type="email" class="auth-input" required autocomplete="email" autofocus value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <div class="error-text">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="auth-field">
                    <label class="auth-label" for="password">{{ trans('global.login_password') }}</label>
                    <input id="password" name="password" type="password" class="auth-input" required>
                    @if($errors->has('password'))
                        <div class="error-text">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="d-flex align-items-center" style="gap:8px; margin: 6px 0 8px;">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember" style="position: static; margin: 0;">
                    <label class="mb-0" for="remember" style="font-size:13px; color:#3c5966;">{{ trans('global.remember_me') }}</label>
                </div>

                <div class="auth-actions">
                    <button type="submit" class="auth-btn">{{ trans('global.login') }}</button>
                    <div class="auth-links">
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
                        @endif
                        <a href="{{ route('agency.register') }}">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
