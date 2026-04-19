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

    /* ── Hero header ─────────────────────────────────────── */
    .profile-hero {
        background: linear-gradient(135deg, #0d6560 0%, #1a9e8f 60%, #22c5b2 100%);
        padding: 48px 20px 56px;
        color: #fff;
    }
    .profile-hero-inner {
        max-width: 900px;
        margin: 0 auto;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: rgba(255,255,255,.75);
        font-size: .82rem;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color .2s;
    }
    .back-link:hover { color: #fff; }

    .hero-row { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }

    .hero-avatar {
        width: 68px;
        height: 68px;
        border-radius: 16px;
        background: rgba(255,255,255,.18);
        font-size: 1.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
        border: 2px solid rgba(255,255,255,.3);
    }

    .hero-info { flex: 1; min-width: 0; }
    .hero-name {
        font-size: clamp(1.3rem, 3.5vw, 1.9rem);
        font-weight: 700;
        margin: 0 0 6px;
        letter-spacing: -.3px;
    }
    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        font-size: .83rem;
        opacity: .85;
    }
    .hero-meta span { display: flex; align-items: center; gap: 5px; }

    /* ── Stat pills ──────────────────────────────────────── */
    .stat-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }
    .stat-pill {
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 50px;
        padding: 8px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(4px);
    }
    .pill-val {
        font-size: 1.15rem;
        font-weight: 700;
        line-height: 1;
    }
    .pill-lbl {
        font-size: .75rem;
        opacity: .8;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* ── Stars inline ────────────────────────────────────── */
    .hero-stars { display: flex; gap: 3px; }
    .hero-star { color: rgba(255,255,255,.4); font-size: 1rem; }
    .hero-star.on { color: #fbbf24; }

    /* ── Page body ───────────────────────────────────────── */
    .profile-body {
        max-width: 900px;
        margin: -20px auto 0;
        padding: 0 16px 60px;
        position: relative;
        z-index: 1;
    }

    /* ── Section card ────────────────────────────────────── */
    .section-card {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 22px;
        border-bottom: 1.5px solid var(--line);
    }
    .section-title {
        font-size: .95rem;
        font-weight: 700;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-badge {
        background: var(--brand-lt);
        color: var(--brand);
        font-size: .72rem;
        font-weight: 600;
        border-radius: 20px;
        padding: 2px 9px;
    }
    .section-body { padding: 20px 22px; }

    /* ── Item card (dispute / feedback) ─────────────────── */
    .item-card {
        border: 1.5px solid var(--line);
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 14px;
        transition: border-color .2s, box-shadow .2s;
    }
    .item-card:last-child { margin-bottom: 0; }
    .item-card:hover { border-color: var(--brand); box-shadow: 0 3px 14px rgba(15,118,110,.09); }

    .item-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .item-tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .tag {
        font-size: .72rem;
        font-weight: 600;
        border-radius: 6px;
        padding: 3px 9px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }
    .tag-type  { background: #e0f2fe; color: #0369a1; }
    .tag-cat   { background: #fef9c3; color: #854d0e; }
    .tag-date  { background: var(--bg); color: var(--muted); font-weight: 500; }

    .item-body {
        font-size: .88rem;
        color: var(--ink);
        line-height: 1.6;
        margin-bottom: 10px;
    }
    .item-notes {
        background: var(--bg);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .83rem;
        color: var(--muted);
        margin-bottom: 10px;
    }
    .item-notes strong { color: var(--ink); }

    .item-reporter {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .78rem;
        color: var(--muted);
        border-top: 1px solid var(--line);
        padding-top: 10px;
        margin-top: 6px;
        flex-wrap: wrap;
    }
    .reporter-dot {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: var(--brand-lt);
        color: var(--brand);
        font-size: .65rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }
    .reporter-name { font-weight: 600; color: var(--ink); }

    /* ── Feedback stars ──────────────────────────────────── */
    .fb-stars { display: flex; align-items: center; gap: 6px; margin-bottom: 8px; }
    .fb-star-list { display: flex; gap: 2px; }
    .fb-star { color: #e0e0e0; font-size: .9rem; }
    .fb-star.on { color: #f59e0b; }
    .fb-score { font-size: .8rem; color: var(--muted); }

    /* ── Empty state ─────────────────────────────────────── */
    .empty-msg {
        text-align: center;
        padding: 32px 16px;
        color: var(--muted);
        font-size: .88rem;
    }

    /* ── Pagination ──────────────────────────────────────── */
    .item-pagination { margin-top: 16px; }
    .item-pagination .pagination { gap: 4px; }
    .item-pagination .page-link {
        border-radius: 8px !important;
        border: 1.5px solid var(--line);
        color: var(--brand);
        font-size: .82rem;
        padding: 6px 12px;
    }
    .item-pagination .page-item.active .page-link {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media (max-width: 600px) {
        .profile-hero { padding: 36px 16px 48px; }
        .hero-avatar { width: 52px; height: 52px; font-size: 1.2rem; }
        .section-body { padding: 14px 14px; }
        .item-card { padding: 12px 14px; }
    }
</style>
@endsection

@section('content')

@php
    $initials = collect(explode(' ', $client->name))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->join('');
    $rating   = $summary['average_rating'] ? round($summary['average_rating'], 1) : null;
@endphp

{{-- Hero --}}
<div class="profile-hero">
    <div class="profile-hero-inner">

        <a href="{{ route('clients.index') }}" class="back-link">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Directory
        </a>

        <div class="hero-row">
            <div class="hero-avatar">{{ $initials }}</div>
            <div class="hero-info">
                <h1 class="hero-name">{{ $client->name }}</h1>
                <div class="hero-meta">
                    @if($client->location)
                        <span>
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $client->location }}
                        </span>
                    @endif
                    @if($client->website)
                        <span>
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            {{ $client->website }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="stat-pills">
            <div class="stat-pill">
                @if($rating)
                    <div class="hero-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="hero-star {{ $i <= round($rating) ? 'on' : '' }}">★</span>
                        @endfor
                    </div>
                    <div>
                        <div class="pill-val">{{ number_format($rating, 1) }}</div>
                        <div class="pill-lbl">Avg Rating</div>
                    </div>
                @else
                    <div>
                        <div class="pill-val">N/A</div>
                        <div class="pill-lbl">No Ratings Yet</div>
                    </div>
                @endif
            </div>
            <div class="stat-pill">
                <div>
                    <div class="pill-val">{{ $summary['feedback_count'] }}</div>
                    <div class="pill-lbl">Feedback</div>
                </div>
            </div>
            <div class="stat-pill">
                <div>
                    <div class="pill-val">{{ $disputes->total() }}</div>
                    <div class="pill-lbl">Disputes</div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Body --}}
<div class="profile-body">

    {{-- Disputes --}}
    <div class="section-card">
        <div class="section-head">
            <div class="section-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Disputes
                <span class="section-badge">{{ $disputes->total() }}</span>
            </div>
        </div>
        <div class="section-body">
            @forelse($disputes as $dispute)
                @php
                    $agencyName = optional($dispute->agency?->agencyProfile)->company_name
                        ?: optional($dispute->agency)->company_name
                        ?: optional($dispute->agency)->name;
                    $agencyInit = strtoupper(substr($agencyName ?? 'A', 0, 1));
                @endphp
                <div class="item-card">
                    <div class="item-top">
                        <div class="item-tags">
                            <span class="tag tag-type">{{ $dispute->project_type }}</span>
                            <span class="tag tag-type">{{ $dispute->dispute_type }}</span>
                            @if(optional($dispute->category)->name)
                                <span class="tag tag-cat">{{ $dispute->category->name }}</span>
                            @endif
                        </div>
                        <span class="tag tag-date">{{ $dispute->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="item-body">{{ $dispute->issue_description }}</div>
                    @if($dispute->supporting_notes)
                        <div class="item-notes"><strong>Notes:</strong> {{ $dispute->supporting_notes }}</div>
                    @endif
                    <div class="item-reporter">
                        <div class="reporter-dot">{{ $agencyInit }}</div>
                        <span class="reporter-name">{{ $agencyName }}</span>
                        @if(optional($dispute->agency?->agencyProfile)->phone)
                            <span>· {{ $dispute->agency->agencyProfile->phone }}</span>
                        @endif
                        @if($dispute->agency?->email)
                            <span>· {{ $dispute->agency->email }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-msg">No visible disputes on record.</div>
            @endforelse

            @if($disputes->hasPages())
                <div class="item-pagination">{{ $disputes->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Feedback --}}
    <div class="section-card">
        <div class="section-head">
            <div class="section-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Feedback
                <span class="section-badge">{{ $feedbackItems->total() }}</span>
            </div>
        </div>
        <div class="section-body">
            @forelse($feedbackItems as $feedback)
                @php
                    $agencyName = optional($feedback->agency?->agencyProfile)->company_name
                        ?: optional($feedback->agency)->company_name
                        ?: optional($feedback->agency)->name;
                    $agencyInit = strtoupper(substr($agencyName ?? 'A', 0, 1));
                @endphp
                <div class="item-card">
                    <div class="fb-stars">
                        <div class="fb-star-list">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="fb-star {{ $i <= $feedback->rating ? 'on' : '' }}">★</span>
                            @endfor
                        </div>
                        <span class="fb-score">{{ $feedback->rating }}/5</span>
                        <span class="tag tag-date" style="margin-left:auto">{{ $feedback->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="item-body">{{ $feedback->feedback_text ?: 'No written feedback provided.' }}</div>
                    <div class="item-reporter">
                        <div class="reporter-dot">{{ $agencyInit }}</div>
                        <span class="reporter-name">{{ $agencyName }}</span>
                        @if(optional($feedback->agency?->agencyProfile)->phone)
                            <span>· {{ $feedback->agency->agencyProfile->phone }}</span>
                        @endif
                        @if($feedback->agency?->email)
                            <span>· {{ $feedback->agency->email }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-msg">No visible feedback on record.</div>
            @endforelse

            @if($feedbackItems->hasPages())
                <div class="item-pagination">{{ $feedbackItems->links() }}</div>
            @endif
        </div>
    </div>

</div>

@endsection
