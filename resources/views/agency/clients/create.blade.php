@extends('layouts.agency')

@section('content')
<div class="card">
    <div class="card-header">Add Client</div>
    <div class="card-body">
        <form method="POST" action="{{ route('agency.clients.store') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="required">Client Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}" placeholder="https://example.com">
                @error('website')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="City, Country">
                @error('location')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Client</button>
            <a href="{{ route('agency.clients.index') }}" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
@endsection
