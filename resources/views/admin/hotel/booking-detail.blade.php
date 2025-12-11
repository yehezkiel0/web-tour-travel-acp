@extends('admin.layout.app')
@section('title', 'Booking Detail #' . $booking->booking_code)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Booking Detail #{{ $booking->booking_code }}</h1>
            <a href="{{ route('admin_hotel_bookings') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Bookings
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Booking Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Status</h2>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            @if ($booking->status === 'pending')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($booking->status === 'confirmed')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                            @elseif($booking->status === 'cancelled')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                            @elseif($booking->status === 'completed')
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Completed</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Booking Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Check-in Date</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Check-out Date</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Update Status Form -->
                    <form action="{{ route('admin_hotel_booking_update_status', $booking->id) }}" method="POST"
                        class="mt-4 pt-4 border-t">
                        @csrf
                        @method('PUT')
                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                <select name="status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors">
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Hotel & Room Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Hotel & Room Information</h2>

                    <div class="flex gap-4 mb-4">
                        @if ($booking->hotel->featured_photo)
                            <img src="{{ asset('storage/' . $booking->hotel->featured_photo) }}"
                                alt="{{ $booking->hotel->name }}" class="w-32 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hotel text-gray-400 text-2xl"></i>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $booking->hotel->name }}</h3>
                            <div class="flex items-center gap-1 mt-1 mb-2">
                                @for ($i = 0; $i < $booking->hotel->star_rating; $i++)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                {{ $booking->hotel->address }}, {{ $booking->hotel->city }},
                                {{ $booking->hotel->country }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Room Type</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->room->room_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Bed Type</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->room->bed_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Number of Rooms</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->number_of_rooms }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Breakfast Included</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->include_breakfast ? 'Yes' : 'No' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stay Details -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Stay Details</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Check-in Date</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Check-out Date</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Nights</p>
                            <p class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }}
                                nights
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Number of Guests</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->number_of_guests }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Special Requests</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->special_requests ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Guest Info & Payment -->
            <div class="space-y-6">
                <!-- Guest Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Guest Information</h2>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Guest Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Phone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->guest_phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Payment Summary</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Room Rate</span>
                            <span class="text-sm font-medium text-gray-900">{{ formatIDR($booking->room_price) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Number of Nights</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }}
                            </span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-600">Number of Rooms</span>
                            <span class="text-sm font-medium text-gray-900">{{ $booking->number_of_rooms }}</span>
                        </div>
                        @if ($booking->include_breakfast)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-600">Breakfast</span>
                                <span class="text-sm font-medium text-green-600">Included</span>
                            </div>
                        @endif

                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-semibold text-gray-900">Total Amount</span>
                                <span
                                    class="text-base font-bold text-[#4F46E5]">{{ formatIDR($booking->total_price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Midtrans Transaction Info -->
                @if ($booking->midtrans_transaction_id)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Transaction Details</h2>

                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Transaction ID</p>
                                <p class="text-sm font-medium text-gray-900 font-mono">
                                    {{ $booking->midtrans_transaction_id }}</p>
                            </div>
                            @if ($booking->payment_date)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Payment Date</p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($booking->payment_date)->format('d M Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>

                    <div class="space-y-2">
                        <a href="mailto:{{ $booking->user->email }}"
                            class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>Send Email
                        </a>

                        <form action="{{ route('admin_hotel_booking_delete', $booking->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Delete Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
