@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="py-10 bg-gray-50 min-h-screen">
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        @endpush
        <div class="container mx-auto px-4 max-w-7xl">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $itinerary->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $itinerary->description ?? 'Plan your perfect trip' }}</p>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span class="mr-4"><i
                                class="fa-regular fa-calendar mr-2"></i>{{ $itinerary->start_date ? $itinerary->start_date->format('M d') : 'TBD' }}
                            - {{ $itinerary->end_date ? $itinerary->end_date->format('M d, Y') : 'TBD' }}</span>
                        <span><i class="fa-solid fa-earth-asia mr-2"></i>{{ $itinerary->items->count() }}
                            Destinations</span>
                        @if (Auth::id() != $itinerary->user_id)
                            <span class="ml-4 bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">Shared by
                                {{ $itinerary->user->name }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <button id="share-btn" data-share-url="{{ route('itinerary.shared', $itinerary->share_token) }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fa-solid fa-share-nodes mr-2"></i> <span id="share-btn-text">Share</span>
                    </button>
                    @if (Auth::id() == $itinerary->user_id)
                        <a href="{{ route('destination', ['mode' => 'add_itinerary', 'itinerary_id' => $itinerary->id]) }}"
                            class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">
                            <i class="fa-solid fa-plus mr-2"></i> Add Destinations
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Itinerary Timeline --}}
                <div class="lg:col-span-2 space-y-6" id="itinerary-items-container">
                    @forelse($itinerary->items as $item)
                        <div class="bg-white rounded-xl shadow-md p-4 flex gap-4 md:gap-6 relative group"
                            data-id="{{ $item->id }}" data-order="{{ $item->order }}">
                            <div class="w-24 h-24 md:w-32 md:h-32 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($item->destination->featured_photo) }}"
                                    alt="{{ $item->destination->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $item->destination->title }}</h3>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        {{-- <button class="text-gray-400 hover:text-gray-600 handle cursor-grab" title="Drag to reorder"><i class="fa-solid fa-grip-lines"></i></button> --}}
                                        <button class="text-red-400 hover:text-red-600 btn-remove-item"
                                            data-id="{{ $item->id }}" title="Remove"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mb-2"><i class="fa-solid fa-location-dot mr-1"></i>
                                    {{ $item->destination->city }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2 md:line-clamp-3">
                                    {{ Str::limit(strip_tags($item->destination->description), 150) }}</p>
                            </div>
                            <div
                                class="absolute -left-3 top-[-10px] w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold border-2 border-white shadow-sm z-10">
                                {{ $loop->iteration }}
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-sm p-10 text-center">
                            <i class="fa-solid fa-suitcase-rolling text-5xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-700">Your itinerary is empty</h3>
                            <p class="text-gray-500 mb-6">Browse destinations and add them to your plan!</p>
                            <a href="{{ route('destination', ['mode' => 'add_itinerary', 'itinerary_id' => $itinerary->id]) }}"
                                class="text-primary hover:underline">Browse Destinations</a>
                        </div>
                    @endforelse
                </div>

                {{-- Summary / Map Placeholder --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Trip Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Total Destinations</span>
                                <span class="font-semibold">{{ $itinerary->items->count() }} Places</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Total Duration</span>
                                <span
                                    class="font-semibold">{{ $itinerary->start_date && $itinerary->end_date ? $itinerary->start_date->diffInDays($itinerary->end_date) + 1 : 0 }}
                                    Days</span>
                            </div>
                            <hr class="border-gray-100">
                            @php
                                $mapLocations = $itinerary->items->map(function ($item) {
                                    return [
                                        'title' => $item->destination->title,
                                        'lat' => $item->destination->latitude,
                                        'lng' => $item->destination->longitude,
                                        'image' => Storage::url($item->destination->featured_photo),
                                        'order' => $item->order,
                                    ];
                                });
                            @endphp
                            <div id="itinerary-map" style="height: 300px;" class="rounded-lg z-0"
                                data-locations='@json($mapLocations)'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @endpush
@endsection
