<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    //
    public function create() {
        return view('club.register');
    }

    public function update($id) {
        $user = Auth::user();
        $userid = $user->id;
        $attrs = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'contact_name' => 'required',
            'contact_email' =>  ['required', 'email', 'max:254'],
            'website' => 'max:254',
        ]);

        $attrs['updated_by'] = $userid;

        $club = Club::findOrFail($id);
        $club->update($attrs);
        return redirect( '/auth/profile');
}

    public function registerClub() {
        $user = Auth::user();
        $userid = $user->id;
        $attrs = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'contact_name' => 'required',
            'contact_email' =>  ['required', 'email', 'max:254'],
            'website' => 'max:254',
        ]);
        $attrs['created_by'] = $userid;
//        dd($attrs);
        Club::create($attrs);
        return redirect( '/auth/profile');
    }
}
