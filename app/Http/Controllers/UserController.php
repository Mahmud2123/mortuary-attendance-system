<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'staff_id'  => 'required|string|max:50|unique:users,staff_id',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8',
            'role'      => 'required|in:admin,attendant,management',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status']   = 'active';

        $user = User::create($validated);
        AuditLog::record('create', 'users', $user->id, null, $user->makeHidden('password')->toArray());

        return redirect()->route('users.index')->with('success', 'Staff account created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'staff_id'  => 'required|string|max:50|unique:users,staff_id,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,attendant,management',
            'status'    => 'required|in:active,inactive',
            'password'  => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $old = $user->makeHidden('password')->toArray();
        $user->update($validated);
        AuditLog::record('update', 'users', $user->id, $old, $user->fresh()->makeHidden('password')->toArray());

        return redirect()->route('users.index')->with('success', 'Staff account updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['status' => 'inactive']);
        AuditLog::record('update', 'users', $user->id, null, ['status' => 'inactive']);

        return redirect()->route('users.index')->with('success', 'Staff account deactivated.');
    }
}
