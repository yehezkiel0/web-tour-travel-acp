@extends('front.layout.app')

@section('title', 'Booking Success')

@section('content')
    @include('front.layout.nav')

    <section class="bg-[#EBF1FE] bg-opacity-70 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                {{-- Success Icon --}}
                <div class="mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                        <i class="fa-solid fa-check text-4xl text-green-600"></i>
                    </div>
                </div>

                {{-- Success Message --}}
                <h1 class="text-3xl font-bold text-gray-1 mb-3">Booking Confirmed!</h1>
                <p class="text-gray-3 mb-8">
                    Your hotel reservation has been successfully confirmed. We've sent the booking details to your email.
                </p>

                {{-- Booking Code --}}
                <div class="bg-[#EBF1FE] rounded-lg p-6 mb-8">
                    <p class="text-sm text-gray-3 mb-2">Booking Code</p>
                    <p class="text-3xl font-bold text-primary mb-2">{{ $booking->booking_code }}</p>
                    <p class="text-xs text-gray-3">Please save this code for your reference</p>
                </div>

                {{-- Booking Details --}}
                <div class="text-left mb-8">
                    <h3 class="text-lg font-bold text-gray-1 mb-4">Booking Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Hotel Name:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->hotel->name }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Room Type:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->room->room_name }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Check-in:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->check_in_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Check-out:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->check_out_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Number of Nights:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->number_of_nights }} Night(s)</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Guests:</span>
                            <span class="font-semibold text-gray-1">{{ $booking->number_of_guests }} Guest(s)</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-3">Total Amount:</span>
                            <span class="font-bold text-primary text-xl">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Important Information --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 text-left">
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-info text-yellow-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-1 mb-1">Important Information</h4>
                            <ul class="text-sm text-gray-3 space-y-1">
                                <li>• Please arrive at the hotel after 2:00 PM for check-in</li>
                                <li>• Check-out time is before 12:00 PM</li>
                                <li>• Please bring a valid ID and this booking code</li>
                                <li>• For any changes or cancellations, please contact us</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('hotel.index') }}"
                        class="bg-white border-2 border-primary text-primary px-8 py-3 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                        Browse More Hotels
                    </a>
                    <a href="{{ route('home') }}"
                        class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-400 transition">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
