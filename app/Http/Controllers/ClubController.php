<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::all();
        return view('clubs.index', compact('clubs'));
    }

    public function edit($id)
    {
        $club = Club::find($id);
        return view('clubs.edit', compact('club'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => ['required'],
            'Area' => ['required'],
            'Contact' => ['required'],
            'Email' => ['required', 'email'],
            'Phone' => ['nullable'],
            'Website' => ['nullable'],
            'Description' => ['required'],
            'Notes' => ['nullable'],
        ]);

        Club::create($data);
        return redirect('clubs')->with('success', 'Club Added Successfully');
    }

    public function show(Club $club)
    {
        return $club;
    }

    public function add()
    {
        return view('clubs.club');
    }

    public function update(Request $request)
    {
        $club = Club::find($request->id);

        $data = $request->validate([
            'Name' => ['required'],
            'Area' => ['required'],
            'Contact' => ['required'],
            'Email' => ['required', 'email'],
            'Phone' => ['nullable'],
            'Website' => ['nullable'],
            'Description' => ['required'],
            'Notes' => ['nullable'],
        ]);

        $club->update($data);
        return redirect('clubs')->with('success', 'Club Updated Successfully');
    }

    public function destroy(Club $club)
    {
        $club->delete();

        return response()->json();
    }


}
