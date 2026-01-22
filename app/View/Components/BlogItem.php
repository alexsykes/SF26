<?php

namespace App\View\Components;

use App\Models\BlogPost;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class BlogItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public BlogPost $blogPost)
    {
        $blogPost = $this->blogPost;

        $created_ = date_create($blogPost->created_at);
        $updated_ = date_create($blogPost->updated_at);
        $this->created_at = date_format($created_, "F dS, Y");
        $diff = date_diff($created_, $updated_);


        $elapsed = $diff->days;
        if ($elapsed > 1) {
            $updated_at = date_format($updated_, "F dS, Y");
            $this->created_at .= " (Updated $updated_at)";
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog-item', ['blogPost' => $this->blogPost, 'created_at' => $this->created_at]);
    }
}
