<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BlogService
{
    public function createBlog(Request $request): Blog
    {
        //Create blog
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content
        ]);

        return $blog;
    }
}
