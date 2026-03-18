<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('panel.site_title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f7f7;
            --ink: #13212e;
            --muted: #4d5a63;
            --card: #ffffff;
            --line: #d8e0e3;
            --brand: #0f766e;
            --brand-2: #16a34a;
            --accent: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 10%, rgba(15, 118, 110, 0.18), transparent 28%),
                radial-gradient(circle at 85% 20%, rgba(245, 158, 11, 0.14), transparent 30%),
                linear-gradient(180deg, #f8fbfb 0%, #edf3f3 100%);
            min-height: 100vh;
        }

        .wrap {
            max-width: 1180px;
            margin: 0 auto;
            padding: 28px 20px 56px;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--ink);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(145deg, var(--brand), #0b4f56);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border-radius: 12px;
            padding: 11px 16px;
            font-weight: 600;
            border: 1px solid transparent;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.8);
            color: var(--ink);
            border-color: var(--line);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand), var(--brand-2));
            color: #fff;
            box-shadow: 0 10px 24px rgba(15, 118, 110, 0.3);
        }

        .hero {
            margin-top: 34px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 26px;
        }

        .hero-card,
        .panel {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 16px 44px rgba(10, 35, 45, 0.08);
        }

        .hero-card {
            padding: 36px;
            position: relative;
            overflow: hidden;
        }

        .hero-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            right: -80px;
            top: -90px;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.2), transparent 65%);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--brand);
            font-weight: 700;
            background: rgba(15, 118, 110, 0.1);
            border: 1px solid rgba(15, 118, 110, 0.22);
            border-radius: 999px;
            padding: 6px 10px;
        }

        h1 {
            margin: 16px 0 12px;
            font-size: clamp(30px, 5vw, 52px);
            line-height: 1.04;
            letter-spacing: -0.03em;
        }

        .lead {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            max-width: 60ch;
        }

        .cta {
            margin-top: 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .stats {
            margin-top: 26px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .stat {
            background: #f7faf9;
            border: 1px solid #e2ece9;
            border-radius: 14px;
            padding: 12px;
        }

        .stat strong {
            display: block;
            font-size: 20px;
        }

        .stat span {
            color: var(--muted);
            font-size: 12px;
        }

        .panel {
            padding: 20px;
        }

        .panel h2 {
            margin: 4px 0 14px;
            font-size: 20px;
            letter-spacing: -0.02em;
        }

        .feature {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid #eef3f4;
        }

        .feature:first-of-type {
            border-top: none;
        }

        .dot {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 9px;
            display: grid;
            place-items: center;
            background: rgba(245, 158, 11, 0.14);
            color: #9a6600;
            font-size: 14px;
            font-weight: 700;
        }

        .feature p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.55;
        }

        .footer-note {
            margin-top: 20px;
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 940px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-card,
            .panel {
                border-radius: 16px;
            }
        }

        @media (max-width: 640px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .hero-card {
                padding: 24px;
            }

            .nav {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <header class="nav">
            <a class="brand" href="{{ route('landing') }}">
                <span class="brand-mark">{{ strtoupper(substr(trans('panel.site_title'), 0, 1)) }}</span>
                <span>{{ trans('panel.site_title') }}</span>
            </a>
            <div class="nav-actions">
                <a class="btn btn-outline" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary" href="{{ route('agency.register') }}">Register as Agency</a>
            </div>
        </header>

        <section class="hero">
            <article class="hero-card">
                <span class="eyebrow">Trusted Agency Network</span>
                <h1>Check client reputation before you commit your team.</h1>
                <p class="lead">
                    A focused workspace for agencies to share verified client experiences, report disputes, and make better go/no-go decisions with confidence.
                </p>

                <div class="cta">
                    <a class="btn btn-primary" href="{{ route('agency.register') }}">Create Agency Account</a>
                    <a class="btn btn-outline" href="{{ route('login') }}">Already Registered? Login</a>
                </div>

                <div class="stats">
                    <div class="stat">
                        <strong>Fast</strong>
                        <span>Agency onboarding with admin approval</span>
                    </div>
                    <div class="stat">
                        <strong>Clear</strong>
                        <span>Client records with rating summaries</span>
                    </div>
                    <div class="stat">
                        <strong>Practical</strong>
                        <span>Disputes, feedback, and notifications</span>
                    </div>
                </div>
            </article>

            <aside class="panel">
                <h2>How It Works</h2>

                <div class="feature">
                    <span class="dot">1</span>
                    <p>Register your agency profile and submit basic contact information.</p>
                </div>
                <div class="feature">
                    <span class="dot">2</span>
                    <p>Admin reviews and approves your account for trusted participation.</p>
                </div>
                <div class="feature">
                    <span class="dot">3</span>
                    <p>Search clients, view dispute history, and submit ratings and feedback.</p>
                </div>
                <div class="feature">
                    <span class="dot">4</span>
                    <p>Use notification center to stay updated on approvals and platform activity.</p>
                </div>

                <p class="footer-note">
                    Designed for agency owners who need quick, reliable context before taking on new client work.
                </p>
            </aside>
        </section>
    </div>
</body>

</html>
