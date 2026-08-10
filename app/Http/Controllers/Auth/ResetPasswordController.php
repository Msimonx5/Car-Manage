<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function create(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    public function store(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user) use ($request) {

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }
}