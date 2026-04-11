@extends('layouts.agency')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Agency Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Clients Added</div>
                                <div class="h3 mb-0">{{ $stats['clients_added'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Disputes Submitted</div>
                                <div class="h3 mb-0">{{ $stats['disputes_submitted'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Feedback Entries</div>
                                <div class="h3 mb-0">{{ $stats['feedback_submitted'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="text-muted small">Account Status</div>
                                <div class="h5 mb-0 text-capitalize">{{ $stats['status'] }}</div>
                            </div>
                        </div>
                    </div>

                    @if(! $stats['is_verified'])
                        <div class="alert alert-warning mb-0">
                            Verify your email to submit disputes and client ratings.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

