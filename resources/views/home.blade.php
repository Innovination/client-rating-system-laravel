@extends('layouts.admin')

@section('styles')
<style>
    :root {
        --dash-blue:   #2563eb;
        --dash-teal:   #0f766e;
        --dash-amber:  #d97706;
        --dash-rose:   #e11d48;
        --dash-violet: #7c3aed;
        --dash-sky:    #0284c7;
        --dash-bg:     #f4f6fb;
        --dash-card:   #ffffff;
        --dash-border: #e5e9f2;
        --dash-muted:  #6b7a99;
        --dash-ink:    #1a2236;
        --dash-radius: 14px;
        --dash-shadow: 0 2px 12px rgba(30,50,100,.07);
    }

    .dash-wrap { background: var(--dash-bg); padding: 24px 20px 40px; min-height: 100vh; }

    /* ── Page header ─────────────────────────────────── */
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 26px;
    }
    .dash-header h1 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dash-ink);
        margin: 0;
    }
    .dash-header .dash-date {
        font-size: .82rem;
        color: var(--dash-muted);
    }

    /* ── Stat cards ──────────────────────────────────── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 16px;
        margin-bottom: 26px;
    }
    .stat-card {
        background: var(--dash-card);
        border-radius: var(--dash-radius);
        box-shadow: var(--dash-shadow);
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1.5px solid var(--dash-border);
        transition: box-shadow .2s, transform .18s;
    }
    .stat-card:hover { box-shadow: 0 6px 24px rgba(30,50,100,.12); transform: translateY(-2px); }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.2rem;
    }
    .stat-body { flex: 1; min-width: 0; }
    .stat-val {
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--dash-ink);
        line-height: 1;
        margin-bottom: 3px;
    }
    .stat-lbl {
        font-size: .75rem;
        color: var(--dash-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ic-blue   { background: #dbeafe; color: var(--dash-blue); }
    .ic-teal   { background: #ccfbf1; color: var(--dash-teal); }
    .ic-amber  { background: #fef3c7; color: var(--dash-amber); }
    .ic-rose   { background: #ffe4e6; color: var(--dash-rose); }
    .ic-violet { background: #ede9fe; color: var(--dash-violet); }
    .ic-sky    { background: #e0f2fe; color: var(--dash-sky); }
    .ic-gray   { background: #f1f5f9; color: #64748b; }

    /* ── Chart cards ─────────────────────────────────── */
    .chart-card {
        background: var(--dash-card);
        border-radius: var(--dash-radius);
        box-shadow: var(--dash-shadow);
        border: 1.5px solid var(--dash-border);
        padding: 20px 22px;
        height: 100%;
    }
    .chart-row { margin-bottom: 20px; }

    .chart-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .chart-title {
        font-size: .9rem;
        font-weight: 700;
        color: var(--dash-ink);
    }
    .chart-subtitle {
        font-size: .73rem;
        color: var(--dash-muted);
        margin-top: 1px;
    }
    .chart-canvas-wrap { position: relative; }

    /* ── Moderation alert ────────────────────────────── */
    .mod-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fffbeb;
        border: 1.5px solid #fde68a;
        border-radius: var(--dash-radius);
        padding: 14px 18px;
        margin-bottom: 26px;
        font-size: .88rem;
        color: #92400e;
    }
    .mod-alert a { color: var(--dash-amber); font-weight: 600; }
    .mod-alert svg { flex-shrink: 0; }

    /* ── Developer options ───────────────────────────── */
    .dev-card {
        background: var(--dash-card);
        border-radius: var(--dash-radius);
        box-shadow: var(--dash-shadow);
        border: 1.5px solid var(--dash-border);
        padding: 20px 22px;
        margin-top: 26px;
    }
    .dev-card-title {
        font-size: .88rem;
        font-weight: 700;
        color: var(--dash-ink);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .dev-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    /* ── Responsive ──────────────────────────────────── */
    @media (max-width: 500px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .dash-wrap { padding: 16px 12px 32px; }
    }
</style>
@endsection

@section('content')
<div class="dash-wrap">

    {{-- Header --}}
    <div class="dash-header">
        <h1>Admin Dashboard</h1>
        <span class="dash-date">{{ now()->format('l, d M Y') }}</span>
    </div>

    {{-- Moderation alert --}}
    @if(($stats['pending_disputes'] + $stats['pending_feedback']) > 0)
        <div class="mod-alert">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span>
                Moderation queue:
                @if($stats['pending_disputes'] > 0)
                    <strong>{{ $stats['pending_disputes'] }}</strong> dispute{{ $stats['pending_disputes'] != 1 ? 's' : '' }}
                @endif
                @if($stats['pending_disputes'] > 0 && $stats['pending_feedback'] > 0) and @endif
                @if($stats['pending_feedback'] > 0)
                    <strong>{{ $stats['pending_feedback'] }}</strong> feedback item{{ $stats['pending_feedback'] != 1 ? 's' : '' }}
                @endif
                awaiting review.
                <a href="{{ route('admin.moderation.index') }}">Review now →</a>
            </span>
        </div>
    @endif

    {{-- Stat cards --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon ic-blue">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['agencies'] }}</div>
                <div class="stat-lbl">Registered Agencies</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-teal">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['verified_agencies'] }}</div>
                <div class="stat-lbl">Verified Agencies</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-rose">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['suspended_agencies'] }}</div>
                <div class="stat-lbl">Suspended Agencies</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-sky">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['total_clients'] }}</div>
                <div class="stat-lbl">Total Clients</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-teal">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['visible_disputes'] }}</div>
                <div class="stat-lbl">Visible Disputes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-gray">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['hidden_disputes'] }}</div>
                <div class="stat-lbl">Hidden Disputes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-violet">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['visible_feedback'] }}</div>
                <div class="stat-lbl">Visible Feedback</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ic-amber">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-body">
                <div class="stat-val">{{ $stats['pending_disputes'] + $stats['pending_feedback'] }}</div>
                <div class="stat-lbl">Pending Moderation</div>
            </div>
        </div>
    </div>

    {{-- Charts row 1: trend + dispute status --}}
    <div class="row chart-row">
        <div class="col-lg-8 mb-4">
            <div class="chart-card">
                <div class="chart-head">
                    <div>
                        <div class="chart-title">Activity Trend</div>
                        <div class="chart-subtitle">Agencies, disputes &amp; feedback — last 6 months</div>
                    </div>
                </div>
                <div class="chart-canvas-wrap" style="position:relative; height:240px;">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="chart-card">
                <div class="chart-head">
                    <div>
                        <div class="chart-title">Dispute Status</div>
                        <div class="chart-subtitle">Breakdown by status</div>
                    </div>
                </div>
                <div class="chart-canvas-wrap" style="position:relative; height:240px;">
                    <canvas id="disputeStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts row 2: ratings + agency status --}}
    <div class="row chart-row">
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-head">
                    <div>
                        <div class="chart-title">Feedback Ratings</div>
                        <div class="chart-subtitle">Distribution of 1–5 star ratings (visible)</div>
                    </div>
                </div>
                <div class="chart-canvas-wrap" style="position:relative; height:220px;">
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="chart-card">
                <div class="chart-head">
                    <div>
                        <div class="chart-title">Agency Status</div>
                        <div class="chart-subtitle">Active vs suspended agencies</div>
                    </div>
                </div>
                <div class="chart-canvas-wrap" style="position:relative; height:220px;">
                    <canvas id="agencyStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Developer Options --}}
    @can('developer_options')
        <div class="dev-card">
            <div class="dev-card-title">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                Developer Options
            </div>
            <div class="dev-actions">
                <form method="POST" action="{{ route('admin.maintenance.migrate') }}">
                    @csrf
                    <button class="btn btn-sm btn-primary" type="submit">Run Migrate</button>
                </form>
                <form method="POST" action="{{ route('admin.maintenance.cacheRefresh') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary" type="submit">Cache Refresh</button>
                </form>
                <form method="POST" action="{{ route('admin.maintenance.optimize') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-primary" type="submit">Optimize + Optimize:Clear</button>
                </form>
            </div>
        </div>
    @endcan

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
    Chart.defaults.color       = '#6b7a99';
    Chart.defaults.plugins.legend.labels.boxWidth = 12;
    Chart.defaults.plugins.legend.labels.padding  = 16;

    const labels = @json($monthLabels);

    // ── Activity trend ────────────────────────────────
    new Chart(document.getElementById('activityChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'New Agencies',
                    data: @json($agencyRegData),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,.08)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Disputes',
                    data: @json($disputeData),
                    borderColor: '#e11d48',
                    backgroundColor: 'rgba(225,29,72,.06)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#e11d48',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Feedback',
                    data: @json($feedbackData),
                    borderColor: '#7c3aed',
                    backgroundColor: 'rgba(124,58,237,.06)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#7c3aed',
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,.05)' },
                },
                x: { grid: { display: false } },
            },
        },
    });

    // ── Dispute status doughnut ───────────────────────
    new Chart(document.getElementById('disputeStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Visible', 'Hidden', 'Pending'],
            datasets: [{
                data: @json($disputeStatusData),
                backgroundColor: ['#0f766e', '#64748b', '#d97706'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { position: 'bottom' },
            },
        },
    });

    // ── Feedback ratings bar ──────────────────────────
    new Chart(document.getElementById('ratingChart'), {
        type: 'bar',
        data: {
            labels: ['★ 1', '★ 2', '★ 3', '★ 4', '★ 5'],
            datasets: [{
                label: 'Ratings',
                data: @json($ratingData),
                backgroundColor: ['#ef4444','#f97316','#eab308','#84cc16','#22c55e'],
                borderRadius: 6,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,.05)' },
                },
                x: { grid: { display: false } },
            },
        },
    });

    // ── Agency status doughnut ────────────────────────
    new Chart(document.getElementById('agencyStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Suspended'],
            datasets: [{
                data: [{{ $agencyActiveCount }}, {{ $agencySuspendedCount }}],
                backgroundColor: ['#2563eb', '#e11d48'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { position: 'bottom' },
            },
        },
    });
})();
</script>
@endsection
