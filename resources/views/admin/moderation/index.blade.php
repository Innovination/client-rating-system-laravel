@extends('layouts.admin')

@section('content')
    <div class="card mb-3">
        <div class="card-header">Moderation Queue</div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.moderation.index') }}" class="form-inline">
                <label class="mr-2" for="status">Status</label>
                <select id="status" name="status" class="form-control mr-2">
                    <option value="">All</option>
                    <option value="visible" @selected($status === 'visible')>Visible</option>
                    <option value="hidden" @selected($status === 'hidden')>Hidden</option>
                </select>
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="{{ route('admin.moderation.index') }}" class="btn btn-light ml-2">Clear</a>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Disputes</div>
        <div class="card-body">
            @forelse($disputes as $dispute)
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $dispute->client->name }} - {{ $dispute->project_type }}</strong>
                        <span class="badge {{ $dispute->status === 'hidden' ? 'badge-danger' : 'badge-success' }}">{{ ucfirst($dispute->status) }}</span>
                    </div>
                    <div class="small text-muted mb-1">Type: {{ $dispute->dispute_type }}</div>
                    <div class="small text-muted mb-1">Category: {{ optional($dispute->category)->name ?: 'N/A' }}</div>
                    <div class="mb-2">{{ $dispute->issue_description }}</div>

                    <div class="d-flex flex-wrap align-items-center">
                        <form method="POST" action="{{ route('admin.moderation.disputes.update', $dispute) }}" class="mr-2 mb-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $dispute->status === 'visible' ? 'hidden' : 'visible' }}">
                            <button type="submit" class="btn btn-sm {{ $dispute->status === 'visible' ? 'btn-warning' : 'btn-success' }}">
                                {{ $dispute->status === 'visible' ? 'Hide' : 'Restore' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.moderation.disputes.destroy', $dispute) }}" class="mb-1" onsubmit="return confirm('Delete this dispute?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-muted">No disputes found.</div>
            @endforelse

            {{ $disputes->links() }}
        </div>
    </div>

    <div class="card">
        <div class="card-header">Feedback</div>
        <div class="card-body">
            @forelse($feedbackItems as $feedback)
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $feedback->client->name }} - Rating {{ $feedback->rating }}/5</strong>
                        <span class="badge {{ $feedback->status === 'hidden' ? 'badge-danger' : 'badge-success' }}">{{ ucfirst($feedback->status) }}</span>
                    </div>
                    <div class="mb-2">{{ $feedback->feedback_text ?: 'No written feedback.' }}</div>

                    <div class="d-flex flex-wrap align-items-center">
                        <form method="POST" action="{{ route('admin.moderation.feedback.update', $feedback) }}" class="mr-2 mb-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $feedback->status === 'visible' ? 'hidden' : 'visible' }}">
                            <button type="submit" class="btn btn-sm {{ $feedback->status === 'visible' ? 'btn-warning' : 'btn-success' }}">
                                {{ $feedback->status === 'visible' ? 'Hide' : 'Restore' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.moderation.feedback.destroy', $feedback) }}" class="mb-1" onsubmit="return confirm('Delete this feedback?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-muted">No feedback found.</div>
            @endforelse

            {{ $feedbackItems->links() }}
        </div>
    </div>
@endsection

