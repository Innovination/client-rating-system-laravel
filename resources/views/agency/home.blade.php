@extends('layouts.agency')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Profile Status</small>
                @if($stats['profile_completed'])
                    <span class="badge badge-success">Completed</span>
                @else
                    <span class="badge badge-warning">Pending</span>
                @endif
                <div class="mt-3">
                    <a href="{{ route('agency.profile.edit') }}" class="btn btn-sm btn-outline-primary">Update Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Clients Added</small>
                <h4 class="mb-0">{{ $stats['clients_added'] }}</h4>
                <div class="mt-3">
                    <a href="{{ route('agency.clients.create') }}" class="btn btn-sm btn-outline-primary">Add Client</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-body">
                <small class="text-muted d-block mb-1">Unread Notifications</small>
                <h4 class="mb-0">{{ $stats['notifications_unread'] }}</h4>
                <div class="mt-3">
                    <a href="{{ route('agency.notifications.index') }}" class="btn btn-sm btn-outline-primary">View Notifications</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">Agency Dashboard</div>
            <div class="card-body">
                <p>Welcome to your agency portal. Use quick links to maintain your profile and review clients.</p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Recent Clients You Added</th>
                                <th>Location</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentClients as $client)
                                <tr>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->location ?: '-' }}</td>
                                    <td>{{ optional($client->created_at)->format('d-M-Y H:i A') }}</td>
                                    <td>
                                        <a href="{{ route('agency.clients.show', $client) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No clients added yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
