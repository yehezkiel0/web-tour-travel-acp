<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest()->paginate(10);
        $categories = BlogCategory::all();

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $post = new BlogPost();
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->user_id = Auth::id(); // Assuming admin is logged in
        $post->is_published = $request->has('is_published');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('admin_blog_index')->with('success', 'Blog post created successfully!');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->is_published = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('blog', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('admin_blog_index')->with('success', 'Blog post updated successfully!');
    }

    public function delete(BlogPost $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin_blog_index')->with('success', 'Blog post deleted successfully!');
    }

    // Category Management
    public function categories()
    {
        $categories = BlogCategory::withCount('posts')->get();
        return view('admin.blog.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
        ]);

        BlogCategory::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin_blog_categories')->with('success', 'Category created successfully!');
    }

    public function deleteCategory(BlogCategory $category)
    {
        $category->delete();
        return redirect()->route('admin_blog_categories')->with('success', 'Category deleted successfully!');
    }
}
