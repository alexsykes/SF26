<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;

class UserController extends Controller
{
    public function favourites()
    {
        $user_id = auth()->user()->id;

        $siteIDs = User::where('id', $user_id)
            ->select('favourites')
            ->first();

        $siteIDArray = explode(',', $siteIDs['favourites']);

        $sites = Site::whereNotIn('id', $siteIDArray)
            ->orderBy('site_name', 'asc')
            ->get();

        $favourites = Site::whereIn('sites.id', $siteIDArray)
            ->orderBy('site_name', 'asc')
            ->join('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->get();

        return view('user.favourites', compact('sites', 'favourites'));
    }

    public function removeFavourite($id)
    {
        $user = auth()->user();
        $favourites = $user->favourites;
        $favouriteArray = explode(',', $favourites);

        $pos = array_search($id, $favouriteArray);
        array_splice($favouriteArray, $pos, 1);
        $newFavourites = implode(',', $favouriteArray);

        $user->favourites = $newFavourites;
        $user->save();
        return redirect('/user/favourites');
    }

    public function addFavourite($id)
    {
        $user = auth()->user();
        $favourites = $user->favourites;
        $favouriteArray = explode(',', $favourites);
        array_push($favouriteArray, $id);
        $newFavourites = implode(',', $favouriteArray);

        $user->favourites = $newFavourites;
        $user->save();

        return redirect('/user/favourites');
    }
}
