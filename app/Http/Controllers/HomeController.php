<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $favourites = $user->favourites;

            if ($favourites == '') {
                return redirect()->intended(route('sites', absolute: false));
            } else {
                return redirect()->intended(route('favourites', absolute: false));
            }
        } else {
            $randomSite = Site::inRandomOrder()->first();
            return view('welcome', compact('randomSite'));
        }
    }

    public function credits()
    {
        return view('credits');
    }

}
