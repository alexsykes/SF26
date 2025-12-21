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

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name' => ['required'],
            'Area' => ['required'],
            'Contact' => ['required'],
            'Email' => ['required'],
            'Phone' => ['nullable'],
            'Website' => ['nullable'],
            'Description' => ['required'],
            'Notes' => ['nullable'],
        ]);

        return Club::create($data);
    }

    public function show(Club $club)
    {
        return $club;
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'Name' => ['required'],
            'Area' => ['required'],
            'Contact' => ['required'],
            'Email' => ['required'],
            'Phone' => ['nullable'],
            'Website' => ['nullable'],
            'Description' => ['required'],
            'Notes' => ['nullable'],
        ]);

        $club->update($data);

        return $club;
    }

    public function destroy(Club $club)
    {
        $club->delete();

        return response()->json();
    }
}
