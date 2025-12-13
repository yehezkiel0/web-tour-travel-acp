@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Post</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin_blog_index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">Back</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('admin_blog_update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ $post->title }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Category</label>
                        <select name="category_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Content</label>
                        <textarea name="content"
                            class="summernote w-full border border-gray-300 rounded-lg px-4 py-2 h-64 focus:ring focus:ring-blue-200" required>{{ $post->content }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Thumbnail</label>
                        @if ($post->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($post->image) }}" class="w-48 rounded object-cover">
                            </div>
                        @endif
                        <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-4 py-2"
                            accept="image/*">
                    </div>

                    <div class="mb-6 flex items-center">
                        <input type="checkbox" name="is_published" id="is_published"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            {{ $post->is_published ? 'checked' : '' }}>
                        <label for="is_published" class="ml-2 text-gray-700 font-medium">Publish immediately</label>
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Update
                        Post</button>
                </form>
            </div>
        </div>
    </div>
@endsection
