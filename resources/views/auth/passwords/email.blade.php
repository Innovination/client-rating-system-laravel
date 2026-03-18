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

    .fp-shell {
        min-height: calc(100vh - 48px);
        display: grid;
        place-items: center;
        padding: 22px 0;
    }

    .fp-card {
        width: 100%;
        max-width: 920px;
        border-radius: 22px;
        border: 1px solid var(--line);
        background: var(--card);
        box-shadow: 0 24px 56px rgba(9, 34, 40, 0.15);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .fp-side {
        padding: 34px 30px;
        background:
            radial-gradient(circle at 18% 20%, rgba(255, 255, 255, 0.25), transparent 40%),
            radial-gradient(circle at 90% 100%, rgba(255, 255, 255, 0.15), transparent 46%),
            linear-gradient(160deg, #0f766e 0%, #0f5f66 52%, #1f8b5f 100%);
        color: #ecfffb;
    }

    .fp-side h2 {
        margin: 8px 0 10px;
        font-size: 30px;
        line-height: 1.1;
        letter-spacing: -0.02em;
        color: #fff;
    }

    .fp-side p {
        margin: 0;
        color: rgba(239, 255, 252, 0.9);
        line-height: 1.65;
        max-width: 30ch;
    }

    .fp-form {
        padding: 34px 30px;
        background: #fcfefe;
    }

    .fp-title {
        margin: 0;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .fp-sub {
        margin: 8px 0 18px;
        color: var(--muted);
        font-size: 14px;
    }

    .fp-alert {
        border-radius: 12px;
        border: 1px solid #b9dfd4;
        background: #edf9f4;
        color: #155d53;
        padding: 10px 12px;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .fp-label {
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #2a4654;
    }

    .fp-input {
        width: 100%;
        border-radius: 12px;
        border: 1px solid var(--line);
        padding: 11px 13px;
        background: #fff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .fp-input:focus {
        outline: none;
        border-color: #7fb8a8;
        box-shadow: 0 0 0 4px rgba(31, 139, 95, 0.14);
    }

    .fp-error {
        margin-top: 5px;
        color: #c0362c;
        font-size: 12px;
    }

    .fp-actions {
        margin-top: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .fp-btn {
        border: 0;
        border-radius: 12px;
        padding: 11px 16px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--brand), var(--brand-2));
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.27);
    }

    .fp-back {
        color: #0f5f66;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }

    @media (max-width: 900px) {
        .fp-card {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="fp-shell">
    <section class="fp-card">
        <aside class="fp-side">
            <h2>Reset your password</h2>
            <p>Enter your agency email and we will send you a secure password reset link.</p>
        </aside>

        <div class="fp-form">
            <h3 class="fp-title">{{ trans('global.reset_password') }}</h3>
            <p class="fp-sub">We will email a link to set a new password.</p>

            @if(session('status'))
                <div class="fp-alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <label class="fp-label" for="email">{{ trans('global.login_email') }}</label>
                <input id="email" type="email" class="fp-input" name="email" required autocomplete="email" autofocus value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="fp-error">{{ $errors->first('email') }}</div>
                @endif

                <div class="fp-actions">
                    <button type="submit" class="fp-btn">{{ trans('global.send_password') }}</button>
                    <a class="fp-back" href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
