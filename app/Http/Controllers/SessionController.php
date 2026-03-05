<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        //        validate
        $attrs = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($attrs)) {
            throw ValidationException::withMessages([
                'password' => ['The email address and/or password you entered is incorrect.'],

            ]);
        }

        request()->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/');
    }
}
