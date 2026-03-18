@extends('layouts.admin')

@section('content')
    @can('user_create')
        <div class="row page-actions">
            <div class="col-lg-12">
                <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="filter-form mb-3">
                <div class="filter-panel">
                    <div class="filter-panel__title">Filters</div>
                    <div class="form-row filter-panel__grid">
                        <div class="col-md-4 mb-2">
                            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="{{ trans('global.search') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-control" name="user_type">
                                <option value="">{{ trans('global.all') }} User Type</option>
                                @foreach($userTypes as $userType)
                                    <option value="{{ $userType }}" @selected($userType === request('user_type'))>{{ $userType }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter-panel">
                    <div class="filter-panel__title">Sorting</div>
                    <div class="form-row filter-panel__grid">
                        <div class="col-md-3 mb-2">
                            <select class="form-control" name="sort_by">
                                <option value="id" @selected(request('sort_by', 'id') === 'id')>{{ trans('cruds.user.fields.id') }}</option>
                                <option value="name" @selected(request('sort_by') === 'name')>{{ trans('cruds.user.fields.name') }}</option>
                                <option value="email" @selected(request('sort_by') === 'email')>{{ trans('cruds.user.fields.email') }}</option>
                                <option value="mobile" @selected(request('sort_by') === 'mobile')>{{ trans('cruds.user.fields.mobile') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="sort_dir">
                                <option value="asc" @selected(request('sort_dir', 'asc') === 'asc')>Ascending</option>
                                <option value="desc" @selected(request('sort_dir') === 'desc')>Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit">{{ trans('global.search') }}</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">{{ trans('global.clear') }}</a>
                </div>
            </form>
            @can('user_delete')
                <form method="POST" action="{{ route('admin.users.massDestroy') }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                    @csrf
                    @method('DELETE')
                    <div class="table-actions">
                        <button class="btn btn-danger" type="submit">{{ trans('global.delete') }}</button>
                    </div>
            @endcan

            <div class="d-md-none">
                @forelse($users as $user)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ trans('cruds.user.fields.name') }}:</strong>
                                    {{ $user->name ?? '' }}
                                </div>
                                @can('user_delete')
                                    <div>
                                        <input type="checkbox" name="ids[]" value="{{ $user->id }}">
                                    </div>
                                @endcan
                            </div>
                            <div>
                                <strong>{{ trans('cruds.user.fields.id') }}:</strong>
                                {{ $user->id ?? '' }}
                            </div>
                            <div>
                                <strong>{{ trans('cruds.user.fields.email') }}:</strong>
                                {{ $user->email ?? '' }}
                            </div>
                            <div>
                                <strong>{{ trans('cruds.user.fields.mobile') }}:</strong>
                                {{ $user->mobile ?? '' }}
                            </div>
                            <div>
                                <strong>{{ trans('cruds.user.fields.roles') }}:</strong>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->title }}</span>
                                @endforeach
                            </div>
                            <div>
                                <strong>{{ trans('cruds.user.fields.verification_status') }}:</strong>
                                @if($user->verification_status)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </div>
                            <div class="mt-2">
                                @include('partials.datatablesActions', [
                                    'viewGate' => 'user_show',
                                    'editGate' => 'user_edit',
                                    'deleteGate' => 'user_delete',
                                    'crudRoutePart' => 'users',
                                    'row' => $user,
                                ])
                                @if(!$user->verification_status && $user->user_type === 'agency')
                                    <form method="POST" action="{{ route('admin.users.approveVerification') }}" class="d-inline-block mt-2">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">{{ trans('global.no_entries_in_table') }}</div>
                @endforelse
            </div>

            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('global.actions') }}</th>
                            @can('user_delete')
                                <th width="10"></th>
                            @endcan
                            <th>{{ trans('cruds.user.fields.id') }}</th>
                            <th>{{ trans('cruds.user.fields.name') }}</th>
                            <th>{{ trans('cruds.user.fields.email') }}</th>
                            <th>{{ trans('cruds.user.fields.mobile') }}</th>
                            <th>{{ trans('cruds.user.fields.verification_status') }}</th>
                            <th>{{ trans('cruds.user.fields.roles') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    @include('partials.datatablesActions', [
                                        'viewGate' => 'user_show',
                                        'editGate' => 'user_edit',
                                        'deleteGate' => 'user_delete',
                                        'crudRoutePart' => 'users',
                                        'row' => $user,
                                    ])
                                </td>
                                @can('user_delete')
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $user->id }}">
                                    </td>
                                @endcan
                                <td>{{ $user->id ?? '' }}</td>
                                <td>{{ $user->name ?? '' }}</td>
                                <td>{{ $user->email ?? '' }}</td>
                                <td>{{ $user->mobile ?? '' }}</td>
                                <td>
                                    @if($user->verification_status)
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                    @if(!$user->verification_status && $user->user_type === 'agency')
                                        <form method="POST" action="{{ route('admin.users.approveVerification') }}" class="mt-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-info">{{ $role->title }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                @can('user_delete')
                                    <td colspan="8">{{ trans('global.no_entries_in_table') }}</td>
                                @else
                                    <td colspan="7">{{ trans('global.no_entries_in_table') }}</td>
                                @endcan
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}

            @can('user_delete')
                </form>
            @endcan
        </div>
    </div>
@endsection
