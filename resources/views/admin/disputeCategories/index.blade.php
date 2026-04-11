@extends('layouts.admin')

@section('content')
    <div class="row page-actions">
        <div class="col-lg-12">
            <a class="btn btn-primary" href="{{ route('admin.dispute-categories.create') }}">Add Dispute Category</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Dispute Categories</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.dispute-categories.edit', $category) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.dispute-categories.destroy', $category) }}" class="d-inline-block" onsubmit="return confirm('Delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}
        </div>
    </div>
@endsection

