@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-lg-10">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $client->name }}</span>
                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-light">Back to directory</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="text-muted small">Website</div>
                            <div>{{ $client->website ?: '-' }}</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="text-muted small">Location</div>
                            <div>{{ $client->location ?: '-' }}</div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="text-muted small">Overall Rating</div>
                            <div>{{ $summary['average_rating'] ? number_format($summary['average_rating'], 1) : 'N/A' }} ({{ $summary['feedback_count'] }} ratings)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Disputes</div>
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
                                Reporting agency:
                                {{ optional($dispute->agency?->agencyProfile)->company_name ?: optional($dispute->agency)->company_name ?: optional($dispute->agency)->name }}
                                @if(optional($dispute->agency?->agencyProfile)->phone)
                                    | {{ $dispute->agency->agencyProfile->phone }}
                                @endif
                                @if($dispute->agency?->email)
                                    | {{ $dispute->agency->email }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No visible disputes available.</div>
                    @endforelse

                    {{ $disputes->links() }}
                </div>
            </div>

            <div class="card">
                <div class="card-header">Feedback</div>
                <div class="card-body">
                    @forelse($feedbackItems as $feedback)
                        <div class="border rounded p-3 mb-2">
                            <div class="d-flex justify-content-between">
                                <strong>Rating: {{ $feedback->rating }}/5</strong>
                                <small class="text-muted">{{ $feedback->created_at->format('d M Y') }}</small>
                            </div>
                            <div>{{ $feedback->feedback_text ?: 'No written feedback provided.' }}</div>
                            <div class="mt-2 small text-muted">
                                Reporting agency:
                                {{ optional($feedback->agency?->agencyProfile)->company_name ?: optional($feedback->agency)->company_name ?: optional($feedback->agency)->name }}
                                @if(optional($feedback->agency?->agencyProfile)->phone)
                                    | {{ $feedback->agency->agencyProfile->phone }}
                                @endif
                                @if($feedback->agency?->email)
                                    | {{ $feedback->agency->email }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No visible feedback available.</div>
                    @endforelse

                    {{ $feedbackItems->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

