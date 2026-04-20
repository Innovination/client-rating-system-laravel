@extends('layouts.agency')

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ $client->name }}</span>
            <a href="{{ route('agency.clients.index') }}" class="btn btn-sm btn-light">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">Website</div>
                    <div>
                        @if($client->website)
                            <a href="{{ $client->website }}" target="_blank" rel="noopener">{{ $client->website }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">Phone</div>
                    <div>{{ $client->phone ?: '-' }}</div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">Country</div>
                    <div>{{ $client->country?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">State</div>
                    <div>{{ $client->state?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">City</div>
                    <div>{{ $client->cityRelation?->name ?? '-' }}</div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="text-muted small">Address</div>
                    <div>{{ $client->address ?: '-' }}</div>
                </div>
                <div class="col-md-2 mb-2">
                    <div class="text-muted small">Avg. Rating</div>
                    <div>{{ $summary['average_rating'] ? number_format($summary['average_rating'], 1) : 'N/A' }}</div>
                </div>
                <div class="col-md-2 mb-2">
                    <div class="text-muted small">Feedback</div>
                    <div>{{ $summary['feedback_count'] }}</div>
                </div>
                <div class="col-md-2 mb-2">
                    <div class="text-muted small">Disputes</div>
                    <div>{{ $summary['dispute_count'] }}</div>
                </div>
            </div>
            @if($client->notes)
                <hr>
                <div class="text-muted small">Notes</div>
                <div>{{ $client->notes }}</div>
            @endif
        </div>
    </div>

    @if(! auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning">
            Verify your email to submit disputes and ratings.
        </div>
    @else
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">Report Dispute</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('agency.disputes.store') }}">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">

                            <div class="form-group">
                                <label for="dispute_category_id">Category</label>
                                <select name="dispute_category_id" id="dispute_category_id" class="form-control @error('dispute_category_id') is-invalid @enderror">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('dispute_category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('dispute_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="required" for="project_type">Project Category</label>
                                <input type="text" name="project_type" id="project_type" class="form-control @error('project_type') is-invalid @enderror" value="{{ old('project_type') }}" required>
                                @error('project_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="required" for="dispute_type">Dispute Type</label>
                                <input type="text" name="dispute_type" id="dispute_type" class="form-control @error('dispute_type') is-invalid @enderror" value="{{ old('dispute_type') }}" required>
                                @error('dispute_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="required" for="issue_description">Issue Description</label>
                                <textarea name="issue_description" id="issue_description" rows="4" class="form-control @error('issue_description') is-invalid @enderror" required>{{ old('issue_description') }}</textarea>
                                @error('issue_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="supporting_notes">Supporting Notes</label>
                                <textarea name="supporting_notes" id="supporting_notes" rows="3" class="form-control @error('supporting_notes') is-invalid @enderror">{{ old('supporting_notes') }}</textarea>
                                @error('supporting_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Submit Dispute</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">Rate & Feedback</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('agency.feedback.store') }}">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">

                            <div class="form-group">
                                <label class="required" for="rating">Rating (1-5)</label>
                                <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                                    <option value="">Select</option>
                                    @foreach([1,2,3,4,5] as $value)
                                        <option value="{{ $value }}" @selected(old('rating', optional($myFeedback)->rating) == $value)>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label for="feedback_text">Feedback</label>
                                <textarea name="feedback_text" id="feedback_text" rows="4" class="form-control @error('feedback_text') is-invalid @enderror">{{ old('feedback_text', optional($myFeedback)->feedback_text) }}</textarea>
                                @error('feedback_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button class="btn btn-primary" type="submit">{{ $myFeedback ? 'Update Feedback' : 'Submit Feedback' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header">Visible Disputes</div>
        <div class="card-body">
            @forelse($disputes as $dispute)
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $dispute->project_type }} / {{ $dispute->dispute_type }}</strong>
                        <small class="text-muted">{{ $dispute->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="small text-muted mb-2">Category: {{ optional($dispute->category)->name ?: 'N/A' }}</div>
                    <div>{{ $dispute->issue_description }}</div>
                    @if($dispute->supporting_notes)
                        <div class="mt-2"><strong>Notes:</strong> {{ $dispute->supporting_notes }}</div>
                    @endif
                    <div class="mt-2 small text-muted">
                        Reported by: {{ optional($dispute->agency?->agencyProfile)->company_name ?: optional($dispute->agency)->company_name ?: optional($dispute->agency)->name }}
                    </div>
                </div>
            @empty
                <div class="text-muted">No visible disputes yet.</div>
            @endforelse

            {{ $disputes->links() }}
        </div>
    </div>

    <div class="card">
        <div class="card-header">Visible Feedback</div>
        <div class="card-body">
            @forelse($feedbackItems as $feedback)
                <div class="border rounded p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>Rating: {{ $feedback->rating }}/5</strong>
                        <small class="text-muted">{{ $feedback->created_at->format('d M Y') }}</small>
                    </div>
                    <div>{{ $feedback->feedback_text ?: 'No written feedback provided.' }}</div>
                    <div class="mt-2 small text-muted">
                        Agency: {{ optional($feedback->agency?->agencyProfile)->company_name ?: optional($feedback->agency)->company_name ?: optional($feedback->agency)->name }}
                    </div>
                </div>
            @empty
                <div class="text-muted">No visible feedback yet.</div>
            @endforelse

            {{ $feedbackItems->links() }}
        </div>
    </div>
@endsection

