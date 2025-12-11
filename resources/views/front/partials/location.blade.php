<div id="location" class="tab-pane md:col-span-2">
    <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6 lg:mb-7">Location</h2>
    <div class="location-map mb-4 sm:mb-6 lg:mb-7 w-full">
        <div class="relative w-full h-0 pb-[56.25%] rounded-lg overflow-hidden bg-gray-100">
            @if ($destination->latitude && $destination->longitude)
                <div id="map-{{ $destination->id }}" class="absolute inset-0 w-full h-full"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof L !== 'undefined') {
                            const map = L.map('map-{{ $destination->id }}').setView([{{ $destination->latitude }},
                                {{ $destination->longitude }}
                            ], 15);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors',
                                maxZoom: 19
                            }).addTo(map);

                            L.marker([{{ $destination->latitude }}, {{ $destination->longitude }}])
                                .addTo(map)
                                .bindPopup(
                                    '<b>{{ $destination->title }}</b><br>{{ $destination->city }}, {{ $destination->country }}')
                                .openPopup();
                        }
                    });
                </script>
            @elseif ($destination->destination_detail && $destination->destination_detail->map_url)
                <div class="absolute inset-0 w-full h-full">
                    {!! $destination->destination_detail->map_url !!}
                </div>
            @else
                <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                    <div class="text-center">
                        <i class="fa-solid fa-map-location-dot text-4xl mb-2"></i>
                        <p class="text-sm">Map not available</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div class="list-features text-gray-2">
            <h4 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fa-solid fa-plane-arrival text-primary"></i>
                <span>Arrival</span>
            </h4>
            <ul class="text-sm sm:text-base space-y-2 ml-0">
                @if ($destination->destination_detail && $destination->destination_detail->arrival)
                    @foreach (preg_split('/[.\n]/', $destination->destination_detail->arrival, -1, PREG_SPLIT_NO_EMPTY) as $item)
                        @php
                            $trimmed = trim($item);
                        @endphp
                        @if ($trimmed)
                            <li class="leading-relaxed flex">
                                <span class="text-primary mr-2 flex-shrink-0">•</span>
                                <span class="flex-1">{{ $trimmed }}</span>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li class="text-gray-400 flex">
                        <span class="text-primary mr-2 flex-shrink-0">•</span>
                        <span class="flex-1">Not specified</span>
                    </li>
                @endif
            </ul>
        </div>
        <div class="list-features text-gray-2">
            <h4 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fa-solid fa-plane-departure text-primary"></i>
                <span>Departure</span>
            </h4>
            <ul class="text-sm sm:text-base space-y-2 ml-0">
                @if ($destination->destination_detail && $destination->destination_detail->departure)
                    @foreach (preg_split('/[.\n]/', $destination->destination_detail->departure, -1, PREG_SPLIT_NO_EMPTY) as $item)
                        @php
                            $trimmed = trim($item);
                        @endphp
                        @if ($trimmed)
                            <li class="leading-relaxed flex">
                                <span class="text-primary mr-2 flex-shrink-0">•</span>
                                <span class="flex-1">{{ $trimmed }}</span>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li class="text-gray-400 flex">
                        <span class="text-primary mr-2 flex-shrink-0">•</span>
                        <span class="flex-1">Not specified</span>
                    </li>
                @endif
            </ul>
        </div>
        <div class="list-features text-gray-2">
            <h4 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center gap-2">
                <i class="fa-solid fa-hotel text-primary"></i>
                <span>Hotels</span>
            </h4>
            <ul class="text-sm sm:text-base space-y-2 ml-0">
                @if ($destination->destination_detail && $destination->destination_detail->nearby_hotel)
                    @foreach (preg_split('/[.,\n]/', $destination->destination_detail->nearby_hotel, -1, PREG_SPLIT_NO_EMPTY) as $item)
                        @php
                            $trimmed = trim($item);
                        @endphp
                        @if ($trimmed)
                            <li class="leading-relaxed flex">
                                <span class="text-primary mr-2 flex-shrink-0">•</span>
                                <span class="flex-1">{{ $trimmed }}</span>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li class="text-gray-400 flex">
                        <span class="text-primary mr-2 flex-shrink-0">•</span>
                        <span class="flex-1">Not specified</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
