@extends('layouts.agency')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Agency Profile</span>
            <a href="{{ route('agency.profile.edit') }}" class="btn btn-sm btn-primary">Edit Profile</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Company Name</div>
                    <div>{{ $profile->company_name ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Contact Person</div>
                    <div>{{ $profile->contact_person ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Phone</div>
                    <div>{{ $profile->phone ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Email</div>
                    <div>{{ auth()->user()->email }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Alternate Number</div>
                    <div>{{ $profile->alternate_phone ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">WhatsApp Number</div>
                    <div>
                        @if($profile->whatsapp_number)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener">{{ $profile->whatsapp_number }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Website</div>
                    <div>
                        @if($profile->website)
                            <a href="{{ $profile->website }}" target="_blank" rel="noopener">{{ $profile->website }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Country</div>
                    <div>{{ $profile->country?->name ?? '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">State</div>
                    <div>{{ $profile->state?->name ?? '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">City</div>
                    <div>{{ $profile->cityRelation?->name ?? '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Pin / Zip Code</div>
                    <div>{{ $profile->pin_code ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="text-muted small">Address</div>
                    <div>{{ $profile->address ?: '-' }}</div>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Company Info</div>
                    <div>{{ $profile->company_info ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

