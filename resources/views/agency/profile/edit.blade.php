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
                        <label for="alternate_phone">Alternate Number</label>
                        <input id="alternate_phone" name="alternate_phone" type="text" class="form-control @error('alternate_phone') is-invalid @enderror" value="{{ old('alternate_phone', $profile->alternate_phone) }}" placeholder="Optional second phone number">
                        @error('alternate_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="whatsapp_number">WhatsApp Number</label>
                        <input id="whatsapp_number" name="whatsapp_number" type="text" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number', $profile->whatsapp_number) }}" placeholder="With country code, e.g. +91 98765 43210">
                        @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="url" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $profile->website) }}">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-5">
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $profile->address) }}">
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pin_code">Pin / Zip Code</label>
                        <input id="pin_code" name="pin_code" type="text" class="form-control @error('pin_code') is-invalid @enderror" value="{{ old('pin_code', $profile->pin_code) }}" placeholder="e.g. 400001">
                        @error('pin_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Location dropdowns --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="country_id">Country</label>
                        <select id="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror">
                            <option value="">— Select Country —</option>
                            @foreach($countries as $id => $name)
                                <option value="{{ $id }}" {{ old('country_id', $profile->country_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state_id">State</label>
                        <select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                            <option value="">— Select State —</option>
                            @if($profile->state_id)
                                @foreach($profile->state->country->states ?? [] as $state)
                                    <option value="{{ $state->id }}" {{ old('state_id', $profile->state_id) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city_id">City</label>
                        <select id="city_id" name="city_id" class="form-control @error('city_id') is-invalid @enderror">
                            <option value="">— Select City —</option>
                            @if($profile->city_id)
                                @foreach($profile->state->cities ?? [] as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $profile->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

@section('scripts')
<script>
(function () {
    const countrySelect = document.getElementById('country_id');
    const stateSelect   = document.getElementById('state_id');
    const citySelect    = document.getElementById('city_id');

    const statesUrl = '{{ route('agency.location.states') }}';
    const citiesUrl = '{{ route('agency.location.cities') }}';

    function resetSelect(el, placeholder) {
        el.innerHTML = '<option value="">' + placeholder + '</option>';
    }

    function populateSelect(el, items, selectedId) {
        items.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.name;
            if (item.id == selectedId) opt.selected = true;
            el.appendChild(opt);
        });
    }

    countrySelect.addEventListener('change', function () {
        resetSelect(stateSelect, '— Select State —');
        resetSelect(citySelect, '— Select City —');

        if (!this.value) return;

        fetch(statesUrl + '?country_id=' + this.value)
            .then(function (r) { return r.json(); })
            .then(function (data) { populateSelect(stateSelect, data, null); });
    });

    stateSelect.addEventListener('change', function () {
        resetSelect(citySelect, '— Select City —');

        if (!this.value) return;

        fetch(citiesUrl + '?state_id=' + this.value)
            .then(function (r) { return r.json(); })
            .then(function (data) { populateSelect(citySelect, data, null); });
    });
})();
</script>
@endsection
