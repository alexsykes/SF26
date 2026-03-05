<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'subtitle' => ['required'],
            'context' => ['required'],
            'category' => ['required'],
            'created_by' => ['required', 'integer'],
            'updated_by' => ['required', 'integer'],
        ]);

        return Post::create($data);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required'],
            'subtitle' => ['required'],
            'context' => ['required'],
            'category' => ['required'],
            'created_by' => ['required', 'integer'],
            'updated_by' => ['required', 'integer'],
        ]);

        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json();
    }
}
