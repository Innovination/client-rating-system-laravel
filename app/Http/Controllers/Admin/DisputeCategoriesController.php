<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDisputeCategoryRequest;
use App\Http\Requests\Admin\UpdateDisputeCategoryRequest;
use App\Models\DisputeCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DisputeCategoriesController extends Controller
{
    public function index(): View
    {
        $categories = DisputeCategory::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.disputeCategories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.disputeCategories.create');
    }

    public function store(StoreDisputeCategoryRequest $request): RedirectResponse
    {
        DisputeCategory::create([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug'),
            'is_active' => (bool) $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.dispute-categories.index')->with('message', 'Dispute category created successfully.');
    }

    public function edit(DisputeCategory $dispute_category): View
    {
        return view('admin.disputeCategories.edit', ['category' => $dispute_category]);
    }

    public function update(UpdateDisputeCategoryRequest $request, DisputeCategory $dispute_category): RedirectResponse
    {
        $dispute_category->update([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug'),
            'is_active' => (bool) $request->boolean('is_active', false),
        ]);

        return redirect()->route('admin.dispute-categories.index')->with('message', 'Dispute category updated successfully.');
    }

    public function destroy(DisputeCategory $dispute_category): RedirectResponse
    {
        $dispute_category->delete();

        return back()->with('message', 'Dispute category deleted successfully.');
    }
}

