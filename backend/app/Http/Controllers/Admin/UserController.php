<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $users = User::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->q.'%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term);
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->role))
            ->latest()
            ->paginate(20);

        $roles = User::roleOptions();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $roles = User::roleOptions();
        $permissions = User::rolePermissions();

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'role' => ['required', Rule::in(array_keys(User::roleOptions()))],
        ]);

        if ($user->is(auth()->user()) && $user->role === User::ROLE_ADMIN && $data['role'] !== User::ROLE_ADMIN) {
            return back()->withErrors(['role' => 'You cannot remove your own admin role while signed in.'])->withInput();
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated.');
    }

    public function roles()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        return view('admin.users.roles', [
            'roles' => User::roleOptions(),
            'permissions' => User::rolePermissions(),
        ]);
    }
}
