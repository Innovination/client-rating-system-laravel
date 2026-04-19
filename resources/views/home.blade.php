@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Admin Dashboard
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Registered Agencies</div>
                                    <div class="h3 mb-0">{{ $stats['agencies'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Suspended Agencies</div>
                                    <div class="h3 mb-0">{{ $stats['suspended_agencies'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Visible Disputes</div>
                                    <div class="h3 mb-0">{{ $stats['visible_disputes'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Hidden Disputes</div>
                                    <div class="h3 mb-0">{{ $stats['hidden_disputes'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Visible Feedback</div>
                                    <div class="h3 mb-0">{{ $stats['visible_feedback'] }}</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">Hidden Feedback</div>
                                    <div class="h3 mb-0">{{ $stats['hidden_feedback'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('developer_options')
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">Developer Options</div>
                        <div class="card-body">
                            <div class="filter-actions">
                                <form method="POST" action="{{ route('admin.maintenance.migrate') }}">
                                    @csrf
                                    <button class="btn btn-primary" type="submit">Run Migrate</button>
                                </form>
                                <form method="POST" action="{{ route('admin.maintenance.cacheRefresh') }}">
                                    @csrf
                                    <button class="btn btn-outline-secondary" type="submit">Cache Refresh</button>
                                </form>
                                <form method="POST" action="{{ route('admin.maintenance.optimize') }}">
                                    @csrf
                                    <button class="btn btn-outline-primary" type="submit">Optimize + Optimize:Clear</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

