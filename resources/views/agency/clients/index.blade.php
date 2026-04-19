@extends('layouts.agency')

@section('content')
    <div class="row page-actions">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Clients</h5>
            <a href="{{ route('agency.clients.create') }}" class="btn btn-primary btn-sm">Add Client</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('agency.clients.index') }}" class="mb-3">
                <div class="form-row">
                    <div class="col-md-6">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search by client name">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a class="btn btn-light" href="{{ route('agency.clients.index') }}">Clear</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Location</th>
                            <th>Avg. Rating</th>
                            <th>Feedback Count</th>
                            <th>Disputes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td><a href="{{ route('agency.clients.show', $client) }}">{{ $client->name }}</a></td>
                                <td>{{ $client->website ?: '-' }}</td>
                                <td>{{ $client->location ?: '-' }}</td>
                                <td>{{ $client->visible_feedback_avg ? number_format($client->visible_feedback_avg, 1) : 'N/A' }}</td>
                                <td>{{ $client->visible_feedback_count }}</td>
                                <td>{{ $client->visible_disputes_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No clients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $clients->links() }}
        </div>
    </div>
@endsection

