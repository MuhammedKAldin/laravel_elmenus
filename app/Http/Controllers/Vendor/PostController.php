<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('store_id', Auth::user()->store->id)->get();
        return view('vendor.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('vendor.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'store_id' => Auth::user()->store->id,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        Post::create($data);

        return redirect()->route('vendor.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        if ($post->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        return view('vendor.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        $post->update($data);

        return redirect()->route('vendor.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('vendor.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
} 