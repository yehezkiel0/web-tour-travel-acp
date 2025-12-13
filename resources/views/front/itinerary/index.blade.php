@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">My Itineraries</h1>
                <a href="{{ route('itineraries.create') }}"
                    class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-600 transition duration-300">
                    <i class="fa-solid fa-plus mr-2"></i> Create New
                </a>
            </div>

            @if ($itineraries->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($itineraries as $itinerary)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $itinerary->name }}</h3>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                        {{ $itinerary->items->count() }} Items
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $itinerary->description ?? 'No description' }}</p>

                                <div class="flex items-center text-gray-500 text-sm mb-4 gap-4">
                                    <span><i
                                            class="fa-regular fa-calendar mr-2"></i>{{ $itinerary->start_date ? $itinerary->start_date->format('M d') : 'TBD' }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                    <span>{{ $itinerary->end_date ? $itinerary->end_date->format('M d, Y') : 'TBD' }}</span>
                                </div>

                                <div class="border-t pt-4 flex justify-between items-center">
                                    <div class="flex gap-2">
                                        <a href="{{ route('itineraries.show', $itinerary->id) }}"
                                            class="text-primary hover:text-primary-700 font-medium text-sm">View Details</a>
                                    </div>
                                    <div class="flex gap-2">
                                        <form action="{{ route('itineraries.destroy', $itinerary->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-xl shadow-sm">
                    <div class="mb-4">
                        <i class="fa-solid fa-map-location-dot text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 mb-2">No Itineraries Yet</h3>
                    <p class="text-gray-500 mb-6">Start planning your dream trip today!</p>
                    <a href="{{ route('itineraries.create') }}" class="text-primary hover:underline">Create your first
                        itinerary</a>
                </div>
            @endif
        </div>
    </section>

    @include('front.layout.footer')
@endsection
