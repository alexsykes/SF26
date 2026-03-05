<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'created_by' => ['required', 'integer'],
            'comment' => ['required'],
            'published' => ['boolean'],
            'note' => ['required'],
            'post_id' => ['required', 'exists:posts'],
        ]);

        return Comment::create($data);
    }

    public function show(Comment $comment)
    {
        return $comment;
    }

    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'created_by' => ['required', 'integer'],
            'comment' => ['required'],
            'published' => ['boolean'],
            'note' => ['required'],
            'post_id' => ['required', 'exists:posts'],
        ]);

        $comment->update($data);

        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json();
    }
}
