<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogImages;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BlogService $blogService)
    {
        $blogs = $blogService->fetchBlog($request);
        return Inertia::render('Blogs/index', ['blogs' => $blogs, 'filters' => $request->all('search')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Blogs/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request, BlogService $blogService)
    {
        $blog = $blogService->createBlog($request);

        return Redirect::route('blogs')->with('success', 'Blog has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $images = BlogImages::where('blog_id', $blog->id)->get();
        return Inertia::render('Blogs/edit', ['blogs' => $blog, 'images' => $images]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog, BlogService $blogService)
    {
        $blog = $blogService->updateBlog($request, $blog);

        return Redirect::back()->with('success', 'Blog has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, BlogService $blogService)
    {
        $blog = $blogService->deleteBlog($blog);
        return Redirect::route('blogs')->with('success', 'Blog has been deleted.');
    }
}
