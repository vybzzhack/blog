<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Change a user's role.
     */
    public function changeUserRole(Request $request, User $user)
    {
        // Only proceed if the user is an admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update the user's role
        $user->role = $request->input('role');
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function analytics()
    {
        $postViews = Post::withCount(['views'])->orderBy('views_count', 'desc')->get();
        $postLikes = Post::withCount(['likes'])->orderBy('likes_count', 'desc')->get();
        $postComments = Post::withCount(['comments'])->orderBy('comments_count', 'desc')->get();

        return view('admin.analytics', compact('postViews', 'postLikes', 'postComments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin'
        ]);

        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function index()
    {
        $users = User::all(); // Get all users
        return view('admin.users.index', compact('users')); // Render admin-only user index view
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user')); // Render the edit form
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function pendingPosts()
    {
        $posts = Post::where('status', 'pending')->get();
        return view('admin.pending_posts', compact('posts'));
    }

    // Approve a specific post
    public function approvePost($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'approved';
        $post->save();

        return redirect()->route('admin.pending_posts')->with('success', 'Post approved successfully.');
    }

    public function rejectPost($id)
    {
        $post = Post::findOrFail($id);
        $post->status = 'rejected';
        $post->save();

        return redirect()->route('admin.pendingPosts')->with('success', 'Post rejected successfully.');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
