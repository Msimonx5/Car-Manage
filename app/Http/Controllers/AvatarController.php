<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AvatarController extends Controller
{
    private const ICONS = [
        'bi-person',
        'bi-person-circle',
        'bi-person-badge',
        'bi-emoji-smile',
        'bi-briefcase',
        'bi-star',
        'bi-shield-check',
        'bi-lightning-charge',
    ];

    public function show(Request $request)
    {
        $path = $request->user()->avatar_path;

        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $user = $request->user();
        $oldPath = $user->avatar_path;
        $newPath = $request->file('avatar')->store('avatars/' . $user->getAuthIdentifier(), 'public');

        if (! $newPath) {
            return back()->withErrors(['avatar' => 'Impossible de sauvegarder cette image.']);
        }

        $user->forceFill([
            'avatar_path' => $newPath,
            'avatar_icon' => null,
        ])->save();

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return back()->with('status', 'avatar-updated');
    }

    public function chooseIcon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'avatar_icon' => ['required', Rule::in(self::ICONS)],
        ]);

        $user = $request->user();
        $oldPath = $user->avatar_path;
        $user->forceFill([
            'avatar_path' => null,
            'avatar_icon' => $validated['avatar_icon'],
        ])->save();

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return back()->with('status', 'avatar-icon-updated');
    }
}