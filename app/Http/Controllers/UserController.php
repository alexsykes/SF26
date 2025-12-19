<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function favourites()
    {
        $user_id = auth()->user()->id;

//        Get siteIDs from logged in user
        $siteIDs = User::where('id', $user_id)
            ->select('favourites')
            ->first();

        $siteIDArray = explode(',', $siteIDs['favourites']);

        $favourites = DB::table('sites')
            ->leftJoin('forecasts', 'sites.id', '=', 'forecasts.site_id')
            ->whereIn('sites.id', $siteIDArray)
            ->select('sites.*', 'forecasts.data')
            ->orderBy('site_name')
            ->get()
            ->toArray();

//        dd($favourites[0]->data);
        return view('user.favourites', compact('favourites'));
    }

    public function removeFavourite($id)
    {
        $user = auth()->user();
        $favourites = $user->favourites;
        $favouriteArray = explode(',', $favourites);

        $pos = array_search($id, $favouriteArray);
        array_splice($favouriteArray, $pos, 1);
        $newFavourites = implode(',', $favouriteArray);

        $user->favourites = trim($newFavourites, " ,\n\r\t\v\x00");
        $user->save();
        return redirect('/user/favourites');
    }

    public function addFavourite($id)
    {
        $user = auth()->user();
        $favourites = trim($user->favourites, " ,\n\r\t\v\x00");
        $favouriteArray = explode(',', $favourites);
        array_push($favouriteArray, $id);
        $newFavourites = implode(',', $favouriteArray);

        $user->favourites = $newFavourites;
        $user->save();

        return redirect('/user/favourites');
    }

    public function getNearest()
    {

    }

    public function unsubscribe()
    {

    }
}
