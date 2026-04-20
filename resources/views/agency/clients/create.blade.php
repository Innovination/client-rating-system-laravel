@extends('layouts.agency')

@section('content')
    <div class="card">
        <div class="card-header">Add Client</div>
        <div class="card-body">
            <form method="POST" action="{{ route('agency.clients.store') }}">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <label class="required" for="name">Client Name</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Website + Phone --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="url" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+91 98765 43210">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Country / State / City --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="country_id">Country</label>
                        <select id="country_id" name="country_id" class="form-control @error('country_id') is-invalid @enderror">
                            <option value="">— Select Country —</option>
                            @foreach($countries as $id => $name)
                                <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state_id">State</label>
                        <select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                            <option value="">— Select State —</option>
                        </select>
                        @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city_id">City</label>
                        <select id="city_id" name="city_id" class="form-control @error('city_id') is-invalid @enderror">
                            <option value="">— Select City —</option>
                        </select>
                        @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Save Client</button>
                <a href="{{ route('agency.clients.index') }}" class="btn btn-light">Cancel</a>
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

    function populateSelect(el, items) {
        items.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.name;
            el.appendChild(opt);
        });
    }

    countrySelect.addEventListener('change', function () {
        resetSelect(stateSelect, '— Select State —');
        resetSelect(citySelect, '— Select City —');
        if (!this.value) return;
        fetch(statesUrl + '?country_id=' + this.value)
            .then(r => r.json())
            .then(data => populateSelect(stateSelect, data));
    });

    stateSelect.addEventListener('change', function () {
        resetSelect(citySelect, '— Select City —');
        if (!this.value) return;
        fetch(citiesUrl + '?state_id=' + this.value)
            .then(r => r.json())
            .then(data => populateSelect(citySelect, data));
    });
})();
</script>
@endsection
