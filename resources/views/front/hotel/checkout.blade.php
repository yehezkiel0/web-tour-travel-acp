@extends('front.layout.app')

@section('title', 'Checkout - ' . $hotel->name)

@section('content')
    @include('front.layout.nav')

    <section class="bg-[#EBF1FE] bg-opacity-70 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-gray-1 mb-2">Complete Your Booking</h1>
                <p class="text-sm text-gray-3">Please fill in your details to complete the hotel booking</p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Guest Details Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-1 mb-6">Guest Details</h2>

                        <form action="{{ route('hotel.payment', $hotel->slug) }}" method="POST" id="bookingForm">
                            @csrf

                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="guest_name" class="block text-sm font-medium text-gray-2 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="guest_name" name="guest_name" required
                                            value="{{ old('guest_name', Auth::user()->name ?? '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                        @error('guest_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="guest_email" class="block text-sm font-medium text-gray-2 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="guest_email" name="guest_email" required
                                            value="{{ old('guest_email', Auth::user()->email ?? '') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                        @error('guest_email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="guest_phone" class="block text-sm font-medium text-gray-2 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="guest_phone" name="guest_phone" required
                                        value="{{ old('guest_phone') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                                    @error('guest_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="special_request" class="block text-sm font-medium text-gray-2 mb-2">
                                        Special Requests (Optional)
                                    </label>
                                    <textarea id="special_request" name="special_request" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">{{ old('special_request') }}</textarea>
                                    <p class="text-xs text-gray-3 mt-1">Let us know if you have any special requirements</p>
                                    @error('special_request')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="border-t pt-6">
                                    <label class="flex items-start gap-x-3">
                                        <input type="checkbox" required class="mt-1 h-5 w-5 accent-primary">
                                        <span class="text-sm text-gray-3">
                                            I agree to the <a href="#" class="text-primary hover:underline">Terms and
                                                Conditions</a> and <a href="#"
                                                class="text-primary hover:underline">Privacy
                                                Policy</a>
                                        </span>
                                    </label>
                                </div>

                                <button type="submit"
                                    class="w-full bg-primary text-white py-4 rounded-lg font-bold text-lg hover:bg-primary-400 transition">
                                    <i class="fa-solid fa-lock mr-2"></i>
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Booking Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-1 mb-6">Booking Summary</h2>

                        {{-- Hotel Info --}}
                        <div class="mb-6 pb-6 border-b">
                            <div class="flex gap-4">
                                <img src="{{ Storage::url($hotel->featured_photo) }}" alt="{{ $hotel->name }}"
                                    class="w-24 h-24 object-cover rounded-lg">
                                <div>
                                    <h3 class="font-bold text-gray-1">{{ $hotel->name }}</h3>
                                    <div class="flex items-center gap-x-1 mt-1">
                                        @for ($i = 0; $i < $hotel->star_rating; $i++)
                                            <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-3 mt-1">
                                        <i class="fa-solid fa-location-dot mr-1"></i>
                                        {{ $hotel->city }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Room Info --}}
                        <div class="mb-6 pb-6 border-b">
                            <h4 class="font-semibold text-gray-2 mb-3">Room Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Room Type:</span>
                                    <span class="text-gray-1 font-medium">{{ $room->room_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Guests:</span>
                                    <span class="text-gray-1 font-medium">{{ $bookingData['number_of_guests'] }}
                                        Guest(s)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Rooms:</span>
                                    <span class="text-gray-1 font-medium">{{ $bookingData['number_of_rooms'] }}
                                        Room(s)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Booking Dates --}}
                        <div class="mb-6 pb-6 border-b">
                            <h4 class="font-semibold text-gray-2 mb-3">Stay Duration</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Check-in:</span>
                                    <span
                                        class="text-gray-1 font-medium">{{ \Carbon\Carbon::parse($bookingData['check_in'])->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Check-out:</span>
                                    <span
                                        class="text-gray-1 font-medium">{{ \Carbon\Carbon::parse($bookingData['check_out'])->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-3">Number of Nights:</span>
                                    <span class="text-gray-1 font-medium">{{ $bookingData['number_of_nights'] }}
                                        Night(s)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Price Breakdown --}}
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-2 mb-3">Price Details</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-3">
                                        Rp {{ number_format($bookingData['room_price'], 0, ',', '.') }} x
                                        {{ $bookingData['number_of_nights'] }} night(s) x
                                        {{ $bookingData['number_of_rooms'] }} room(s)
                                    </span>
                                    <span class="text-gray-1 font-medium">Rp
                                        {{ number_format($bookingData['total_price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Total --}}
                        <div class="pt-6 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-1">Total</span>
                                <span class="text-2xl font-bold text-primary">
                                    Rp {{ number_format($bookingData['total_price'], 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-3 mt-2">
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Includes taxes and fees
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
