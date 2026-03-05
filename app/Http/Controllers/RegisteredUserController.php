<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\ReCaptchaV3;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function store()
    {
        $attrs = request()->validate([
            'name' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required', Password::min(6), 'confirmed'],
            'g-recaptcha-response' => ['required', new ReCaptchaV3('submitRegister')],
        ]);

        $attrs['accept_terms'] = request()->has('accept_terms');
        $attrs['user_id'] = 0;

        $user = User::create($attrs);
        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $sites = $user->sites;
        $clubs = $user->clubs;
        $isSuperUser = $user->isSuperUser;
        $isEditor = $user->isEditor;

        $favourites = DB::select('SELECT sites.*, favourites.id AS favID FROM favourites JOIN sites ON favourites.site_id = sites.id  WHERE favourites.user_id = ? ORDER BY sites.site_name', [$user->id]);

        if ($isSuperUser) {
            $sitesWithNotes = DB::table('sites')
                ->rightJoin('notes', 'sites.id', '=', 'notes.item_id')
                ->where('notes.completed', '=', 0)
                ->get()
                ->sortBy('site_name');

            //            $users = User::all()->sortBy(['isSuperUser' , 'isEditor', 'email']);

            $users = DB::table('users')
                ->orderBy('isSuperUser', 'desc')
                ->orderBy('isEditor', 'desc')
                ->orderBy('name', 'asc')
                ->get();

            return view('auth.profile', ['sites' => $sites, 'clubs' => $clubs, 'sitesWithNotes' => $sitesWithNotes, 'users' => $users, 'favourites' => $favourites]);

        } else {

            return view('auth.profile', ['sites' => $sites, 'clubs' => $clubs, 'favourites' => $favourites]);
        }
    }

    public function editUserProfile($id)
    {
        $user = User::find($id);
        //        dd($user);

        return view('auth.userProfile', ['user' => $user]);
    }

    public function updateUserProfile()
    {
        $adminUser = Auth::user()->id;
        $attrs = request()->validate([
            'userID' => ['required'],
            'name' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email', 'max:254'],
        ]);

        $isEditor = 0;
        $isSuperUser = 0;
        if (isset(request()->isEditor)) {
            $isEditor = 1;
        }

        if (isset(request()->isSuperUser)) {
            $isSuperUser = 1;
        }

        $userID = $attrs['userID'];
        $user = User::findOrFail($userID);

        $user->update([
            'name' => $attrs['name'],
            'username' => $attrs['username'],
            'email' => $attrs['email'],
            'updated_at' => NOW(),
            'isEditor' => $isEditor,
            'isSuperUser' => $isSuperUser,
        ]);

        //        dd($user);

        return redirect('auth/profile');
    }
}
