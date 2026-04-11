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
            radial-gradient(circle at 10% 15%, rgba(25, 75, 104, 0.13), transparent 34%),
            radial-gradient(circle at 88% 88%, rgba(31, 139, 95, 0.11), transparent 32%),
            #eef5f4;
    }

    .reg-shell {
        min-height: calc(100vh - 48px);
        display: grid;
        place-items: center;
        padding: 22px 0;
    }

    .reg-card {
        width: 100%;
        max-width: 980px;
        border-radius: 22px;
        border: 1px solid var(--line);
        background: #fff;
        box-shadow: 0 24px 56px rgba(9, 34, 40, 0.15);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .reg-side {
        padding: 34px 30px;
        background:
            radial-gradient(circle at 12% 20%, rgba(255, 255, 255, 0.24), transparent 40%),
            linear-gradient(165deg, #194b68 0%, #0f766e 55%, #1f8b5f 100%);
        color: #eefcff;
    }

    .reg-side h2 {
        margin: 10px 0;
        font-size: 30px;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .reg-side p {
        margin: 0;
        color: rgba(238, 252, 255, 0.9);
        line-height: 1.65;
        max-width: 33ch;
    }

    .reg-badge {
        display: inline-flex;
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .reg-points {
        margin: 18px 0 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 10px;
    }

    .reg-points li {
        display: flex;
        gap: 8px;
        align-items: center;
        font-size: 14px;
    }

    .reg-no {
        width: 18px;
        height: 18px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.22);
        display: grid;
        place-items: center;
        font-size: 11px;
    }

    .reg-form {
        padding: 34px 30px;
        background: #fcfefe;
    }

    .reg-title {
        margin: 0;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .reg-sub {
        margin: 8px 0 16px;
        color: var(--muted);
        font-size: 14px;
    }

    .reg-note {
        margin-bottom: 14px;
        border: 1px solid #b9dfd4;
        background: #edf9f4;
        color: #155d53;
        border-radius: 12px;
        padding: 9px 11px;
        font-size: 13px;
    }

    .reg-field {
        margin-bottom: 12px;
    }

    .reg-label {
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #2a4654;
    }

    .reg-input {
        width: 100%;
        border-radius: 12px;
        border: 1px solid var(--line);
        padding: 11px 13px;
        background: #fff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .reg-input:focus {
        outline: none;
        border-color: #7fb8a8;
        box-shadow: 0 0 0 4px rgba(31, 139, 95, 0.14);
    }

    .reg-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .reg-actions {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .reg-btn {
        border: 0;
        border-radius: 12px;
        padding: 11px 16px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--brand), var(--brand-2));
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.27);
    }

    .reg-login {
        color: #0f5f66;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }

    .err {
        margin-top: 5px;
        color: #c0362c;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .reg-card {
            grid-template-columns: 1fr;
        }

        .reg-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="reg-shell">
    <section class="reg-card">
        <aside class="reg-side">
            <span class="reg-badge">Agency Onboarding</span>
            <h2>Create your agency account</h2>
            <p>Join the network to verify client reputation, publish feedback, and collaborate with other agencies responsibly.</p>

            <ul class="reg-points">
                <li><span class="reg-no">1</span> Submit your basic agency profile</li>
                <li><span class="reg-no">2</span> Verify your email address</li>
                <li><span class="reg-no">3</span> Access full portal features after verification</li>
            </ul>
        </aside>

        <div class="reg-form">
            <h3 class="reg-title">Register as Agency</h3>
            <p class="reg-sub">Verify your email after signup to unlock reporting and rating actions.</p>

            <div class="reg-note">Email verification is required before you can submit disputes or ratings.</div>

            <form method="POST" action="{{ route('agency.register.store') }}">
                @csrf

                <div class="reg-field">
                    <label class="reg-label" for="name">Name</label>
                    <input id="name" type="text" class="reg-input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')<div class="err">{{ $message }}</div>@enderror
                </div>

                <div class="reg-row">
                    <div class="reg-field">
                        <label class="reg-label" for="email">Email Address</label>
                        <input id="email" type="email" class="reg-input" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="reg-field">
                        <label class="reg-label" for="mobile">Mobile</label>
                        <input id="mobile" type="text" class="reg-input" name="mobile" value="{{ old('mobile') }}" autocomplete="mobile" required>
                        @error('mobile')<div class="err">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="reg-field">
                    <label class="reg-label" for="company_name">Company Name</label>
                    <input id="company_name" type="text" class="reg-input" name="company_name" value="{{ old('company_name') }}" autocomplete="organization" required>
                    @error('company_name')<div class="err">{{ $message }}</div>@enderror
                </div>

                <div class="reg-field">
                    <label class="reg-label" for="website">Website (Optional)</label>
                    <input id="website" type="url" class="reg-input" name="website" value="{{ old('website') }}" autocomplete="url">
                    @error('website')<div class="err">{{ $message }}</div>@enderror
                </div>

                <div class="reg-row">
                    <div class="reg-field">
                        <label class="reg-label" for="password">Password</label>
                        <input id="password" type="password" class="reg-input" name="password" required autocomplete="new-password">
                        @error('password')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="reg-field">
                        <label class="reg-label" for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="reg-input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="reg-actions">
                    <button type="submit" class="reg-btn">Register</button>
                    <a class="reg-login" href="{{ route('login') }}">Already registered? Login</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
