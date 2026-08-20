<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
 public function index()
    {
        $users = User::with('roles')->paginate(15);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.roles', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->syncRoles($request->roles ?? []);

        return redirect()
            ->route('users.index')
            ->with('status', "Roles updated for {$user->name}");
    }
}