@extends('front.layout.app')

@section('title', 'My Wishlist - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Wishlist</h1>
                <p class="text-gray-600">Your saved destinations and hotels</p>
            </div>

            @if ($wishlists->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($wishlists as $wishlist)
                        @php
                            $item = $wishlist->wishlistable;
                            $isDestination = $wishlist->wishlistable_type === 'App\Models\Destination';
                        @endphp

                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ asset($isDestination ? $item->featured_photo : $item->photos->first()->path ?? 'images/default-hotel.jpg') }}"
                                    alt="{{ $item->title ?? $item->name }}" class="w-full h-48 object-cover">

                                <div class="absolute top-2 right-2">
                                    <x-wishlist-button :type="$isDestination ? 'destination' : 'hotel'" :id="$item->id" :inWishlist="true" />
                                </div>

                                <div class="absolute bottom-2 left-2">
                                    <span class="bg-white px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $isDestination ? 'Destination' : 'Hotel' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->title ?? $item->name }}</h3>

                                @if ($isDestination)
                                    <div class="flex items-center text-gray-600 text-sm mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>{{ $item->city }}, {{ $item->country }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-blue-600 font-bold text-lg">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </div>
                                        <a href="{{ route('destination_detail', $item->slug) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                            View Details
                                        </a>
                                    </div>
                                @else
                                    <div class="flex items-center text-gray-600 text-sm mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>{{ $item->address }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-yellow-500">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $item->rating ? 's' : 'r' }} fa-star"></i>
                                            @endfor
                                        </div>
                                        <a href="{{ route('hotel.show', $item->slug) }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                            View Details
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Your wishlist is empty</h3>
                    <p class="text-gray-600 mb-6">Start exploring and save your favorite destinations and hotels!</p>
                    <a href="{{ route('destination') }}"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-block">
                        <i class="fas fa-search mr-2"></i>Explore Destinations
                    </a>
                </div>
            @endif
        </div>
    </div>

    @include('front.layout.footer')
@endsection
