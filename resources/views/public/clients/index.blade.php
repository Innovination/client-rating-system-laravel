@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Client Directory</span>
                    @auth
                        <a href="{{ route('agency.clients.index') }}" class="btn btn-sm btn-primary">Agency Workspace</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Agency Login</a>
                    @endauth
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
                        <div class="form-row">
                            <div class="col-md-8">
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search clients by name">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit">Search</button>
                                <a class="btn btn-light" href="{{ route('clients.index') }}">Clear</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Avg. Rating</th>
                                    <th>Feedback</th>
                                    <th>Disputes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                    <tr>
                                        <td><a href="{{ route('clients.show', $client) }}">{{ $client->name }}</a></td>
                                        <td>{{ $client->location ?: '-' }}</td>
                                        <td>{{ $client->visible_feedback_avg ? number_format($client->visible_feedback_avg, 1) : 'N/A' }}</td>
                                        <td>{{ $client->visible_feedback_count }}</td>
                                        <td>{{ $client->visible_disputes_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No clients found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

