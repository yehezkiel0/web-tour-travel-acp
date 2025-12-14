@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="min-h-screen bg-gray-50 py-12 flex items-center justify-center">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <!-- Success Header -->
                <div class="bg-green-50 p-8 text-center border-b border-green-100">
                    <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
                    <p class="text-gray-600">Your booking has been confirmed. Please check your email for the e-ticket.</p>
                </div>

                <!-- Booking Details -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                            @if ($transaction->destination->featured_photo)
                                <img src="{{ Storage::url($transaction->destination->featured_photo) }}"
                                    class="w-full h-full object-cover" alt="{{ $transaction->destination->title }}">
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Destination</p>
                            <h3 class="font-bold text-lg text-gray-900">{{ $transaction->destination->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $transaction->adult_count }} Adults,
                                {{ $transaction->child_count }} Children</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Order ID</p>
                            <p class="font-semibold text-gray-900">{{ $transaction->code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Total Paid</p>
                            <p class="font-bold text-xl text-primary">{{ formatIDR($transaction->total_price) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Date</p>
                            <p class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($transaction->from_date)->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                            <p class="font-medium text-gray-900 capitalize">Midtrans</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-8 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('profile.bookings') }}"
                        class="w-full text-center px-6 py-4 rounded-xl text-primary font-bold bg-white border border-gray-200 hover:bg-gray-50 hover:border-primary transition-all duration-300">
                        View My Bookings
                    </a>
                    <a href="{{ route('home') }}"
                        class="w-full text-center px-6 py-4 rounded-xl text-white font-bold bg-primary hover:bg-blue-600 shadow-lg shadow-blue-500/30 transition-all duration-300">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
