<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisputeCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DisputeCategoriesController extends Controller
{
    public function index(): View
    {
        $categories = DisputeCategory::query()->orderBy('name')->paginate(25);

        return view('admin.disputeCategories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DisputeCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::lower(Str::random(4)),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return back()->with('message', 'Dispute category created successfully.');
    }

    public function update(Request $request, DisputeCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $category->update([
            'name' => $validated['name'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('message', 'Dispute category updated successfully.');
    }

    public function destroy(DisputeCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('message', 'Dispute category deleted successfully.');
    }
}
