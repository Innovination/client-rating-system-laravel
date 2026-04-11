@extends('layouts.agency')

@section('content')
<div class="row">
    <div class="col-lg-7 mb-3">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Client Details</span>
                <a href="{{ route('agency.clients.index') }}" class="btn btn-sm btn-light">Back</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped mb-0">
                    <tbody>
                        <tr><th style="width: 180px;">Name</th><td>{{ $client->name }}</td></tr>
                        <tr><th>Website</th><td>{{ $client->website ?: '-' }}</td></tr>
                        <tr><th>Location</th><td>{{ $client->location ?: '-' }}</td></tr>
                        <tr><th>Overall Rating</th><td>{{ $avgRating > 0 ? $avgRating . ' / 5' : 'No ratings yet' }}</td></tr>
                        <tr><th>Added By</th><td>{{ optional($client->createdBy)->name ?: '-' }}</td></tr>
                        <tr><th>Created At</th><td>{{ optional($client->created_at)->format('d-M-Y H:i A') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Submit / Update Feedback</div>
            <div class="card-body">
                <form method="POST" action="{{ route('agency.feedback.store') }}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="form-group">
                        <label for="rating" class="required">Rating (1 to 5)</label>
                        <select name="rating" id="rating" class="form-control" required>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ (string) old('rating', $myFeedback->rating ?? '') === (string) $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="feedback_text">Feedback</label>
                        <textarea name="feedback_text" id="feedback_text" rows="4" class="form-control" placeholder="Share your experience with this client">{{ old('feedback_text', $myFeedback->feedback_text ?? '') }}</textarea>
                        @error('feedback_text')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Feedback</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Report Dispute</div>
            <div class="card-body">
                <form method="POST" action="{{ route('agency.disputes.store') }}">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    <div class="form-group">
                        <label for="dispute_category_id">Dispute Category</label>
                        <select name="dispute_category_id" id="dispute_category_id" class="form-control">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (string) old('dispute_category_id') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('dispute_category_id')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="project_type" class="required">Project Type</label>
                            <input type="text" name="project_type" id="project_type" class="form-control" value="{{ old('project_type') }}" required>
                            @error('project_type')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dispute_type" class="required">Dispute Type</label>
                            <input type="text" name="dispute_type" id="dispute_type" class="form-control" value="{{ old('dispute_type') }}" placeholder="payment_delay, scope_creep" required>
                            @error('dispute_type')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="issue_description" class="required">Issue Description</label>
                        <textarea name="issue_description" id="issue_description" rows="4" class="form-control" required>{{ old('issue_description') }}</textarea>
                        @error('issue_description')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="supporting_notes">Supporting Notes</label>
                        <textarea name="supporting_notes" id="supporting_notes" rows="3" class="form-control">{{ old('supporting_notes') }}</textarea>
                        @error('supporting_notes')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-warning">Submit Dispute</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-3">
        <div class="card mb-3">
            <div class="card-header">Latest Feedback</div>
            <div class="card-body">
                @forelse($feedback as $item)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ optional($item->agency)->name ?: 'Agency' }}</strong>
                            <span class="badge badge-info">{{ $item->rating }}/5</span>
                        </div>
                        <p class="mb-1 mt-2">{{ $item->feedback_text ?: 'No text feedback provided.' }}</p>
                        <small class="text-muted">{{ optional($item->agency)->email }} | {{ optional($item->agency)->mobile }}</small>
                    </div>
                @empty
                    <p class="mb-0 text-muted">No feedback available yet.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header">Latest Disputes</div>
            <div class="card-body">
                @forelse($disputes as $item)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $item->project_type }}</strong>
                            <span class="badge badge-warning">{{ $item->dispute_type }}</span>
                        </div>
                        <p class="mb-1 mt-2">{{ $item->issue_description }}</p>
                        <small class="text-muted">{{ optional($item->category)->name ?: 'General' }} | {{ optional($item->agency)->name ?: 'Agency' }}</small>
                    </div>
                @empty
                    <p class="mb-0 text-muted">No disputes available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
