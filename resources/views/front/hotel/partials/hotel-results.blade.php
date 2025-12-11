<div class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-1">
        Book a Hotel at <span class="text-primary">ACP Tours</span>
    </h1>
    <p class="text-sm text-gray-3 mt-2">Always available. Get discount here</p>
</div>

@if ($hotels->count() > 0)
    <div class="grid grid-cols-1 gap-6">
        @foreach ($hotels as $hotel)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="flex flex-col sm:flex-row">
                    {{-- Hotel Image --}}
                    <div class="sm:w-1/3 h-64 sm:h-auto">
                        <img src="{{ Storage::url($hotel->featured_photo) }}" alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- Hotel Info --}}
                    <div class="sm:w-2/3 p-6 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-1 hover:text-primary">
                                        <a href="{{ route('hotel.show', $hotel->slug) }}">
                                            {{ $hotel->name }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center gap-x-2 mt-1">
                                        <i class="fa-solid fa-location-dot text-primary text-sm"></i>
                                        <p class="text-sm text-gray-3">{{ $hotel->city }},
                                            {{ $hotel->country }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-x-1">
                                    @for ($i = 0; $i < $hotel->star_rating; $i++)
                                        <i class="fa-solid fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                </div>
                            </div>

                            <p class="text-sm text-gray-3 mb-4 line-clamp-2">
                                {{ Str::limit($hotel->description, 150) }}
                            </p>

                            {{-- Amenities --}}
                            @if ($hotel->amenities->count() > 0)
                                <div class="flex flex-wrap gap-3 mb-4">
                                    @foreach ($hotel->amenities->take(4) as $amenity)
                                        <span
                                            class="inline-flex items-center gap-x-1 text-xs text-gray-3 bg-[#EBF1FE] px-3 py-1 rounded-full">
                                            <i class="{{ $amenity->icon_class ?? 'fa-solid fa-check' }}"></i>
                                            {{ $amenity->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Price and CTA --}}
                        <div class="flex items-end justify-between mt-4">
                            <div>
                                <p class="text-xs text-gray-3">Starting from</p>
                                <p class="text-2xl font-bold text-primary">
                                    Rp {{ number_format($hotel->min_price, 0, ',', '.') }}
                                    <span class="text-sm font-normal text-gray-3">/night</span>
                                </p>
                            </div>
                            <a href="{{ route('hotel.show', $hotel->slug) }}"
                                class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-400 transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $hotels->links() }}
    </div>
@else
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <i class="fa-solid fa-hotel text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-2 mb-2">No Hotels Found</h3>
        <p class="text-gray-3 mb-4">Try adjusting your filters to find more hotels</p>
        <a href="{{ route('hotel.index') }}"
            class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-400 transition">
            Reset Filters
        </a>
    </div>
@endif
