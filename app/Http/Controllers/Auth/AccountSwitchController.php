<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSwitchController extends Controller
{
    public function add(LoginRequest $request): RedirectResponse
    {
        $accountIds = $request->session()->get('signed_in_account_ids', []);
        $accountIds = is_array($accountIds) ? array_map('intval', $accountIds) : [];
        $accountIds[] = (int) $request->user()->getAuthIdentifier();

        $request->authenticate();

        $accountIds[] = (int) Auth::id();
        $request->session()->put('signed_in_account_ids', array_values(array_unique($accountIds)));
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('login_succeeded', true);
    }

    public function switch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'account_id' => ['required', 'integer', 'min:1'],
        ]);

        $accountIds = $request->session()->get('signed_in_account_ids', []);
        $accountIds = is_array($accountIds) ? array_map('intval', $accountIds) : [];
        $accountIds[] = (int) $request->user()->getAuthIdentifier();

        abort_unless(
            in_array((int) $validated['account_id'], $accountIds, true),
            403
        );

        $account = User::query()->findOrFail($validated['account_id']);

        Auth::login($account);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
