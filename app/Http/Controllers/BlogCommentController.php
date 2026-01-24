<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index()
    {
        return BlogComment::all();
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $userID = $user->id;
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:255'],
        ]);

        $data['created_by'] = $userID;
        $data['post_id'] = $request->post_id;
        $data['published'] = true;

        return BlogComment::create($data);
    }

    public function show(BlogComment $blogComment)
    {
        return $blogComment;
    }

    public function update(Request $request, BlogComment $blogComment)
    {
        $data = $request->validate([
            'created_by' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
            'comment' => ['required'],
            'published' => ['boolean'],
            'note' => ['nullable'],
        ]);

        $blogComment->update($data);

        return $blogComment;
    }

    public function destroy(BlogComment $blogComment)
    {
        $blogComment->delete();

        return response()->json();
    }
}
