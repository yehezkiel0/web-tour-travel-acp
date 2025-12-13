@extends('front.layout.app')

@section('title', $post->title)

@section('content')
    <div class="bg-white">
        <!-- Hero Image -->
        <div class="relative h-96 w-full">
            @if ($post->image)
                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-6xl text-gray-300"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute bottom-0 left-0 w-full p-8 md:p-16 text-white container mx-auto">
                <span
                    class="bg-blue-600 text-xs px-3 py-1 rounded-full uppercase tracking-wider font-semibold mb-4 inline-block">{{ $post->category->name }}</span>
                <h1 class="text-3xl md:text-5xl font-bold font-serif mb-4">{{ $post->title }}</h1>
                <div class="flex items-center text-sm md:text-base space-x-6">
                    <span><i class="far fa-user mr-2"></i>{{ $post->author->name }}</span>
                    <span><i class="far fa-calendar-alt mr-2"></i>{{ $post->created_at->format('M d, Y') }}</span>
                    <span><i class="far fa-eye mr-2"></i>{{ $post->views }} Views</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12 flex flex-col lg:flex-row gap-12">
            <!-- Content -->
            <div class="lg:w-2/3">
                <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-12">
                    {!! $post->content !!}
                </article>

                <hr class="border-gray-200 my-8">

                <!-- Comments Section -->
                <div id="comments" class="bg-gray-50 rounded-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 font-serif">Comments ({{ $post->comments->count() }})
                    </h3>

                    @auth
                        <form action="{{ route('blog.comment.store', $post->id) }}" method="POST" class="mb-10">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium mb-2">Leave a comment</label>
                                <textarea name="content" rows="3"
                                    class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all"
                                    placeholder="Share your thoughts..." required></textarea>
                            </div>
                            <button
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">Post
                                Comment</button>
                        </form>
                    @else
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-10 text-center">
                            <p class="text-blue-800">Please <a href="{{ route('login') }}" class="font-bold underline">login</a>
                                to leave a comment.</p>
                        </div>
                    @endauth

                    <div class="space-y-8">
                        @foreach ($post->comments as $comment)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    @if ($comment->user->photo)
                                        <img src="{{ Storage::url($comment->user->photo) }}"
                                            class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xl">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-bold text-gray-900">{{ $comment->user->name }}</h4>
                                        <span
                                            class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                                        {{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar (Similar to index) -->
            <div class="lg:w-1/3">
                <div class="sticky top-8 space-y-8">
                    <!-- Search -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif">Search</h3>
                        <form action="{{ route('blog.index') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Search articles..."
                                    class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-3 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none bg-white">
                                <button class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif">More to Read</h3>
                        <div class="space-y-4">
                            @foreach ($recentPosts as $recent)
                                <div class="flex gap-4">
                                    <a href="{{ route('blog.show', $recent->slug) }}"
                                        class="block w-20 h-20 flex-shrink-0">
                                        @if ($recent->image)
                                            <img src="{{ Storage::url($recent->image) }}" alt=""
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div
                                                class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i></div>
                                        @endif
                                    </a>
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800 line-clamp-2 mb-1">
                                            <a href="{{ route('blog.show', $recent->slug) }}"
                                                class="hover:text-blue-600 transition-colors">{{ $recent->title }}</a>
                                        </h4>
                                        <span
                                            class="text-xs text-gray-500">{{ $recent->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
