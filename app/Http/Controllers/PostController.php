<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check if user can access the post (own post or admin)
     */
    private function authorizePostAccess($post)
    {
        if (!Auth::user()->isAdmin() && $post->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to access this post.');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admins can see all posts, regular users only see their own
        if (Auth::user()->isAdmin()) {
            $posts = Post::with('user')->paginate(10);
        } else {
            $posts = Post::where('user_id', Auth::id())->with('user')->paginate(10);
        }
        
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ];

        // Handle published_at based on status
        if ($request->status === 'published') {
            // Always publish immediately when status is "published"
            $data['published_at'] = now();
        } else {
            // Draft status, clear published_at
            $data['published_at'] = null;
        }

        $post = Post::create($data);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $post->addMedia($file)->toMediaCollection('posts');
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with(['user', 'media'])->findOrFail($id);
        $this->authorizePostAccess($post);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::with('media')->findOrFail($id);
        $this->authorizePostAccess($post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorizePostAccess($post);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
        ];

        // Handle published_at based on status
        if ($request->status === 'published') {
            // Always publish immediately when status is "published"
            $data['published_at'] = now();
        } else {
            // Draft status, clear published_at
            $data['published_at'] = null;
        }

        $post->update($data);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $post->addMedia($file)->toMediaCollection('posts');
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->authorizePostAccess($post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Remove media from a post.
     */
    public function destroyMedia(Request $request, string $postId, string $mediaId)
    {
        $post = Post::findOrFail($postId);
        $this->authorizePostAccess($post);
        $media = $post->media()->findOrFail($mediaId);
        
        $media->delete();
        
        return redirect()->back()->with('success', 'Media file removed successfully.');
    }
}
