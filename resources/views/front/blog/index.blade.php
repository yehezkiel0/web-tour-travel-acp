@extends('front.layout.app')

@section('title', 'Travel Blog & Tips')

@section('content')
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4 font-serif">{{ __('messages.blog_title') }}</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ __('messages.blog_subtitle') }}</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($posts as $post)
                            <div
                                class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <div class="relative h-48 overflow-hidden">
                                        @if ($post->image)
                                            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}"
                                                class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div
                                                class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                <i class="fas fa-image text-3xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute top-4 left-4">
                                            <span
                                                class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full uppercase tracking-wider font-semibold">{{ $post->category->name }}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="mr-4"><i
                                                class="far fa-calendar-alt mr-2"></i>{{ $post->created_at->format('M d, Y') }}</span>
                                        <span><i class="far fa-user mr-2"></i>{{ $post->author->name }}</span>
                                    </div>
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <h3
                                            class="text-xl font-bold text-gray-800 mb-3 hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $post->title }}</h3>
                                    </a>
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($post->content), 120) }}</p>
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="inline-flex items-center text-blue-600 font-semibold hover:underline">
                                        {{ __('messages.read_more') }} <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-12">
                                <div class="text-gray-400 mb-4"><i class="far fa-newspaper text-5xl"></i></div>
                                <h3 class="text-xl font-semibold text-gray-600">{{ __('messages.no_stories') }}</h3>
                                <p class="text-gray-500">{{ __('messages.no_stories_desc') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $posts->withQueryString()->links() }}
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:w-1/3 space-y-8">
                    <!-- Search -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif">{{ __('messages.search') }}</h3>
                        <form action="{{ route('blog.index') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="{{ __('messages.search_articles') }}"
                                    class="w-full border border-gray-300 rounded-lg pl-4 pr-10 py-3 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all">
                                <button class="absolute right-3 top-3 text-gray-400 hover:text-blue-600">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif">{{ __('messages.categories') }}</h3>
                        <div class="space-y-2">
                            @foreach ($categories as $category)
                                <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                    class="flex items-center justify-between group p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <span
                                        class="text-gray-600 group-hover:text-blue-600 font-medium {{ request('category') == $category->slug ? 'text-blue-600' : '' }}">{{ $category->name }}</span>
                                    <span
                                        class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">{{ $category->posts_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 font-serif">{{ __('messages.recent_stories') }}
                        </h3>
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
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
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
