<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogService
{
    function fetchBlog(Request $request): LengthAwarePaginator
    {
        $search = $request->input('search');
        $blog = Blog::query()->when($search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return $blog;
    }

    public function createBlog(Request $request): Blog
    {
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content
        ]);

        return $blog;
    }

    public function updateBlog(Request $request, Blog $blog): Blog
    {
        $blog = Blog::findOrFail($blog->id);


        $blog->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content
        ]);

        return $blog;
    }

    public function deleteBlog(Blog $blog): Blog
    {
        $blog = Blog::findOrFail($blog->id);
        $blog->delete();
        return $blog;
    }
}
