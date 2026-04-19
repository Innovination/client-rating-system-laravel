@extends('layouts.agency')

@section('content')
    <div class="card">
        <div class="card-header">Edit Agency Profile</div>
        <div class="card-body">
            <form method="POST" action="{{ route('agency.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="required" for="company_name">Company Name</label>
                        <input id="company_name" name="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $profile->company_name) }}" required>
                        @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required" for="contact_person">Contact Person</label>
                        <input id="contact_person" name="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" value="{{ old('contact_person', $profile->contact_person) }}" required>
                        @error('contact_person')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="required" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $profile->phone) }}" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required" for="email">Email</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="url" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $profile->website) }}">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $profile->address) }}">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input id="city" name="city" type="text" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $profile->city) }}">
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="country">Country</label>
                        <input id="country" name="country" type="text" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', $profile->country) }}">
                        @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="company_info">Company Info</label>
                    <textarea id="company_info" name="company_info" rows="4" class="form-control @error('company_info') is-invalid @enderror">{{ old('company_info', $profile->company_info) }}</textarea>
                    @error('company_info')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('agency.profile.show') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
@endsection

