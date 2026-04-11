@extends('layouts.agency')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Clients</span>
        <a href="{{ route('agency.clients.create') }}" class="btn btn-sm btn-primary">Add Client</a>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('agency.clients.index') }}" class="mb-3">
            <div class="input-group" style="max-width: 420px;">
                <input type="text" class="form-control" name="search" placeholder="Search by client name" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Location</th>
                        <th>Website</th>
                        <th>Feedback Count</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->location ?: '-' }}</td>
                        <td>
                            @if($client->website)
                                <a href="{{ $client->website }}" target="_blank" rel="noopener">{{ $client->website }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $client->feedback_count }}</td>
                        <td>{{ optional($client->created_at)->format('d-M-Y H:i A') }}</td>
                        <td>
                            <a href="{{ route('agency.clients.show', $client) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No clients found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $clients->links() }}
    </div>
</div>
@endsection
