@extends('layouts.agency')

@section('content')
    <div class="card">
        <div class="card-header">Add Client</div>
        <div class="card-body">
            <form method="POST" action="{{ route('agency.clients.store') }}">
                @csrf

                <div class="form-group">
                    <label class="required" for="name">Client Name</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="url" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="location">Location</label>
                        <input id="location" name="location" type="text" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button class="btn btn-primary" type="submit">Save Client</button>
                <a href="{{ route('agency.clients.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection

