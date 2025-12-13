@extends('front.layout.app')

@section('title', 'Booking Details - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 pt-28 pb-16 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <a href="{{ route('profile.bookings') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium mb-4">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to My Bookings
                    </a>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Booking Details</h1>
                </div>
                <div class="mt-4 md:mt-0">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                            'confirmed' => 'bg-green-100 text-green-700 border-green-300',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-300',
                            'completed' => 'bg-blue-100 text-blue-700 border-blue-300',
                        ];
                        $statusColor = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                    @endphp
                    <span class="px-6 py-3 rounded-full text-lg font-bold border-2 {{ $statusColor }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Booking Code Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-blue-200 text-sm mb-1">Booking Code</p>
                        <p class="text-3xl font-mono font-bold tracking-wider">{{ $booking->code }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        <p class="text-blue-200 text-sm mb-1">Booked on</p>
                        <p class="font-semibold">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Destination Info -->
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="relative h-48">
                            @if ($booking->destination && $booking->destination->featured_photo)
                                <img src="{{ Storage::url($booking->destination->featured_photo) }}"
                                    alt="{{ $booking->destination->title }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                                    <i class="fa-solid fa-plane text-white text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-6 right-6 text-white">
                                <h2 class="text-2xl font-bold">{{ $booking->destination->title ?? 'Unknown Destination' }}
                                </h2>
                                <p class="text-white/80">
                                    <i class="fa-solid fa-location-dot mr-1"></i>
                                    {{ $booking->destination->city ?? '' }}, {{ $booking->destination->country ?? '' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days text-blue-600"></i>
                                Travel Schedule
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-1">Start Date</p>
                                    <p class="font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->from_date)->format('l') }}</p>
                                    <p class="text-lg font-semibold text-blue-600">
                                        {{ \Carbon\Carbon::parse($booking->from_date)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 mb-1">End Date</p>
                                    <p class="font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->to_date)->format('l') }}</p>
                                    <p class="text-lg font-semibold text-blue-600">
                                        {{ \Carbon\Carbon::parse($booking->to_date)->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 bg-blue-50 rounded-xl p-4 text-center">
                                <p class="text-sm text-blue-600 mb-1">Total Duration</p>
                                <p class="text-2xl font-bold text-blue-700">
                                    {{ \Carbon\Carbon::parse($booking->from_date)->diffInDays(\Carbon\Carbon::parse($booking->to_date)) }}
                                    Days
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Travelers Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-users text-blue-600"></i>
                            Travelers Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <i class="fa-solid fa-user-tie text-blue-600 text-2xl mb-2"></i>
                                <p class="text-2xl font-bold text-gray-800">{{ $booking->adult_count }}</p>
                                <p class="text-gray-500 text-sm">Adult{{ $booking->adult_count > 1 ? 's' : '' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <i class="fa-solid fa-child text-blue-600 text-2xl mb-2"></i>
                                <p class="text-2xl font-bold text-gray-800">{{ $booking->child_count }}</p>
                                <p class="text-gray-500 text-sm">Child{{ $booking->child_count > 1 ? 'ren' : '' }}</p>
                            </div>
                        </div>

                        @if ($booking->traveller_details)
                            @php
                                $travelers = is_array($booking->traveller_details)
                                    ? $booking->traveller_details
                                    : json_decode($booking->traveller_details, true);
                            @endphp
                            @if (is_array($travelers) && count($travelers) > 0)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Traveler Names:</p>
                                    <div class="space-y-2">
                                        @foreach ($travelers as $index => $traveler)
                                            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                                                <span
                                                    class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="font-medium text-gray-800">
                                                    @if (is_array($traveler))
                                                        {{ $traveler['name'] ?? ($traveler['full_name'] ?? 'Traveler ' . ($index + 1)) }}
                                                    @else
                                                        {{ $traveler }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-address-book text-blue-600"></i>
                            Contact Information
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Contact Name</p>
                                    <p class="font-semibold text-gray-800">{{ $booking->contact_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-phone text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Phone Number</p>
                                    <p class="font-semibold text-gray-800">{{ $booking->contact_phone ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-envelope text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Email Address</p>
                                    <p class="font-semibold text-gray-800">{{ $booking->contact_email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($booking->notes)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Special Notes:</p>
                                <p class="text-gray-600 bg-gray-50 rounded-xl p-4">{{ $booking->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-28">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-blue-600"></i>
                            Payment Summary
                        </h3>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Package Price</span>
                                <span>{{ formatIDR($booking->destination->price ?? 0) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Adults ({{ $booking->adult_count }}x)</span>
                                <span>{{ formatIDR(($booking->destination->price ?? 0) * $booking->adult_count) }}</span>
                            </div>
                            @if ($booking->child_count > 0)
                                <div class="flex justify-between text-gray-600">
                                    <span>Children ({{ $booking->child_count }}x 50%)</span>
                                    <span>{{ formatIDR(($booking->destination->price ?? 0) * 0.5 * $booking->child_count) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total Paid</span>
                                <span
                                    class="text-2xl font-bold text-blue-600">{{ formatIDR($booking->total_price) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            @if ($booking->status === 'confirmed')
                                <button onclick="window.print()"
                                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-xl font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-print"></i>
                                    Print Ticket
                                </button>
                            @endif
                            <a href="{{ route('destination_detail', $booking->destination->slug ?? '#') }}"
                                class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-colors text-center">
                                View Destination
                            </a>
                        </div>

                        <!-- Need Help -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-3">Need help with your booking?</p>
                            <a href="{{ route('contact') }}"
                                class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm">
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
