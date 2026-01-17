<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::all();
        return view('blogs.index', compact('posts'));
    }

    public function store(BlogPostRequest $request)
    {
        info("Processing");
        $attributes = $request->validated();

        $attributes['created_by'] = auth()->id();
        $attributes['published'] = true;

        $blogPost = BlogPost::create($attributes);
        return redirect('/blog');
    }

    public function show(BlogPost $blogPost)
    {
        return $blogPost;
    }

    public function edit()
    {
        $id = request('id');
        $blogPost = BlogPost::findOrFail($id);
        return view('blogs.edit', compact('blogPost'));
    }

    public function update(BlogPostRequest $request)
    {
        $blogPost = BlogPost::findOrFail($request->id);
        $attributes = $request->validated();
        $attributes['updated_by'] = auth()->id();
        $blogPost->update($attributes);

        return redirect('/blog');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return response()->json();
    }

    public function form()
    {
        return view('blogs.form');
    }
}
