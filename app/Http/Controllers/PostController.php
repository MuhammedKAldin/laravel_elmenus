<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Store;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Store $store, Post $post)
    {
        // Get recent posts from the same store
        $recentPosts = $store->posts()
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();

        return view('posts.show', compact('store', 'post', 'recentPosts'));
    }
} 