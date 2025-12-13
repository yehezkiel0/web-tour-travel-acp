<div class="hotel-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 h-full"
    data-city="{{ $hotel->city }}">
    <div class="relative">
        @if ($hotel->featured_photo)
            <img src="{{ Storage::url($hotel->featured_photo) }}" class="w-full h-48 object-cover"
                alt="{{ $hotel->name }}">
        @endif
    </div>
    <div class="p-4 flex flex-col h-[calc(100%-12rem)]">
        <h5 class="font-bold text-lg mb-2 text-gray-800 line-clamp-1">{{ $hotel->name }}</h5>
        <p class="text-gray-600 text-sm mb-2 flex items-center">
            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
            <span class="truncate">{{ $hotel->city }}, {{ $hotel->country }}</span>
        </p>
        <div class="flex items-center mb-3">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $hotel->star_rating)
                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                @else
                    <i class="far fa-star text-yellow-400 text-sm"></i>
                @endif
            @endfor
            <span class="text-gray-500 text-xs ml-2">({{ $hotel->star_rating }}.0)</span>
        </div>
        <div class="mt-auto">
            <div class="flex justify-between items-end mb-3">
                <div>
                    <span class="text-blue-600 font-bold text-xl">Rp
                        {{ number_format($hotel->min_price, 0, ',', '.') }}</span>
                    <p class="text-gray-500 text-xs">per malam</p>

                    @if (isset($nights) && $nights > 0)
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <p class="text-sm font-semibold text-gray-700">Total {{ $nights }}
                                malam:</p>
                            <p class="text-lg font-bold text-green-600">Rp
                                {{ number_format($hotel->min_price * $nights, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <a href="{{ route('hotel.show', $hotel->slug) }}"
                class="block w-full text-center bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold py-2 rounded-lg transition">
                View Details
            </a>
        </div>
    </div>
</div>
