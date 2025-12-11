@extends('front.layout.app')

@section('title', 'Hotel Booking Details - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <section class="min-h-screen bg-gradient-to-br from-green-50 via-white to-teal-50 pt-28 pb-16 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <a href="{{ route('profile.bookings') }}"
                        class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium mb-4">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to My Bookings
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Hotel Booking Details</h1>
                </div>
                <div class="mt-4 md:mt-0">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                            'confirmed' => 'bg-green-100 text-green-700 border-green-300',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-300',
                            'completed' => 'bg-blue-100 text-blue-700 border-blue-300',
                        ];
                        $statusColor =
                            $statusColors[$hotelBooking->status] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                    @endphp
                    <span class="px-6 py-3 rounded-full text-lg font-bold border-2 {{ $statusColor }}">
                        {{ ucfirst($hotelBooking->status) }}
                    </span>
                </div>
            </div>

            <!-- Booking Code Card -->
            <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-green-200 text-sm mb-1">Booking Code</p>
                        <p class="text-3xl font-mono font-bold tracking-wider">{{ $hotelBooking->booking_code }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        <p class="text-green-200 text-sm mb-1">Booked on</p>
                        <p class="font-semibold">{{ $hotelBooking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Hotel Info -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="relative h-48">
                            @if ($hotelBooking->hotel && $hotelBooking->hotel->photos->first())
                                <img src="{{ asset('storage/' . $hotelBooking->hotel->photos->first()->photo) }}"
                                    alt="{{ $hotelBooking->hotel->name }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                                    <i class="fa-solid fa-hotel text-white text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-6 right-6 text-white">
                                <div class="flex items-center gap-2 mb-1">
                                    @for ($i = 0; $i < ($hotelBooking->hotel->star_rating ?? 4); $i++)
                                        <i class="fa-solid fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                </div>
                                <h2 class="text-2xl font-bold">{{ $hotelBooking->hotel->name ?? 'Unknown Hotel' }}</h2>
                                <p class="text-white/80">
                                    <i class="fa-solid fa-location-dot mr-1"></i>
                                    {{ $hotelBooking->hotel->address ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days text-green-600"></i>
                                Stay Schedule
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-1">Check-in</p>
                                    <p class="font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($hotelBooking->check_in_date)->format('l') }}</p>
                                    <p class="text-lg font-semibold text-green-600">
                                        {{ \Carbon\Carbon::parse($hotelBooking->check_in_date)->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">From 14:00</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-1">Check-out</p>
                                    <p class="font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($hotelBooking->check_out_date)->format('l') }}</p>
                                    <p class="text-lg font-semibold text-green-600">
                                        {{ \Carbon\Carbon::parse($hotelBooking->check_out_date)->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Before 12:00</p>
                                </div>
                            </div>
                            <div class="mt-4 bg-green-50 rounded-xl p-4 text-center">
                                <p class="text-sm text-green-600 mb-1">Total Nights</p>
                                <p class="text-2xl font-bold text-green-700">
                                    {{ \Carbon\Carbon::parse($hotelBooking->check_in_date)->diffInDays(\Carbon\Carbon::parse($hotelBooking->check_out_date)) }}
                                    Night{{ \Carbon\Carbon::parse($hotelBooking->check_in_date)->diffInDays(\Carbon\Carbon::parse($hotelBooking->check_out_date)) > 1 ? 's' : '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Room Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bed text-green-600"></i>
                            Room Details
                        </h3>
                        <div class="flex flex-col md:flex-row gap-6">
                            @if ($hotelBooking->room && $hotelBooking->room->photo)
                                <div class="w-full md:w-48 h-32 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $hotelBooking->room->photo) }}"
                                        alt="{{ $hotelBooking->room->room_type }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $hotelBooking->room->room_type ?? 'Standard Room' }}</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fa-solid fa-bed text-green-600"></i>
                                        <span>{{ $hotelBooking->room->bed_type ?? 'Double Bed' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fa-solid fa-users text-green-600"></i>
                                        <span>{{ $hotelBooking->room->max_guests ?? 2 }} Guests max</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fa-solid fa-ruler-combined text-green-600"></i>
                                        <span>{{ $hotelBooking->room->room_size ?? 25 }} m²</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class="fa-solid fa-door-open text-green-600"></i>
                                        <span>{{ $hotelBooking->rooms ?? 1 }}
                                            Room{{ ($hotelBooking->rooms ?? 1) > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-user text-green-600"></i>
                            Guest Information
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-user text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Guest Name</p>
                                    <p class="font-semibold text-gray-800">{{ $hotelBooking->guest_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-envelope text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="font-semibold text-gray-800">{{ $hotelBooking->guest_email ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-phone text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Phone</p>
                                    <p class="font-semibold text-gray-800">{{ $hotelBooking->guest_phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($hotelBooking->special_requests)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Special Requests:</p>
                                <p class="text-gray-600 bg-gray-50 rounded-xl p-4">{{ $hotelBooking->special_requests }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-28">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-green-600"></i>
                            Payment Summary
                        </h3>

                        @php
                            $nights = \Carbon\Carbon::parse($hotelBooking->check_in_date)->diffInDays(
                                \Carbon\Carbon::parse($hotelBooking->check_out_date),
                            );
                            $rooms = $hotelBooking->rooms ?? 1;
                        @endphp

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Room Rate/Night</span>
                                <span>{{ formatIDR($hotelBooking->room->price_with_breakfast ?? 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>{{ $nights }} Night{{ $nights > 1 ? 's' : '' }} × {{ $rooms }}
                                    Room{{ $rooms > 1 ? 's' : '' }}</span>
                                <span>{{ formatIDR(($hotelBooking->room->price_with_breakfast ?? 0) * $nights * $rooms) }}</span>
                            </div>
                            @if ($hotelBooking->include_breakfast)
                                <div class="flex justify-between text-green-600">
                                    <span><i class="fa-solid fa-check mr-1"></i> Breakfast Included</span>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total Paid</span>
                                <span
                                    class="text-2xl font-bold text-green-600">{{ formatIDR($hotelBooking->total_price) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            @if ($hotelBooking->status === 'confirmed')
                                <button onclick="window.print()"
                                    class="w-full bg-green-600 text-white py-3 px-6 rounded-xl font-semibold hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-print"></i>
                                    Print Voucher
                                </button>
                            @endif
                            <a href="{{ route('hotel.show', $hotelBooking->hotel->slug ?? '#') }}"
                                class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-colors text-center">
                                View Hotel
                            </a>
                        </div>

                        <!-- Need Help -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-3">Need help with your booking?</p>
                            <a href="{{ route('contact') }}"
                                class="flex items-center gap-2 text-green-600 hover:text-green-700 font-medium text-sm">
                                <i class="fa-solid fa-headset"></i>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
