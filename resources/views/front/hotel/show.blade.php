@extends('front.layout.app')

@section('title', $hotel->name . ' - ACP Tours & Travel')

@section('content')
    @include('front.layout.nav')

    <!-- Breadcrumb -->
    <div class="bg-gray-50 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600 flex items-center">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
                <i class="fas fa-chevron-right mx-3 text-xs"></i>
                <a href="{{ route('hotel.index') }}" class="hover:text-blue-600">Hotel</a>
                <i class="fas fa-chevron-right mx-3 text-xs"></i>
                <a href="{{ route('hotel.index', ['search' => $hotel->city]) }}"
                    class="hover:text-blue-600">{{ $hotel->city }}</a>
                <i class="fas fa-chevron-right mx-3 text-xs"></i>
                <span class="text-blue-600 font-semibold">{{ $hotel->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Hotel Gallery -->
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 sm:gap-3 lg:gap-4">
            {{-- Main Image --}}
            <div class="relative md:col-span-2">
                @if ($hotel->featured_photo)
                    <img src="{{ Storage::url($hotel->featured_photo) }}" alt="{{ $hotel->name }}"
                        class="w-full h-[250px] sm:h-[300px] md:h-[350px] lg:h-[400px] object-cover rounded-lg">
                @endif
            </div>

            {{-- Gallery Grid --}}
            @php
                $allPhotos = collect([$hotel->featured_photo])->merge($hotel->photos->pluck('photo_path'));
            @endphp
            <div id="gallery" class="grid grid-cols-2 md:grid-cols-1 gap-2 sm:gap-3 lg:gap-4"
                data-photos='@json($allPhotos)'>
                @foreach ($hotel->photos->take(2) as $index => $photo)
                    @if ($index < 1)
                        <div class="relative">
                            <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $hotel->name }}"
                                class="w-full h-32 sm:h-40 md:h-48 object-cover rounded-lg" />
                        </div>
                    @elseif ($index === 1)
                        <div class="relative cursor-pointer" id="openGalleryModal">
                            <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $hotel->name }}"
                                class="w-full h-32 sm:h-40 md:h-48 object-cover rounded-lg brightness-50" />
                            <div class="absolute inset-0 flex items-center justify-center bg-opacity-50 rounded-lg">
                                <span class="text-white text-sm sm:text-base lg:text-xl font-semibold">See All Photos</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Modal untuk Galeri -->
            <div id="galleryModal"
                class="hidden fixed inset-0 bg-gray-1 bg-opacity-80 items-center justify-center z-50 transition-all ease-in-out duration-300 p-4">
                <div class="relative w-full max-h-full max-w-xl md:max-w-4xl">
                    <div class="bg-opacity-100">
                        <!-- Tombol Close -->
                        <button id="closeGalleryModal"
                            class="absolute -top-8 sm:-top-10 -right-2 sm:-right-3 text-gray-4 text-xl sm:text-2xl px-2 py-1 rounded-md z-10">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Navigasi Foto -->
                        <div class="relative flex justify-center text-gray-4">
                            <img id="currentPhoto" alt="Current gallery image"
                                class="w-full h-48 sm:h-56 md:h-96 object-cover rounded-md">
                            <button id="prevPhoto"
                                class="absolute top-1/2 -left-6 sm:-left-10 transform -translate-y-1/2 text-2xl sm:text-3xl">
                                <i class="fa-solid fa-circle-chevron-left"></i>
                            </button>
                            <button id="nextPhoto"
                                class="absolute top-1/2 -right-6 sm:-right-10 transform -translate-y-1/2 text-2xl sm:text-3xl">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Details -->
    <div class="container mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Hotel Info -->
            <div class="lg:col-span-2">
                <!-- Tabs -->
                <div class="bg-white rounded-xl shadow-sm mb-6">
                    <div class="flex border-b">
                        <button class="tab-btn px-6 py-4 font-semibold text-blue-600 border-b-2 border-blue-600"
                            data-tab="overview">
                            Overview
                        </button>
                        <button class="tab-btn px-6 py-4 font-semibold text-gray-600 hover:text-blue-600"
                            data-tab="amenities">
                            Amenities
                        </button>
                        <button class="tab-btn px-6 py-4 font-semibold text-gray-600 hover:text-blue-600" data-tab="rooms">
                            Rooms
                        </button>
                        <button class="tab-btn px-6 py-4 font-semibold text-gray-600 hover:text-blue-600"
                            data-tab="location">
                            Location
                        </button>
                        <button class="tab-btn px-6 py-4 font-semibold text-gray-600 hover:text-blue-600" data-tab="rules">
                            Rules
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        <!-- Overview Tab -->
                        <div id="overview-tab" class="tab-content">
                            <h2 class="text-3xl font-bold mb-4">{{ $hotel->name }}</h2>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="flex items-center text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->star_rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600">{{ $hotel->city }}, {{ $hotel->country }}</span>
                            </div>

                            <div class="prose max-w-none">
                                <p class="text-gray-700 leading-relaxed">{{ $hotel->description }}</p>

                                @if ($hotel->description && strlen($hotel->description) > 200)
                                    <button class="text-blue-600 font-semibold mt-4 hover:underline">View More <i
                                            class="fas fa-chevron-down ml-1"></i></button>
                                @endif
                            </div>
                        </div>

                        <!-- Amenities Tab -->
                        <div id="amenities-tab" class="tab-content hidden">
                            <h3 class="text-2xl font-bold mb-6">Amenities</h3>
                            <div class="flex justify-between items-center mb-6">
                                <p class="text-gray-600">Enjoy the best facilities and services during your stay</p>
                                <button class="text-blue-600 font-semibold hover:underline">Show all <i
                                        class="fas fa-arrow-right ml-1"></i></button>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                @forelse($hotel->amenities as $amenity)
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i
                                                class="{{ $amenity->icon_class ?? 'fa-solid fa-check' }} text-blue-600 text-xl"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $amenity->name }}</span>
                                    </div>
                                @empty
                                    <p class="col-span-3 text-gray-500">No amenities listed</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Rooms Tab -->
                        <div id="rooms-tab" class="tab-content hidden">
                            <h3 class="text-2xl font-bold mb-6">Select Your Room</h3>

                            @forelse($hotel->rooms as $room)
                                <div class="border rounded-xl p-6 mb-6 hover:shadow-lg transition">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                        <!-- Room Image -->
                                        <div class="md:col-span-1">
                                            @if ($room->room_photo)
                                                <img src="{{ Storage::url($room->room_photo) }}"
                                                    alt="{{ $room->room_name }}"
                                                    class="w-full h-32 object-cover rounded-lg">
                                            @endif
                                            <div class="flex items-center gap-2 mt-2 text-sm text-gray-600">
                                                @if ($room->smoking_allowed)
                                                    <i class="fas fa-smoking"></i>
                                                    <span>Smoking</span>
                                                @else
                                                    <i class="fas fa-smoking-ban"></i>
                                                    <span>Non-smoking</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                                                @if ($room->has_wifi)
                                                    <i class="fas fa-wifi"></i>
                                                    <span>Free WiFi</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                                                @if ($room->has_air_conditioning)
                                                    <i class="fas fa-snowflake"></i>
                                                    <span>Air conditioning</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Room Details -->
                                        <div class="md:col-span-2">
                                            <h4 class="text-xl font-bold mb-2">{{ $room->room_name }}</h4>
                                            <div class="flex items-center gap-4 mb-3">
                                                <div class="flex items-center gap-1 text-sm text-gray-600">
                                                    <i class="fas fa-bed"></i>
                                                    <span>{{ $room->bed_type }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 text-sm text-gray-600">
                                                    <i class="fas fa-users"></i>
                                                    <span>{{ $room->max_guests }} guests</span>
                                                </div>
                                            </div>

                                            <p class="text-sm text-gray-600 mb-4">{{ $room->room_description }}</p>

                                            <div class="space-y-2 mb-4">
                                                <div class="text-sm">
                                                    <span class="font-semibold text-gray-700">Without Breakfast</span>
                                                    <p class="text-xs text-gray-500">{{ $room->bed_count }}
                                                        {{ $room->bed_type }}</p>
                                                    @if ($room->free_cancellation)
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <i class="fas fa-check text-green-600 text-xs"></i>
                                                            <span class="text-xs text-gray-600">Free cancellation before 24
                                                                hours</span>
                                                        </div>
                                                    @endif
                                                    @if ($room->pay_at_hotel)
                                                        <div class="flex items-center gap-2">
                                                            <i class="fas fa-check text-green-600 text-xs"></i>
                                                            <span class="text-xs text-gray-600">Pay at hotel option
                                                                available</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if ($room->has_breakfast)
                                                    <div class="text-sm pt-2 border-t">
                                                        <span class="font-semibold text-gray-700">Breakfast Included for 2
                                                            pax</span>
                                                        <p class="text-xs text-gray-500">{{ $room->bed_count }}
                                                            {{ $room->bed_type }}</p>
                                                        @if ($room->free_cancellation)
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <i class="fas fa-check text-green-600 text-xs"></i>
                                                                <span class="text-xs text-gray-600">Free cancellation
                                                                    before 24 hours</span>
                                                            </div>
                                                        @endif
                                                        @if ($room->pay_at_hotel)
                                                            <div class="flex items-center gap-2">
                                                                <i class="fas fa-check text-green-600 text-xs"></i>
                                                                <span class="text-xs text-gray-600">Pay at hotel option
                                                                    available</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="md:col-span-1 text-right">
                                            <div class="mb-4">
                                                <div class="flex items-center justify-end gap-2 mb-1">
                                                    <i class="fas fa-user text-sm text-gray-600"></i>
                                                    <i class="fas fa-user text-sm text-gray-600"></i>
                                                </div>
                                                <div class="text-2xl font-bold text-blue-600">Rp
                                                    {{ number_format($room->price_without_breakfast, 0, ',', '.') }}</div>
                                                <p class="text-xs text-gray-500">Per night</p>
                                                <p class="text-xs text-gray-500">Exclude taxes & fees</p>
                                                <button
                                                    class="add-room-btn bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg mt-2 w-full transition"
                                                    data-room-id="{{ $room->id }}"
                                                    data-price="{{ $room->price_without_breakfast }}"
                                                    data-room-name="{{ $room->room_name }}" data-breakfast="without">
                                                    <i class="fas fa-plus mr-1"></i> Add
                                                </button>
                                            </div>

                                            @if ($room->has_breakfast)
                                                <div class="pt-4 border-t">
                                                    <div class="flex items-center justify-end gap-2 mb-1">
                                                        <i class="fas fa-user text-sm text-gray-600"></i>
                                                        <i class="fas fa-user text-sm text-gray-600"></i>
                                                    </div>
                                                    <div class="text-2xl font-bold text-blue-600">Rp
                                                        {{ number_format($room->price_with_breakfast, 0, ',', '.') }}</div>
                                                    <p class="text-xs text-gray-500">Per night</p>
                                                    <p class="text-xs text-gray-500">Exclude taxes & fees</p>
                                                    <button
                                                        class="add-room-btn bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg mt-2 w-full transition"
                                                        data-room-id="{{ $room->id }}"
                                                        data-price="{{ $room->price_with_breakfast }}"
                                                        data-room-name="{{ $room->room_name }}" data-breakfast="with">
                                                        <i class="fas fa-plus mr-1"></i> Add
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No rooms available</p>
                            @endforelse
                        </div>

                        <!-- Location Tab -->
                        <div id="location-tab" class="tab-content hidden">
                            <h3 class="text-2xl font-bold mb-4">Location</h3>
                            <p class="text-gray-600 mb-6">{{ $hotel->address }}</p>

                            <!-- Map -->
                            <div class="bg-gray-200 h-96 rounded-lg mb-6 flex items-center justify-center">
                                @if ($hotel->latitude && $hotel->longitude)
                                    <div id="hotel-map-{{ $hotel->id }}" class="w-full h-full rounded-lg"></div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            if (typeof L !== 'undefined') {
                                                const hotelMap = L.map('hotel-map-{{ $hotel->id }}').setView([{{ $hotel->latitude }},
                                                    {{ $hotel->longitude }}
                                                ], 15);

                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '© OpenStreetMap contributors',
                                                    maxZoom: 19
                                                }).addTo(hotelMap);

                                                L.marker([{{ $hotel->latitude }}, {{ $hotel->longitude }}])
                                                    .addTo(hotelMap)
                                                    .bindPopup('<b>{{ $hotel->name }}</b><br>{{ $hotel->address }}')
                                                    .openPopup();
                                            }
                                        });
                                    </script>
                                @else
                                    <div class="text-center text-gray-400">
                                        <i class="fa-solid fa-map-location-dot text-4xl mb-2"></i>
                                        <p>Map location not available</p>
                                    </div>
                                @endif
                            </div>

                            <h4 class="text-xl font-bold mb-4">Nearby Places</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-gray-700"><i class="fas fa-building mr-2 text-gray-400"></i> City
                                        Square</span>
                                    <span class="text-gray-600 font-semibold">0.6 m</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-gray-700"><i class="fas fa-hospital mr-2 text-gray-400"></i> Cheju
                                        Halla General Hospital</span>
                                    <span class="text-gray-600 font-semibold">600 m</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-gray-700"><i class="fas fa-plane mr-2 text-gray-400"></i> Jeju
                                        International Airport</span>
                                    <span class="text-gray-600 font-semibold">3.98 km</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-gray-700"><i class="fas fa-plane mr-2 text-gray-400"></i> Jeju
                                        International Airport</span>
                                    <span class="text-gray-600 font-semibold">3.98 km</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b">
                                    <span class="text-gray-700"><i class="fas fa-plane mr-2 text-gray-400"></i> Jeju
                                        International Airport</span>
                                    <span class="text-gray-600 font-semibold">3.98 km</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rules Tab -->
                        <div id="rules-tab" class="tab-content hidden">
                            <h3 class="text-2xl font-bold mb-6">Hotel Rules</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Check-in / Check-out</h4>
                                    <p class="text-gray-600">Check-in: After 14:00</p>
                                    <p class="text-gray-600">Check-out: Before 12:00</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Cancellation Policy</h4>
                                    <p class="text-gray-600">Free cancellation up to 24 hours before check-in</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Pets</h4>
                                    <p class="text-gray-600">Pets are not allowed</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg mb-2">Payment Methods</h4>
                                    <p class="text-gray-600">Cash, Credit Card, Debit Card</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking Widget -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Starting from</span>
                            <button class="text-blue-600 text-sm hover:underline"><i
                                    class="fas fa-share-alt mr-1"></i></button>
                        </div>
                        <div class="text-3xl font-bold text-blue-600 mb-1">Rp
                            {{ number_format($hotel->min_price, 0, ',', '.') }}</div>
                        <p class="text-sm text-gray-500">Per night</p>
                    </div>

                    <!-- Highlights -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Highlights</h4>
                        <div class="space-y-2">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span class="text-sm text-gray-700">The location of this hotel has a rating score of
                                    96!</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span class="text-sm text-gray-700">This hotel has an wellness rating score of 95</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span class="text-sm text-gray-700">The WiFi service this hotel provides has a rating score
                                    of 87</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <span class="text-sm text-gray-700">The staff's service has an average rating of 91</span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-4">
                            <span class="font-semibold" id="selectedCount">0</span> items selected
                        </p>
                        <div class="text-2xl font-bold mb-4">Rp <span
                                id="totalPrice">{{ number_format($hotel->min_price, 0, ',', '.') }}</span></div>
                        <button
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
                            id="bookNowBtn">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front.layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;

                    // Remove active states
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-blue-600', 'border-b-2',
                            'border-blue-600');
                        btn.classList.add('text-gray-600');
                    });

                    // Add active state to clicked button
                    this.classList.remove('text-gray-600');
                    this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show target tab content
                    document.getElementById(targetTab + '-tab').classList.remove('hidden');
                });
            });

            // Room booking functionality
            let selectedRooms = [];

            const addButtons = document.querySelectorAll('.add-room-btn');
            const selectedCountEl = document.getElementById('selectedCount');
            const totalPriceEl = document.getElementById('totalPrice');
            const bookNowBtn = document.getElementById('bookNowBtn');

            addButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const roomId = this.dataset.roomId;
                    const roomPrice = parseFloat(this.dataset.price);
                    const roomName = this.dataset.roomName;
                    const breakfastType = this.dataset.breakfast;

                    // Check if room already selected
                    const existingIndex = selectedRooms.findIndex(r =>
                        r.id === roomId && r.breakfast === breakfastType
                    );

                    if (existingIndex >= 0) {
                        // Remove from selection
                        selectedRooms.splice(existingIndex, 1);
                        this.innerHTML = '<i class="fas fa-plus mr-1"></i> Add';
                        this.classList.remove('bg-red-600', 'hover:bg-red-700');
                        this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    } else {
                        // Add to selection
                        selectedRooms.push({
                            id: roomId,
                            name: roomName,
                            price: roomPrice,
                            breakfast: breakfastType,
                            quantity: 1
                        });
                        this.innerHTML = '<i class="fas fa-check mr-1"></i> Added';
                        this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        this.classList.add('bg-red-600', 'hover:bg-red-700');
                    }

                    updateBookingSummary();
                });
            });

            function updateBookingSummary() {
                // Update count
                selectedCountEl.textContent = selectedRooms.length;

                // Calculate total
                const total = selectedRooms.reduce((sum, room) => sum + room.price, 0);
                totalPriceEl.textContent = new Intl.NumberFormat('id-ID').format(total);

                // Enable/disable book button
                if (selectedRooms.length > 0) {
                    bookNowBtn.disabled = false;
                    bookNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    bookNowBtn.disabled = true;
                    bookNowBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // Initialize book button state
            updateBookingSummary();

            // Book now button handler
            bookNowBtn.addEventListener('click', function() {
                if (selectedRooms.length === 0) {
                    alert('Please select at least one room');
                    return;
                }

                // Check if user is logged in
                const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

                if (!isLoggedIn) {
                    document.getElementById('permissionModal').classList.remove('hidden');
                    return;
                }

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                this.disabled = true;

                fetch("{{ route('hotel.booking.store', $hotel->slug) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            rooms: selectedRooms.map(room => ({
                                id: room.id,
                                quantity: room.quantity,
                                price: room.price
                            })),
                            check_in: "{{ $checkIn ?? now()->toDateString() }}",
                            check_out: "{{ $checkOut ?? now()->addDay()->toDateString() }}"
                        })
                    })
                    .then(response => {
                        return response.text().then(text => {
                            // Check if response is valid JSON
                            try {
                                const data = JSON.parse(text);
                                if (!response.ok) {
                                    throw new Error(data.message ||
                                        'Network response was not ok');
                                }
                                return data;
                            } catch (e) {
                                // If parsing fails, it's likely HTML (Login page or Error page)
                                if (text.includes('<!DOCTYPE html>') || text.includes(
                                        '<html')) {
                                    // Assuming session expired or middleware redirect
                                    document.getElementById('permissionModal').classList.remove(
                                        'hidden');
                                    throw new Error('Please login to continue');
                                }
                                throw new Error('Server returned invalid response: ' + text
                                    .substring(0, 50) + '...');
                            }
                        });
                    })
                    .then(data => {
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else {
                            // fallback
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Reset button
                        this.innerHTML = originalText;
                        this.disabled = false;
                        if (error.message !== 'Please login to continue') {
                            alert('Failed to process booking. Please try again.');
                        }
                    });
            });

            // Login Redirect Logic
            document.getElementById('loginRedirectBtn').addEventListener('click', function() {
                const isMobile = window.innerWidth <= 768; // Standard mobile breakpoint
                const loginRoute = isMobile ? "{{ route('user.login') }}" :
                    "{{ route('user.login_register') }}";
                window.location.href = loginRoute;
            });

            document.getElementById('closePermissionModal').addEventListener('click', function() {
                document.getElementById('permissionModal').classList.add('hidden');
            });
        });
    </script>

    <!-- Permission Modal -->
    <div id="permissionModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-sm overflow-hidden text-center p-6">
            <div class="mb-4">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-2xl text-red-500"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Login Required</h3>
                <p class="text-gray-500 text-sm">Please login to proceed with your booking.</p>
            </div>
            <div class="flex flex-col gap-3">
                <button id="loginRedirectBtn"
                    class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-600 transition-colors">
                    Login Now
                </button>
                <button id="closePermissionModal"
                    class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endsection
