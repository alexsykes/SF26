<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    // New stuff
    {
        if (! isset($_COOKIE['curLat']) || ! isset($_COOKIE['curLat'])) {
            $curLat = 53.59476;
            $curLng = -2.56092;

            setcookie(
                'curLat',
                $curLat,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );

            setcookie(
                'curLng',
                $curLng,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );
        } else {
            $curLat = $_COOKIE['curLat'];
            $curLng = $_COOKIE['curLng'];
        }

        if (! isset($_COOKIE['curZoom'])) {
            setcookie(
                'curZoom',
                7,
                [
                    'expires' => time() + 3600 * 24 * 365,
                    'path' => '/',
                ]
            );
        }

        // New stuff ends

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
