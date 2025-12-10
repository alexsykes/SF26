<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    //
    public function resetPassword()
    {
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );

        $status == Password::PASSWORD_RESET;
        if($status) {
            return redirect('login')->with('status', __($status));

        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }
}
