@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Blog Categories</h1>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Create Category -->
                <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Create New Category</h2>
                    <form action="{{ route('admin_blog_category_store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Name</label>
                            <input type="text" name="name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                                required>
                        </div>
                        <button
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition w-full">Create</button>
                    </form>
                </div>

                <!-- List Categories -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Categories List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Posts</th>
                                    <th class="px-4 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                                        <td class="px-4 py-3">{{ $category->posts_count }}</td>
                                        <td class="px-4 py-3">
                                            <form action="{{ route('admin_blog_category_delete', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
