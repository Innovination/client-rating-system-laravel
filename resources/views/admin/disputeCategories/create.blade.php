@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create Dispute Category</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.dispute-categories.store') }}">
                @csrf

                <div class="form-group">
                    <label class="required" for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="required" for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" @checked(old('is_active', true))>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.dispute-categories.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection

