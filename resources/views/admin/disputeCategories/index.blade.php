@extends('layouts.admin')

@section('content')
<div class="card mb-3">
    <div class="card-header">Add Dispute Category</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.dispute-categories.store') }}" class="form-inline">
            @csrf
            <input type="text" name="name" class="form-control mr-2 mb-2" placeholder="Category name" required>
            <label class="mr-2 mb-2"><input type="checkbox" name="is_active" value="1" checked> Active</label>
            <button class="btn btn-primary mb-2" type="submit">Add</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Dispute Categories</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            <form method="POST" action="{{ route('admin.dispute-categories.update', $category) }}" class="form-inline">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" class="form-control form-control-sm mr-2" value="{{ $category->name }}" required>
                                <label class="mr-2"><input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}> Active</label>
                                <button class="btn btn-sm btn-outline-primary" type="submit">Save</button>
                            </form>
                        </td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.dispute-categories.destroy', $category) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
</div>
@endsection
