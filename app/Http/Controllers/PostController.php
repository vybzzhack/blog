<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function landingPage()
    {
        $posts = Post::where('status', 'approved')->inRandomOrder()->take(10)->get();
        return view('landing', compact('posts'));

        $posts = Post::with('comments')->get(); // Fetch all posts with comments
        return view('landing', compact('posts')); // Pass all posts to the view
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show the create post form
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $imagePath;
        }

        // Add the authenticated user ID to the request
        $validated['user_id'] =auth()->id();

        // Create the post
        Post::create($validated);

        // Redirect back with a success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the post by ID
        $post = Post::findOrFail($id);
        
        // Show the post details
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the post by ID
        $post = Post::findOrFail($id);

        if (!auth()->user()->isAdmin() && auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Show the edit post form with post data
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Fetch the post by ID
        $post = Post::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $validated['image'] = $imagePath;
        }

        // Update the post
        $post->update($validated);

        if (!auth()->user()->isAdmin() && auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Redirect back with a success message
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the post by ID
        $post = Post::findOrFail($id);

        // Delete the associated image if it exists
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        if (!auth()->user()->isAdmin() && auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the post
        $post->delete();

        // Redirect back with a success message
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = Post::where('user_id', $user->id)->get();
        return view('posts.my-posts', compact('posts'));
    }

}
