@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Blog Posts</h1>
                <div class="ml-auto flex gap-2">
                    <a href="{{ route('admin_blog_create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Add New Post</a>
                    <a href="{{ route('admin_blog_categories') }}"
                        class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition">Manage
                        Categories</a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-4">
                <form action="{{ route('admin_blog_index') }}" method="GET" class="mb-4 flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-1/3"
                        placeholder="Search by title..." value="{{ request('search') }}">
                    <select name="category" class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-1/3">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Author</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        @if ($post->image)
                                            <img src="{{ Storage::url($post->image) }}" alt=""
                                                class="w-16 h-12 object-cover rounded">
                                        @else
                                            <span class="text-xs text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $post->title }}</td>
                                    <td class="px-4 py-3">{{ $post->category->name }}</td>
                                    <td class="px-4 py-3">
                                        @if ($post->is_published)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>
                                        @else
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $post->author->name }}</td>
                                    <td class="px-4 py-3 flex gap-2">
                                        <a href="{{ route('admin_blog_edit', $post->id) }}"
                                            class="text-blue-600 hover:text-blue-800"><i class="fa-solid fa-edit"></i></a>
                                        <form action="{{ route('admin_blog_delete', $post->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No posts found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $posts->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
