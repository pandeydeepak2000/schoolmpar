<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManageController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name',  'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users-create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|exists:roles,name',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        ActivityLog::record(
            'create_user',
            'Admin created new user account: ' . $user->name . ' (' . $user->email . ') with role: ' . $request->role,
            'User',
            $user->id
        );

        return redirect()->route('admin.users')->with('success', '✅ User account created successfully!');
    }

    public function edit($id)
    {
        $user  = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users-edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|exists:roles,name',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        ActivityLog::record(
            'update_user',
            'Admin updated user account: ' . $user->name . ' (' . $user->email . ')',
            'User',
            $user->id
        );

        return redirect()->route('admin.users')->with('success', '✅ User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', '⚠️ You cannot delete your own logged-in administrator account.');
        }

        $userName  = $user->name;
        $userEmail = $user->email;
        $user->delete();

        ActivityLog::record(
            'delete_user',
            'Admin deleted user account: ' . $userName . ' (' . $userEmail . ')',
            'User',
            $id
        );

        return redirect()->route('admin.users')->with('success', '🗑️ User account deleted successfully!');
    }
}