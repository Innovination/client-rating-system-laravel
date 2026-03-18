@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
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

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
@endsection
