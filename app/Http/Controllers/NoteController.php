<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{


    public function store(){

        $created_by = Auth()->id();
        request()->validate([
            'description' => ['required', 'min:3'],
        ]);

        Note::create([
            'item_id' => request('item_id'),
            'note' => request('description'),
            'type' => request('type'),
            'user_id' => $created_by,
        ]);
        return redirect('/');
    }

    public function list() {
        $processed = Note::where('completed', true)->get()->sortByDesc('created_at');
        $pending = Note::where('completed', false)->get()->sortBy('created_at');

        return view('notes.list', ['pending' => $pending, 'processed' => $processed]);
    }


}
