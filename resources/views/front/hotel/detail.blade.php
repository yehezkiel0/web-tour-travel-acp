@extends('front.layout.app')

@section('title', $hotel->name . ' - ACP Tours & Travel')

@section('content')
    @include('front.layout.nav')

    <section class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-8">
            {{-- Breadcrumb --}}
            <header class="flex-col mb-4 sm:mb-6 lg:mb-7 space-y-2 sm:space-y-4" aria-label="Breadcrumb">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center text-xs sm:text-sm font-medium text-gray-3 hover:text-primary">
                                <i class="fa-solid fa-house me-2.5"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fa-solid fa-chevron-right text-gray-3 text-xs"></i>
                                <a href="{{ route('hotel.index') }}"
                                    class="ms-1 text-xs sm:text-sm font-medium text-gray-3 hover:text-primary md:ms-2">Hotel</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fa-solid fa-chevron-right text-gray-3 text-xs"></i>
                                <span
                                    class="ms-1 text-xs sm:text-sm font-medium text-gray-2 md:ms-2">{{ $hotel->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </header>

            {{-- Hotel Header --}}
            <div class="mb-6">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <h1 class="text-2xl md:text-4xl font-bold text-gray-1">{{ $hotel->name }}</h1>
                        <div class="flex items-center gap-x-3 mt-2">
                            <div class="flex items-center gap-x-1">
                                @for ($i = 0; $i < $hotel->star_rating; $i++)
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                @endfor
                            </div>
                            <div class="flex items-center gap-x-2">
                                <i class="fa-solid fa-location-dot text-primary"></i>
                                <p class="text-sm text-gray-3">{{ $hotel->address }}, {{ $hotel->city }}</p>
                            </div>
                        </div>
                    </div>
                    <button onclick="window.history.back()" class="text-primary hover:text-primary-400 transition">
                        <i class="fa-solid fa-arrow-left text-xl"></i>
                    </button>
                </div>
            </div>

            {{-- Hotel Photos --}}
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 rounded-xl overflow-hidden">
                    <div class="md:col-span-2 md:row-span-2">
                        <img src="{{ Storage::url($hotel->featured_photo) }}" alt="{{ $hotel->name }}"
                            class="w-full h-full object-cover">
                    </div>
                    @foreach ($hotel->photos->take(4) as $photo)
                        <div class="h-48 md:h-auto">
                            <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $photo->caption }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
                @if ($hotel->photos->count() > 4)
                    <button class="mt-4 text-primary hover:text-primary-400 text-sm font-medium">
                        <i class="fa-solid fa-images mr-2"></i>
                        See All Photos
                    </button>
                @endif
            </div>

            {{-- Booking Form --}}
            <div class="bg-[#EBF1FE] rounded-xl p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-1 mb-4">Book a Hotel at ACP Tours</h2>
                <p class="text-sm text-gray-3 mb-6">Always available. Get discount here</p>

                <form action="{{ route('hotel.show', $hotel->slug) }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-2 mb-2">
                            <i class="fa-solid fa-location-dot mr-1"></i>
                            Enter a destination or hotels
                        </label>
                        <input type="text" value="{{ $hotel->name }}" readonly
                            class="w-full px-4 py-3 bg-white rounded-lg text-sm focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-2 mb-2">
                            <i class="fa-solid fa-calendar mr-1"></i>
                            Start date to find date
                        </label>
                        <input type="date" name="check_in" value="{{ $checkIn ?? date('Y-m-d') }}"
                            min="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-3 bg-white rounded-lg text-sm focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-2 mb-2">
                            <i class="fa-solid fa-calendar mr-1"></i>
                            Check out date
                        </label>
                        <input type="date" name="check_out"
                            value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                            class="w-full px-4 py-3 bg-white rounded-lg text-sm focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-2 mb-2">
                            <i class="fa-solid fa-user mr-1"></i>
                            Adults or Children | Room
                        </label>
                        <div class="flex gap-2">
                            <input type="number" name="guests" value="{{ $guests ?? 2 }}" min="1"
                                class="w-1/2 px-4 py-3 bg-white rounded-lg text-sm focus:outline-none">
                            <input type="number" name="rooms" value="{{ $rooms ?? 1 }}" min="1"
                                class="w-1/2 px-4 py-3 bg-white rounded-lg text-sm focus:outline-none">
                        </div>
                    </div>

                    <div class="md:col-span-4">
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-400 transition">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i>
                            Search Hotel
                        </button>
                    </div>
                </form>
            </div>

            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column --}}
                <div class="lg:col-span-2">
                    {{-- Overview --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-1 mb-4">Overview</h2>
                        <p class="text-sm text-gray-3 leading-relaxed">{{ $hotel->description }}</p>
                    </div>

                    {{-- Amenities --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-1 mb-4">Amenities</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($hotel->amenities as $amenity)
                                <div class="flex items-center gap-x-3 text-gray-2">
                                    <i class="fa-solid {{ $amenity->amenity_icon ?? 'fa-check' }} text-primary"></i>
                                    <span class="text-sm">{{ $amenity->amenity_name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Select Your Room --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-1 mb-4">Select Your Room</h2>

                        @forelse ($hotel->rooms as $room)
                            <div class="bg-[#EBF1FE] rounded-xl p-6 mb-4">
                                <div class="flex flex-col md:flex-row gap-6">
                                    {{-- Room Image --}}
                                    @if ($room->room_photo)
                                        <div class="md:w-1/3">
                                            <img src="{{ Storage::url($room->room_photo) }}"
                                                alt="{{ $room->room_name }}" class="w-full h-48 object-cover rounded-lg">
                                        </div>
                                    @endif

                                    {{-- Room Details --}}
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-1">{{ $room->room_name }}</h3>
                                                @if ($room->smoking_allowed)
                                                    <span
                                                        class="inline-flex items-center gap-x-1 text-xs bg-white px-2 py-1 rounded-full mt-1">
                                                        <i class="fa-solid fa-smoking"></i>
                                                        Smoking
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Room Options --}}
                                        <div class="space-y-4">
                                            {{-- Without Breakfast --}}
                                            <div class="bg-white rounded-lg p-4">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <p class="font-semibold text-gray-2 mb-2">
                                                            Room Option(s)
                                                            <span class="inline-flex items-center ml-2">
                                                                <i class="fa-solid fa-user text-xs text-gray-3"></i>
                                                                <span class="text-xs ml-1">{{ $room->max_guests }}</span>
                                                            </span>
                                                        </p>
                                                        <p class="text-sm text-gray-3 mb-3">
                                                            <i class="fa-solid fa-bed text-primary mr-1"></i>
                                                            {{ $room->bed_count }} {{ $room->bed_type }} bed
                                                        </p>
                                                        <div class="space-y-1 text-xs text-gray-3">
                                                            <p class="text-red-500">
                                                                <i class="fa-solid fa-xmark mr-1"></i>
                                                                Without Breakfast
                                                            </p>
                                                            @if ($room->free_cancellation)
                                                                <p class="text-green-600">
                                                                    <i class="fa-solid fa-check mr-1"></i>
                                                                    Free cancellation before 24 Jan 2025
                                                                </p>
                                                            @endif
                                                            @if ($room->pay_at_hotel)
                                                                <p class="text-green-600">
                                                                    <i class="fa-solid fa-check mr-1"></i>
                                                                    Pay booking until 28 ANS per stay
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="text-right ml-4">
                                                        <p class="text-sm text-gray-3 line-through mb-1">
                                                            Rp
                                                            {{ number_format($room->price_without_breakfast * 1.2, 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-xl font-bold text-primary mb-2">
                                                            Rp
                                                            {{ number_format($room->price_without_breakfast, 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-xs text-gray-3 mb-3">
                                                            Exclude taxes & fees
                                                        </p>
                                                        <form action="{{ route('hotel.booking', $hotel->slug) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="check_in"
                                                                value="{{ $checkIn ?? date('Y-m-d') }}">
                                                            <input type="hidden" name="check_out"
                                                                value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}">
                                                            <input type="hidden" name="guests"
                                                                value="{{ $guests ?? 2 }}">
                                                            <input type="hidden" name="rooms"
                                                                value="{{ $rooms ?? 1 }}">
                                                            <input type="hidden" name="room_id"
                                                                value="{{ $room->id }}">
                                                            <button type="submit"
                                                                class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-primary-400 transition">
                                                                Book Now
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- With Breakfast --}}
                                            @if ($room->has_breakfast)
                                                <div class="bg-white rounded-lg p-4">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <p class="font-semibold text-gray-2 mb-2">
                                                                Breakfast Included for 2 pax
                                                                <span class="inline-flex items-center ml-2">
                                                                    <i class="fa-solid fa-user text-xs text-gray-3"></i>
                                                                    <span
                                                                        class="text-xs ml-1">{{ $room->max_guests }}</span>
                                                                </span>
                                                            </p>
                                                            <p class="text-sm text-gray-3 mb-3">
                                                                <i class="fa-solid fa-bed text-primary mr-1"></i>
                                                                {{ $room->bed_count }} {{ $room->bed_type }} bed
                                                            </p>
                                                            <div class="space-y-1 text-xs text-gray-3">
                                                                <p class="text-green-600">
                                                                    <i class="fa-solid fa-check mr-1"></i>
                                                                    Breakfast Included for 2 pax
                                                                </p>
                                                                @if ($room->free_cancellation)
                                                                    <p class="text-green-600">
                                                                        <i class="fa-solid fa-check mr-1"></i>
                                                                        Free cancellation before 24 Jan 2025
                                                                    </p>
                                                                @endif
                                                                @if ($room->pay_at_hotel)
                                                                    <p class="text-green-600">
                                                                        <i class="fa-solid fa-check mr-1"></i>
                                                                        Pay booking until 28 ANS per stay
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="text-right ml-4">
                                                            <p class="text-sm text-gray-3 line-through mb-1">
                                                                Rp
                                                                {{ number_format($room->price_with_breakfast * 1.2, 0, ',', '.') }}
                                                            </p>
                                                            <p class="text-xl font-bold text-primary mb-2">
                                                                Rp
                                                                {{ number_format($room->price_with_breakfast, 0, ',', '.') }}
                                                            </p>
                                                            <p class="text-xs text-gray-3 mb-3">
                                                                Exclude taxes & fees
                                                            </p>
                                                            <form action="{{ route('hotel.booking', $hotel->slug) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="check_in"
                                                                    value="{{ $checkIn ?? date('Y-m-d') }}">
                                                                <input type="hidden" name="check_out"
                                                                    value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}">
                                                                <input type="hidden" name="guests"
                                                                    value="{{ $guests ?? 2 }}">
                                                                <input type="hidden" name="rooms"
                                                                    value="{{ $rooms ?? 1 }}">
                                                                <input type="hidden" name="room_id"
                                                                    value="{{ $room->id }}">
                                                                <button type="submit"
                                                                    class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-primary-400 transition">
                                                                    Book Now
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-[#EBF1FE] rounded-xl p-12 text-center">
                                <i class="fa-solid fa-bed text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-3">No rooms available at this time</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Location --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-1 mb-4">Location</h2>
                        <p class="text-sm text-gray-3 mb-4">
                            <i class="fa-solid fa-location-dot text-primary mr-2"></i>
                            {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}
                        </p>
                        @if ($hotel->latitude && $hotel->longitude)
                            <div class="w-full h-64 bg-gray-200 rounded-lg">
                                {{-- Google Maps placeholder --}}
                                <iframe
                                    src="https://maps.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&z=15&output=embed"
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    class="rounded-lg">
                                </iframe>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Column - Highlights --}}
                <div class="lg:col-span-1">
                    <div class="bg-white border-2 border-[#E0E0E0] rounded-xl p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-1 mb-4">Highlights</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-x-3">
                                <i class="fa-solid fa-location-dot text-primary text-lg mt-1"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-2">
                                        The location of this hotel has a rating score of
                                        <span class="text-primary">96!</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-x-3">
                                <i class="fa-solid fa-star text-primary text-lg mt-1"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-2">
                                        This hotel has an wellness rating score of
                                        <span class="text-primary">{{ $hotel->star_rating * 20 }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-x-3">
                                <i class="fa-solid fa-wifi text-primary text-lg mt-1"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-2">
                                        The WiFi service this hotel provides has a rating score of
                                        <span class="text-primary">87</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-x-3">
                                <i class="fa-solid fa-users text-primary text-lg mt-1"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-2">
                                        The staff's service has an overage rating of
                                        <span class="text-primary">91</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nearby Places (Optional) --}}
            <div class="mt-12 mb-8">
                <h2 class="text-2xl font-bold text-gray-1 mb-6">Nearby Places</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center justify-between p-4 bg-[#EBF1FE] rounded-lg">
                        <div class="flex items-center gap-x-3">
                            <i class="fa-solid fa-plane text-primary text-xl"></i>
                            <span class="text-sm text-gray-2">Incheon General Hospital</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-1">46 m</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-[#EBF1FE] rounded-lg">
                        <div class="flex items-center gap-x-3">
                            <i class="fa-solid fa-hospital text-primary text-xl"></i>
                            <span class="text-sm text-gray-2">Gimpo General Hospital</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-1">650 m</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-[#EBF1FE] rounded-lg">
                        <div class="flex items-center gap-x-3">
                            <i class="fa-solid fa-plane text-primary text-xl"></i>
                            <span class="text-sm text-gray-2">Incheon International Airport</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-1">3.95 km</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-[#EBF1FE] rounded-lg">
                        <div class="flex items-center gap-x-3">
                            <i class="fa-solid fa-plane text-primary text-xl"></i>
                            <span class="text-sm text-gray-2">Gimpo International Airport</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-1">3.95 km</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')

    @push('scripts')
        <script>
            // Date validation
            const checkInInput = document.querySelector('input[name="check_in"]');
            const checkOutInput = document.querySelector('input[name="check_out"]');

            if (checkInInput && checkOutInput) {
                checkInInput.addEventListener('change', function() {
                    const checkInDate = new Date(this.value);
                    const minCheckOut = new Date(checkInDate);
                    minCheckOut.setDate(minCheckOut.getDate() + 1);

                    checkOutInput.min = minCheckOut.toISOString().split('T')[0];

                    if (new Date(checkOutInput.value) <= checkInDate) {
                        checkOutInput.value = minCheckOut.toISOString().split('T')[0];
                    }
                });
            }
        </script>
    @endpush
@endsection
