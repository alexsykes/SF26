<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(20);

        return view('blogs.index', compact('posts'));
    }

    public function store(BlogPostRequest $request)
    {
        info('Processing');
        $attributes = $request->validated();

        $attributes['created_by'] = auth()->id();
        $attributes['published'] = $request->published == 'on' ? true : false;

        $blogPost = BlogPost::create($attributes);

        return redirect('/blogs');
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
        $attributes['published'] = $request->published == 'on' ? true : false;
        $blogPost->update($attributes);

        return redirect('/blogs');
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

    public function display()
    {
        $blogPosts = BlogPost::where('published', true)
            ->where('id', 4)
            ->orderBy('created_at', 'desc')
            ->get();

        //        $blogPosts = BlogPost::find(3)
        //            ->get();
        //        dd($blogPosts);
        return view('blogs.blog', compact('blogPosts'));
    }
}
