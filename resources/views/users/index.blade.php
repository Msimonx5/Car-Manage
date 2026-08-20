{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="text-xl font-bold mb-4">Users</h1>

    <table class="w-full border-collapse">
        <thead>
            <tr class="text-left border-b">
                <th class="py-2">Name</th>
                <th class="py-2">Email</th>
                <th class="py-2">Roles</th>
                <th class="py-2"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b">
                    <td class="py-2">{{ $user->name }}</td>
                    <td class="py-2">{{ $user->email }}</td>
                    <td class="py-2">
                        @forelse ($user->roles as $role)
                            <span class="inline-block px-2 py-1 text-xs bg-gray-200 rounded mr-1">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-gray-400 text-sm">No roles</span>
                        @endforelse
                    </td>
                    <td class="py-2">
                        <a href="{{ route('users.roles.edit', $user) }}" class="text-blue-600 hover:underline">
                            Edit Roles
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection