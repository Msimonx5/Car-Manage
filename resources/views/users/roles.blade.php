{{-- resources/views/users/roles.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-8">
    <h1 class="text-xl font-bold mb-4">
        Assign Roles — {{ $user->name }}
    </h1>

    <form method="POST" action="{{ route('users.roles.update', $user) }}">
        @csrf
        @method('PUT')

        @foreach ($roles as $role)
            <label class="flex items-center gap-2 mb-2">
                <input
                    type="checkbox"
                    name="roles[]"
                    value="{{ $role->name }}"
                    {{ $user->hasRole($role->name) ? 'checked' : '' }}
                >
                {{ ucfirst($role->name) }}
            </label>
        @endforeach

        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
            Update Roles
        </button>
    </form>

    <a href="{{ route('users.index') }}" class="block mt-4 text-sm text-gray-500">
        ← Back to users
    </a>
</div>
@endsection