@extends('layouts.app')

@section('styles')
<style>
    :root {
        --brand:    #0f766e;
        --brand-dk: #0d6560;
        --brand-lt: #e6f4f3;
        --ink:      #0f1f26;
        --muted:    #5a737d;
        --line:     #dde8ea;
        --bg:       #f3f7f8;
        --card:     #ffffff;
        --radius:   12px;
        --shadow:   0 2px 12px rgba(15,118,110,.08);
    }

    * { box-sizing: border-box; }

    body { background: var(--bg); font-family: 'Segoe UI', system-ui, sans-serif; }

    /* ── Hero ────────────────────────────────────────────── */
    .dir-hero {
        background: linear-gradient(135deg, #0d6560 0%, #1a9e8f 60%, #22c5b2 100%);
        padding: 56px 20px 48px;
        text-align: center;
        color: #fff;
    }
    .dir-hero h1 {
        font-size: clamp(1.6rem, 4vw, 2.4rem);
        font-weight: 700;
        margin: 0 0 8px;
        letter-spacing: -.5px;
    }
    .dir-hero p {
        opacity: .85;
        font-size: .95rem;
        margin: 0 0 28px;
    }

    /* ── Search bar ──────────────────────────────────────── */
    .search-wrap {
        max-width: 600px;
        margin: 0 auto;
    }
    .search-box {
        display: flex;
        background: #fff;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,.15);
    }
    .search-box input {
        flex: 1;
        border: none;
        outline: none;
        padding: 14px 20px;
        font-size: .95rem;
        color: var(--ink);
        background: transparent;
    }
    .search-box button {
        background: var(--brand);
        color: #fff;
        border: none;
        padding: 0 24px;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
        white-space: nowrap;
    }
    .search-box button:hover { background: var(--brand-dk); }
    .search-clear {
        display: inline-block;
        margin-top: 12px;
        color: rgba(255,255,255,.75);
        font-size: .82rem;
        text-decoration: none;
    }
    .search-clear:hover { color: #fff; }

    /* ── Main content wrapper ────────────────────────────── */
    .dir-body {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 16px 60px;
    }

    /* ── Toolbar row ─────────────────────────────────────── */
    .dir-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 22px;
    }
    .dir-toolbar-left {
        font-size: .88rem;
        color: var(--muted);
    }
    .dir-toolbar-left strong { color: var(--ink); }
    .btn-agency {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--brand);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: .85rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-agency:hover { background: var(--brand-dk); color: #fff; transform: translateY(-1px); }

    /* ── Client grid ─────────────────────────────────────── */
    .client-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 18px;
    }

    /* ── Client card ─────────────────────────────────────── */
    .client-card {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 22px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        gap: 14px;
        border: 1.5px solid transparent;
        transition: border-color .2s, box-shadow .2s, transform .18s;
    }
    .client-card:hover {
        border-color: var(--brand);
        box-shadow: 0 6px 24px rgba(15,118,110,.14);
        transform: translateY(-3px);
        text-decoration: none;
        color: inherit;
    }

    .card-top { display: flex; align-items: center; gap: 14px; }

    .client-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--brand-lt);
        color: var(--brand);
        font-size: 1.15rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .client-meta { flex: 1; min-width: 0; }
    .client-name {
        font-size: .98rem;
        font-weight: 700;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .client-location {
        font-size: .78rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .card-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .stat-box {
        background: var(--bg);
        border-radius: 8px;
        padding: 10px 8px;
        text-align: center;
    }
    .stat-val {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
    }
    .stat-val.has-rating { color: var(--brand); }
    .stat-lbl {
        font-size: .68rem;
        color: var(--muted);
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .card-stars {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .stars {
        display: flex;
        gap: 2px;
    }
    .star { color: #e0e0e0; font-size: .85rem; }
    .star.on { color: #f59e0b; }
    .rating-text {
        font-size: .8rem;
        color: var(--muted);
    }

    /* ── Empty state ─────────────────────────────────────── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: var(--muted);
    }
    .empty-state svg { opacity: .25; margin-bottom: 16px; }
    .empty-state h3 { font-size: 1rem; font-weight: 600; color: var(--ink); margin-bottom: 6px; }

    /* ── Pagination ──────────────────────────────────────── */
    .dir-pagination { margin-top: 32px; display: flex; justify-content: center; }
    .dir-pagination .pagination { gap: 4px; }
    .dir-pagination .page-link {
        border-radius: 8px !important;
        border: 1.5px solid var(--line);
        color: var(--brand);
        font-size: .85rem;
        padding: 7px 13px;
    }
    .dir-pagination .page-item.active .page-link {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }
    .dir-pagination .page-item.disabled .page-link { color: var(--muted); }

    /* ── Responsive ──────────────────────────────────────── */
    @media (max-width: 640px) {
        .client-grid { grid-template-columns: 1fr; }
        .dir-hero { padding: 40px 16px 36px; }
    }
</style>
@endsection

@section('content')

{{-- Hero / Search --}}
<div class="dir-hero">
    <h1>Client Reputation Directory</h1>
    <p>Search verified client records, ratings, disputes and feedback.</p>
    <div class="search-wrap">
        <form method="GET" action="{{ route('clients.index') }}">
            <div class="search-box">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by client name…" autocomplete="off">
                <button type="submit">Search</button>
            </div>
            @if(request('q'))
                <a class="search-clear" href="{{ route('clients.index') }}">✕ Clear search</a>
            @endif
        </form>
    </div>
</div>

{{-- Body --}}
<div class="dir-body">

    <div class="dir-toolbar">
        <div class="dir-toolbar-left">
            @if(request('q'))
                Results for <strong>"{{ request('q') }}"</strong> &mdash;
            @endif
            <strong>{{ $clients->total() }}</strong> {{ Str::plural('client', $clients->total()) }} found
        </div>
        @auth
            <a href="{{ route('agency.clients.index') }}" class="btn-agency">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Agency Workspace
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-agency">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Agency Login
            </a>
        @endauth
    </div>

    <div class="client-grid">
        @forelse($clients as $client)
            @php
                $initials = collect(explode(' ', $client->name))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->join('');
                $rating   = $client->visible_feedback_avg ? round($client->visible_feedback_avg, 1) : null;
            @endphp
            <a href="{{ route('clients.show', $client) }}" class="client-card">

                <div class="card-top">
                    <div class="client-avatar">{{ $initials }}</div>
                    <div class="client-meta">
                        <div class="client-name">{{ $client->name }}</div>
                        @if($client->location)
                            <div class="client-location">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $client->location }}
                            </div>
                        @endif
                    </div>
                </div>

                @if($rating)
                    <div class="card-stars">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($rating) ? 'on' : '' }}">★</span>
                            @endfor
                        </div>
                        <span class="rating-text">{{ number_format($rating, 1) }} / 5</span>
                    </div>
                @endif

                <div class="card-stats">
                    <div class="stat-box">
                        <div class="stat-val {{ $rating ? 'has-rating' : '' }}">{{ $rating ? number_format($rating, 1) : '—' }}</div>
                        <div class="stat-lbl">Avg Rating</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-val">{{ $client->visible_feedback_count }}</div>
                        <div class="stat-lbl">Feedback</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-val">{{ $client->visible_disputes_count }}</div>
                        <div class="stat-lbl">Disputes</div>
                    </div>
                </div>

            </a>
        @empty
            <div class="empty-state">
                <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <h3>No clients found</h3>
                <p>Try a different search term.</p>
            </div>
        @endforelse
    </div>

    @if($clients->hasPages())
        <div class="dir-pagination">
            {{ $clients->appends(request()->query())->links() }}
        </div>
    @endif

</div>

@endsection
