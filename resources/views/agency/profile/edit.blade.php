@extends('layouts.agency')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Agency Profile</div>
            <div class="card-body">
                <form method="POST" action="{{ route('agency.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="company_name" class="required">Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name', $profile->company_name ?? auth()->user()->company_name) }}" required>
                            @error('company_name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact_person">Contact Person</label>
                            <input type="text" id="contact_person" name="contact_person" class="form-control" value="{{ old('contact_person', $profile->contact_person ?? auth()->user()->name) }}">
                            @error('contact_person')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? auth()->user()->mobile) }}">
                            @error('phone')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" class="form-control" value="{{ old('website', $profile->website ?? '') }}" placeholder="https://example.com">
                            @error('website')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $profile->city ?? '') }}">
                            @error('city')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" class="form-control" value="{{ old('country', $profile->country ?? '') }}">
                            @error('country')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $profile->address ?? '') }}">
                            @error('address')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_info">Company Info</label>
                        <textarea id="company_info" name="company_info" class="form-control" rows="4" placeholder="Short summary about your agency">{{ old('company_info', $profile->company_info ?? '') }}</textarea>
                        @error('company_info')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
