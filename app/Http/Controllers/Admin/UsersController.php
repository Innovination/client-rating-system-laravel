<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserStatusRequest;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\AgencyApprovedNotification;
use App\Services\ModerationService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function __construct(
        protected ModerationService $moderationService
    ) {
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query = User::with(['roles'])
            ->select('users.*');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->input('user_type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $allowedSorts = ['id', 'name', 'email', 'mobile'];
        $sortBy = $request->input('sort_by', 'id');
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }
        $sortDir = $request->input('sort_dir', 'asc') === 'desc' ? 'desc' : 'asc';

        $users = $query
            ->orderBy($sortBy, $sortDir)
            ->paginate(25)
            ->appends($request->query());

        $userTypes = User::query()
            ->select('user_type')
            ->whereNotNull('user_type')
            ->distinct()
            ->orderBy('user_type')
            ->pluck('user_type');

        $userStatuses = [User::STATUS_ACTIVE, User::STATUS_SUSPENDED];

        return view('admin.users.index', compact('users', 'userTypes', 'userStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['role'] = $data['role'] ?? User::ROLE_AGENCY;
        $data['status'] = $data['status'] ?? User::STATUS_ACTIVE;
        $data['user_type'] = $data['user_type'] ?? $data['role'];

        $user = User::create($data);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (array_key_exists('role', $data) && ! array_key_exists('user_type', $data)) {
            $data['user_type'] = $data['role'];
        }

        $user->update($data);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back();
        }

        User::whereIn('id', $ids)->delete();

        return back();
    }

    public function approveVerification(Request $request)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->validate([
            'id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $user = User::findOrFail($request->input('id'));
        $user->update(['verification_status' => true]);
        $user->notify(new AgencyApprovedNotification());

        return back()->with('success', 'Agency profile approved successfully.');
    }

    public function suspend(UpdateUserStatusRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($user->id === auth()->id()) {
            return back()->withErrors(['status' => 'You cannot suspend your own account.']);
        }

        $this->moderationService->suspendUser(
            admin: $request->user(),
            target: $user,
            reason: $request->validated('reason')
        );

        return back()->with('message', 'User suspended successfully.');
    }

    public function unsuspend(UpdateUserStatusRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->moderationService->unsuspendUser(
            admin: $request->user(),
            target: $user,
            reason: $request->validated('reason')
        );

        return back()->with('message', 'User reactivated successfully.');
    }
}
