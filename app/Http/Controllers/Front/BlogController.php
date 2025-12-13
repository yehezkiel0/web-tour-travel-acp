<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::where('is_published', true)->with(['category', 'author']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(9);
        $recentPosts = BlogPost::where('is_published', true)->latest()->take(5)->get();
        $categories = BlogCategory::withCount([
            'posts' => function ($q) {
                $q->where('is_published', true);
            }
        ])->get();

        return view('front.blog.index', compact('posts', 'recentPosts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->with(['category', 'author', 'comments.user', 'comments.replies.user'])->firstOrFail();

        // Increment views
        $post->increment('views');

        $recentPosts = BlogPost::where('is_published', true)->where('id', '!=', $post->id)->latest()->take(5)->get();
        $categories = BlogCategory::withCount([
            'posts' => function ($q) {
                $q->where('is_published', true);
            }
        ])->get();

        return view('front.blog.show', compact('post', 'recentPosts', 'categories'));
    }
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $post = BlogPost::findOrFail($id);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_approved' => true // Auto-approve for now, change if moderation needed
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }
}
