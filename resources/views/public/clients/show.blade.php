@extends('layouts.public')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">{{ $client->name }}</h2>
        <a href="{{ route('clients.index') }}" class="btn btn-light btn-sm">Back</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p class="mb-1"><strong>Location:</strong> {{ $client->location ?: '-' }}</p>
            <p class="mb-1"><strong>Website:</strong> {{ $client->website ?: '-' }}</p>
            <p class="mb-0"><strong>Overall Rating:</strong> {{ $avgRating > 0 ? $avgRating . ' / 5' : 'No ratings yet' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Feedback & Testimonials</div>
                <div class="card-body">
                    @forelse($feedback as $item)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>{{ optional($item->agency)->name ?: 'Agency' }}</strong>
                                <span class="badge badge-info">{{ $item->rating }}/5</span>
                            </div>
                            <p class="mb-1 mt-2">{{ $item->feedback_text ?: 'No text feedback.' }}</p>
                            <small class="text-muted">{{ optional($item->agency)->email }} | {{ optional($item->agency)->mobile }}</small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No feedback available yet.</p>
                    @endforelse

                    {{ $feedback->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card h-100">
                <div class="card-header">Disputes</div>
                <div class="card-body">
                    @forelse($disputes as $item)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $item->project_type }}</strong>
                                <span class="badge badge-warning">{{ $item->dispute_type }}</span>
                            </div>
                            <p class="mb-1 mt-2">{{ $item->issue_description }}</p>
                            <small class="text-muted">
                                {{ optional($item->category)->name ?: 'General' }}
                                | {{ optional($item->agency)->name ?: 'Agency' }}
                                | {{ optional($item->agency)->email }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No disputes available yet.</p>
                    @endforelse

                    {{ $disputes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
