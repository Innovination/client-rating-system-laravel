@extends('layouts.admin')

@section('content')
<div class="card mb-3">
    <div class="card-header">Disputes Moderation</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Agency</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($disputes as $item)
                    <tr>
                        <td>{{ optional($item->client)->name }}</td>
                        <td>{{ optional($item->agency)->name }}</td>
                        <td>{{ $item->dispute_type }}</td>
                        <td><span class="badge badge-{{ $item->status === 'visible' ? 'success' : 'secondary' }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ optional($item->created_at)->format('d-M-Y H:i A') }}</td>
                        <td>
                            @if($item->status === 'visible')
                                <form method="POST" action="{{ route('admin.moderation.disputes.hide', $item) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning">Hide</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.moderation.disputes.restore', $item) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Restore</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.moderation.disputes.delete', $item) }}" class="d-inline" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No disputes found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $disputes->links() }}
    </div>
</div>

<div class="card">
    <div class="card-header">Feedback Moderation</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Agency</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback as $item)
                    <tr>
                        <td>{{ optional($item->client)->name }}</td>
                        <td>{{ optional($item->agency)->name }}</td>
                        <td>{{ $item->rating }}/5</td>
                        <td><span class="badge badge-{{ $item->status === 'visible' ? 'success' : 'secondary' }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ optional($item->created_at)->format('d-M-Y H:i A') }}</td>
                        <td>
                            @if($item->status === 'visible')
                                <form method="POST" action="{{ route('admin.moderation.feedback.hide', $item) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-warning">Hide</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.moderation.feedback.restore', $item) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Restore</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.moderation.feedback.delete', $item) }}" class="d-inline" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No feedback found.</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $feedback->links() }}
    </div>
</div>
@endsection
