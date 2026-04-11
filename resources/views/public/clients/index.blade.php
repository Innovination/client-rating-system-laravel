@extends('layouts.public')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Client Directory</h2>

    <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
        <div class="input-group" style="max-width: 460px;">
            <input type="text" name="search" class="form-control" placeholder="Search client by name" value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Location</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->location ?: '-' }}</td>
                        <td>{{ $client->website ?: '-' }}</td>
                        <td><a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-primary">View</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No clients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $clients->links() }}
</div>
@endsection
