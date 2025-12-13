@extends('front.layout.app')

@section('title', 'My Bookings - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 pt-28 pb-16 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">My Bookings</h1>
                    <p class="text-gray-500">View and track all your travel bookings</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="mt-4 md:mt-0 inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Profile
                </a>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="border-b border-gray-200">
                    <nav class="flex" aria-label="Tabs">
                        <button onclick="showTab('destinations')" id="tab-destinations"
                            class="tab-btn active flex-1 py-4 px-6 text-center font-medium text-blue-600 border-b-2 border-blue-600 bg-blue-50">
                            <i class="fa-solid fa-map-location-dot mr-2"></i>
                            Tour Packages
                            <span
                                class="ml-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">{{ $destinationBookings->count() }}</span>
                        </button>
                        <button onclick="showTab('hotels')" id="tab-hotels"
                            class="tab-btn flex-1 py-4 px-6 text-center font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:bg-gray-50">
                            <i class="fa-solid fa-hotel mr-2"></i>
                            Hotels
                            <span
                                class="ml-2 bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $hotelBookings->count() }}</span>
                        </button>
                    </nav>
                </div>

                <!-- Tour Packages Bookings -->
                <div id="content-destinations" class="tab-content p-6">
                    @if ($destinationBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach ($destinationBookings as $booking)
                                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all bg-white">
                                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                                        <!-- Destination Image -->
                                        <div class="w-full lg:w-48 h-32 rounded-xl overflow-hidden flex-shrink-0">
                                            @if ($booking->destination && $booking->destination->featured_photo)
                                                <img src="{{ Storage::url($booking->destination->featured_photo) }}"
                                                    alt="{{ $booking->destination->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                                    <i class="fa-solid fa-plane text-white text-3xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Booking Details -->
                                        <div class="flex-1">
                                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                        {{ $booking->destination->title ?? 'Unknown Destination' }}
                                                    </h3>
                                                    <p class="text-gray-500 text-sm mb-3">
                                                        <i class="fa-solid fa-hashtag mr-1"></i>
                                                        Booking Code: <span
                                                            class="font-mono font-semibold">{{ $booking->code }}</span>
                                                    </p>
                                                </div>
                                                <div>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                                            'confirmed' => 'bg-green-100 text-green-700',
                                                            'cancelled' => 'bg-red-100 text-red-700',
                                                            'completed' => 'bg-blue-100 text-blue-700',
                                                        ];
                                                        $statusColor =
                                                            $statusColors[$booking->status] ??
                                                            'bg-gray-100 text-gray-700';
                                                    @endphp
                                                    <span
                                                        class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Travel Date</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ \Carbon\Carbon::parse($booking->from_date)->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Duration</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ \Carbon\Carbon::parse($booking->from_date)->diffInDays(\Carbon\Carbon::parse($booking->to_date)) }}
                                                        Days
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Travelers</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ $booking->adult_count }}
                                                        Adult{{ $booking->adult_count > 1 ? 's' : '' }}
                                                        @if ($booking->child_count > 0)
                                                            , {{ $booking->child_count }}
                                                            Child{{ $booking->child_count > 1 ? 'ren' : '' }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="bg-blue-50 rounded-lg p-3">
                                                    <p class="text-xs text-blue-600 mb-1">Total Price</p>
                                                    <p class="font-bold text-blue-600 text-sm">
                                                        {{ formatIDR($booking->total_price) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action -->
                                        <div class="flex lg:flex-col gap-2">
                                            <a href="{{ route('profile.booking.detail', $booking->code) }}"
                                                class="flex-1 lg:flex-none bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors text-center">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-ticket text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Tour Bookings Yet</h3>
                            <p class="text-gray-500 mb-6">Start exploring and book your dream destination!</p>
                            <a href="{{ route('destination') }}"
                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors">
                                <i class="fa-solid fa-compass"></i>
                                Explore Destinations
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Hotel Bookings -->
                <div id="content-hotels" class="tab-content hidden p-6">
                    @if ($hotelBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach ($hotelBookings as $booking)
                                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all bg-white">
                                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                                        <!-- Hotel Image -->
                                        <div class="w-full lg:w-48 h-32 rounded-xl overflow-hidden flex-shrink-0">
                                            @if ($booking->hotel && $booking->hotel->featured_photo)
                                                <img src="{{ Storage::url($booking->hotel->featured_photo) }}"
                                                    alt="{{ $booking->hotel->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                                                    <i class="fa-solid fa-hotel text-white text-3xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Booking Details -->
                                        <div class="flex-1">
                                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                        {{ $booking->hotel->name ?? 'Unknown Hotel' }}
                                                    </h3>
                                                    <p class="text-gray-500 text-sm mb-1">
                                                        <i class="fa-solid fa-bed mr-1"></i>
                                                        {{ $booking->room->room_type ?? 'Standard Room' }}
                                                    </p>
                                                    <p class="text-gray-500 text-sm">
                                                        <i class="fa-solid fa-hashtag mr-1"></i>
                                                        Booking Code: <span
                                                            class="font-mono font-semibold">{{ $booking->booking_code }}</span>
                                                    </p>
                                                </div>
                                                <div>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                                            'confirmed' => 'bg-green-100 text-green-700',
                                                            'cancelled' => 'bg-red-100 text-red-700',
                                                            'completed' => 'bg-blue-100 text-blue-700',
                                                        ];
                                                        $statusColor =
                                                            $statusColors[$booking->status] ??
                                                            'bg-gray-100 text-gray-700';
                                                    @endphp
                                                    <span
                                                        class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColor }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Check-in</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Check-out</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-xs text-gray-500 mb-1">Guests</p>
                                                    <p class="font-semibold text-gray-800 text-sm">
                                                        {{ $booking->guests ?? 2 }}
                                                        Guest{{ ($booking->guests ?? 2) > 1 ? 's' : '' }}
                                                    </p>
                                                </div>
                                                <div class="bg-green-50 rounded-lg p-3">
                                                    <p class="text-xs text-green-600 mb-1">Total Price</p>
                                                    <p class="font-bold text-green-600 text-sm">
                                                        {{ formatIDR($booking->total_price) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action -->
                                        <div class="flex lg:flex-col gap-2">
                                            <a href="{{ route('profile.booking.detail', $booking->booking_code) }}"
                                                class="flex-1 lg:flex-none bg-green-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-green-700 transition-colors text-center">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-hotel text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">No Hotel Bookings Yet</h3>
                            <p class="text-gray-500 mb-6">Find the perfect hotel for your next trip!</p>
                            <a href="{{ route('hotel.index') }}"
                                class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-green-700 transition-colors">
                                <i class="fa-solid fa-search"></i>
                                Browse Hotels
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')

    <script>
        function showTab(tab) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            // Reset all tabs
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('text-blue-600', 'border-blue-600', 'bg-blue-50', 'active');
                el.classList.add('text-gray-500', 'border-transparent');
            });

            // Show selected content
            document.getElementById('content-' + tab).classList.remove('hidden');

            // Activate selected tab
            const activeTab = document.getElementById('tab-' + tab);
            activeTab.classList.remove('text-gray-500', 'border-transparent');
            activeTab.classList.add('text-blue-600', 'border-blue-600', 'bg-blue-50', 'active');
        }
    </script>
@endsection
