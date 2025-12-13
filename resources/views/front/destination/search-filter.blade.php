@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mobile Filter Toggle -->
            <div class="md:hidden mb-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">{{ __('messages.search_results') }}</h1>
                <button id="mobile-filter-toggle"
                    class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm text-sm font-medium text-gray-700 border border-gray-200">
                    <i class="fa-solid fa-sliders"></i> {{ __('messages.filters') }}
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-8">

                <!-- Sidebar Filters (Desktop Sticky / Mobile Drawer) -->
                <aside id="filter-sidebar"
                    class="fixed inset-0 z-50 bg-white transform translate-x-full transition-transform duration-300 md:translate-x-0 md:sticky md:top-24 md:block md:w-1/4 md:shadow-none shadow-xl overflow-y-auto md:overflow-visible md:h-[calc(100vh-8rem)]">
                    <div class="h-full md:h-auto p-0 md:p-0">

                        <!-- Mobile Header -->
                        <div class="md:hidden p-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                            <h2 class="font-bold text-lg">{{ __('messages.filters') }}</h2>
                            <button id="close-filter-sidebar" class="text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>

                        <!-- Filter Form -->
                        <div
                            class="p-5 md:p-0 md:bg-white md:rounded-xl md:border md:border-gray-100 md:shadow-sm space-y-6">

                            <!-- Search -->
                            <div class="md:p-4 md:border-b md:border-gray-50">
                                <label
                                    class="block text-sm font-bold text-gray-800 mb-2">{{ __('messages.search') }}</label>
                                <div class="relative">
                                    <input type="text" id="filter-q" name="q" value="{{ request('q') }}"
                                        placeholder="{{ __('messages.search_placeholder') }}"
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm">
                                    <i class="fa-solid fa-search absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="md:px-4">
                                <label
                                    class="block text-sm font-bold text-gray-800 mb-2">{{ __('messages.location') }}</label>
                                <select id="filter-location" name="location"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm appearance-none cursor-pointer">
                                    <option value="">{{ __('messages.all_locations') }}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city }}"
                                            {{ request('location') == $city ? 'selected' : '' }}>{{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div class="md:px-4">
                                <label class="block text-sm font-bold text-gray-800 mb-2">{{ __('messages.date') }}</label>
                                <input type="date" id="filter-date" name="date" value="{{ request('date') }}"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors text-sm cursor-pointer">
                            </div>

                            <hr class="border-gray-100 mx-4">

                            <!-- Price Range -->
                            <div class="md:px-4">
                                <label
                                    class="block text-sm font-bold text-gray-800 mb-2">{{ __('messages.price_range') }}</label>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="relative w-1/2">
                                        <span class="absolute left-3 top-2.5 text-gray-400 text-xs">Rp</span>
                                        <input type="number" id="filter-min-price" name="min_price"
                                            placeholder="{{ __('messages.price_min') }}"
                                            value="{{ request('min_price') }}"
                                            class="w-full pl-8 pr-2 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-0">
                                    </div>
                                    <span class="text-gray-400">-</span>
                                    <div class="relative w-1/2">
                                        <span class="absolute left-3 top-2.5 text-gray-400 text-xs">Rp</span>
                                        <input type="number" id="filter-max-price" name="max_price"
                                            placeholder="{{ __('messages.price_max') }}"
                                            value="{{ request('max_price') }}"
                                            class="w-full pl-8 pr-2 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-primary focus:ring-0">
                                    </div>
                                </div>
                                <!-- Simple presets -->
                                <div class="flex flex-wrap gap-2">
                                    <button type="button"
                                        class="price-preset px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200 text-gray-600 transition-colors"
                                        data-max="1000000">
                                        < 1M</button>
                                            <button type="button"
                                                class="price-preset px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200 text-gray-600 transition-colors"
                                                data-max="5000000">
                                                < 5M</button>
                                                    <button type="button"
                                                        class="price-preset px-3 py-1 text-xs bg-gray-100 rounded-full hover:bg-gray-200 text-gray-600 transition-colors"
                                                        data-max="10000000">
                                                        < 10M</button>
                                </div>
                            </div>

                            <hr class="border-gray-100 mx-4">

                            <!-- Duration -->
                            <div class="md:px-4">
                                <label class="block text-sm font-bold text-gray-800 mb-3">Duration</label>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="radio" name="duration" value="1-3" class="peer sr-only"
                                                {{ request('duration') == '1-3' ? 'checked' : '' }}>
                                            <div
                                                class="w-5 h-5 border border-gray-300 rounded-full peer-checked:border-primary peer-checked:border-[5px] transition-all bg-white">
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600 group-hover:text-gray-800 select-none">Short (1-3
                                            Days)</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="radio" name="duration" value="4-7" class="peer sr-only"
                                                {{ request('duration') == '4-7' ? 'checked' : '' }}>
                                            <div
                                                class="w-5 h-5 border border-gray-300 rounded-full peer-checked:border-primary peer-checked:border-[5px] transition-all bg-white">
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600 group-hover:text-gray-800 select-none">Medium
                                            (4-7
                                            Days)</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="radio" name="duration" value="8+" class="peer sr-only"
                                                {{ request('duration') == '8+' ? 'checked' : '' }}>
                                            <div
                                                class="w-5 h-5 border border-gray-300 rounded-full peer-checked:border-primary peer-checked:border-[5px] transition-all bg-white">
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-600 group-hover:text-gray-800 select-none">Long (8+
                                            Days)</span>
                                    </label>
                                </div>
                            </div>

                            <hr class="border-gray-100 mx-4">

                            <!-- Trip Type -->
                            <div class="md:px-4">
                                <label class="block text-sm font-bold text-gray-800 mb-3">Trip Type</label>
                                <div class="space-y-3">
                                    @foreach (['Open Trip', 'Private Trip', 'Package'] as $type)
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" name="trip_type[]" value="{{ $type }}"
                                                class="w-5 h-5 border-gray-300 rounded text-primary focus:ring-primary/20 transition-all checked:bg-primary"
                                                {{ in_array($type, (array) request('trip_type', [])) ? 'checked' : '' }}>
                                            <span
                                                class="text-sm text-gray-600 group-hover:text-gray-800 select-none">{{ $type }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-4 pt-2">
                                <button id="reset-filters"
                                    class="w-full py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    Reset Filters
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- Mobile Backdrop -->
                    <div id="filter-backdrop" class="fixed inset-0 bg-black/50 z-[-1] hidden md:hidden"></div>
                </aside>

                <!-- Results Grid -->
                <main class="flex-1 w-full">
                    <!-- Top Bar -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                        <p class="text-sm text-gray-500">
                            Showing <span class="font-bold text-gray-900"
                                id="result-count">{{ $results->count() }}</span> packages
                        </p>
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-500 font-medium">Sort by:</label>
                            <select id="sort-select"
                                class="text-sm border-none bg-gray-50 rounded-lg focus:ring-0 cursor-pointer font-medium text-gray-700 py-1.5 pl-3 pr-8">
                                <option value="">Newest</option>
                                <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Most
                                    Popular</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price:
                                    Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price:
                                    High to Low</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid -->
                    <div id="search-results-grid">
                        @include('front.partials.search-result', ['results' => $results])
                    </div>

                    <!-- Loading State (Hidden by default) -->
                    <div id="loading-state" class="hidden py-12 flex justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                    </div>

                </main>
            </div>
        </div>
    </section>

    <!-- Skeleton Loader Template -->
    <template id="skeleton-loader">
        <div class="animate-pulse flex flex-col gap-4">
            @for ($i = 0; $i < 4; $i++)
                <div
                    class="flex flex-row md:justify-between gap-2 md:gap-6 p-3 md:p-5 bg-white border border-gray-100 rounded-lg">
                    <div class="w-32 md:w-80 aspect-video md:aspect-auto bg-gray-200 rounded-md"></div>
                    <div class="w-full md:w-2/3 flex flex-col gap-4">
                        <div class="flex justify-between items-start">
                            <div class="h-6 bg-gray-200 rounded w-1/2"></div>
                            <div class="h-6 bg-gray-200 rounded w-20"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-3 bg-gray-200 rounded w-full"></div>
                            <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                        </div>
                        <div class="mt-auto flex justify-between items-center">
                            <div class="h-8 bg-gray-200 rounded w-24"></div>
                            <div class="h-10 bg-gray-200 rounded w-32"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </template>

    @include('front.layout.footer')

    <!-- Pass initial data to JS if needed -->
    <script>
        window.searchConfig = {
            url: "{{ route('search_result') }}"
        };
    </script>
@endsection
