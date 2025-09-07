<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index()
    {
        $posts = Post::published()->with(['user', 'media'])->paginate(12);
        return view('public.posts.index', compact('posts'));
    }

    /**
     * Display the specified post.
     */
    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->with(['user', 'media'])->firstOrFail();
        return view('public.posts.show', compact('post'));
    }
}
