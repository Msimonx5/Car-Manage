@extends('layouts.app')

@section('title','UsersRoles')

@section('content')

<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="role">Role</label>

    <select name="role" id="role">
        <option value="admin" @selected($user->hasRole('admin'))>
            Admin
        </option>

        <option value="manager" @selected($user->hasRole('manager'))>
            Manager
        </option>

        <option value="employee" @selected($user->hasRole('employee'))>
            Employee
        </option>
    </select>

    <button type="submit">
        Update Role
    </button>
</form>