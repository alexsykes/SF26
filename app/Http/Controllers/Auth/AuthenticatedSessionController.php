<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Rules\ReCaptchaV3;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'g-recaptcha-response' => ['required', new ReCaptchaV3('login')],
        ]);

        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        $username = $user->name;

        $user->last_login = now();
        $user->save();

        $favourites = $user->favourites;
        $ip = $request->getClientIp();
        Log::info("Successful login by $username from IPaddress: $ip");

        return redirect('/sitemap');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
