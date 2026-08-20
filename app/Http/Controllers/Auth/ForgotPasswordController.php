<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');


    }

    public function store(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with(
            $status === Password::RESET_LINK_SENT
                ? ['status' => __($status)]
                : ['error' => __($status)]
        );
    }
}