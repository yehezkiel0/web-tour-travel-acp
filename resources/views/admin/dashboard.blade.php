@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')

    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2 mb-6">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Dashboard</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Destinations -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full"
                            style="background-color: rgba(59, 130, 246, 0.75);">
                            <i class="fa-solid fa-location-dot text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Destinations</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($totalDestinations) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full"
                            style="background-color: rgba(34, 197, 94, 0.75);">
                            <i class="fa-solid fa-calculator text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full"
                            style="background-color: rgba(147, 51, 234, 0.75);">
                            <i class="fa-solid fa-users text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="w-14 h-14 flex items-center justify-center rounded-full"
                            style="background-color: rgba(245, 158, 11, 0.75);">
                            <i class="fa-solid fa-dollar-sign text-white text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Pending Bookings</h3>
                    <p class="text-3xl font-bold" style="color: #d97706;">{{ number_format($pendingTransactions) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Paid Bookings</h3>
                    <p class="text-3xl font-bold" style="color: #059669;">{{ number_format($paidTransactions) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Travellers</h3>
                    <p class="text-3xl font-bold" style="color: #2563eb;">{{ number_format($totalTravellers) }}</p>
                </div>
            </div>

            <!-- Hotel Statistics -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Hotel Booking Statistics</h3>
                    <a href="{{ route('admin.hotels.bookings.index') }}"
                        class="text-[#4F46E5] hover:text-[#4338CA] text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Total Hotels</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalHotels) }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalHotelBookings) }}</p>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format($pendingHotelBookings) }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Confirmed</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($confirmedHotelBookings) }}</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Revenue</p>
                        <p class="text-lg font-bold text-purple-600">Rp {{ number_format($hotelRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions & Popular Destinations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Bookings</h3>
                    <div class="space-y-4">
                        @forelse($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $transaction->contact_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $transaction->destination->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->code }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">Rp
                                        {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $transaction->adult_count + $transaction->child_count }} pax</p>

                                    @if ($transaction->status == 'paid')
                                        <span class="px-2 py-1 text-xs rounded-full"
                                            style="background-color: #dcfce7; color: #166534;">
                                            Paid
                                        </span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="px-2 py-1 text-xs rounded-full"
                                            style="background-color: #fef3c7; color: #92400e;">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full"
                                            style="background-color: #fee2e2; color: #991b1b;">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">No recent transactions</p>
                        @endforelse
                    </div>
                </div>

                <!-- Popular Destinations -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Destinations</h3>
                    <div class="space-y-4">
                        @forelse($popularDestinations as $destination)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    @if ($destination->featured_photo)
                                        <img src="{{ Storage::url($destination->featured_photo) }}"
                                            alt="{{ $destination->title }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $destination->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $destination->city }},
                                            {{ $destination->country }}</p>
                                        <p class="text-xs text-gray-500">Rp
                                            {{ number_format($destination->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">
                                        {{ $destination->booking_transactions_count ?? $destination->bookings_count }}
                                        bookings</p>
                                    <p class="text-xs text-gray-500">{{ $destination->view_count }} views</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">No bookings yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Hotel Bookings -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Hotel Bookings</h3>
                    <a href="{{ route('admin.hotels.bookings.index') }}"
                        class="text-[#4F46E5] hover:text-[#4338CA] text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking Code</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hotel</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dates</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentHotelBookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $booking->booking_code }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->hotel->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->user->name ?? 'Guest' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ formatIDR($booking->total_price) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'completed' => 'bg-blue-100 text-blue-800',
                                            ];
                                            $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hotel bookings yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Testimonials Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Service Testimonials</h3>
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="text-[#4F46E5] hover:text-[#4338CA] text-sm font-medium">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Total Testimonials</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalTestimonials) }}</p>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Pending Review</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format($pendingTestimonials) }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Approved</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ number_format($totalTestimonials - $pendingTestimonials) }}</p>
                    </div>
                </div>

                <!-- Recent Testimonials Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Service</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Testimonial</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rating</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentTestimonials as $testimonial)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($testimonial->photo)
                                                    <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                        alt="{{ $testimonial->name }}"
                                                        class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&size=100&background=3477F6&color=fff"
                                                        alt="{{ $testimonial->name }}" class="h-10 w-10 rounded-full">
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $testimonial->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $testimonial->location }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $testimonial->service_type == 'medical' ? 'bg-blue-100 text-blue-800' : ($testimonial->service_type == 'recruitment' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                            {{ ucfirst($testimonial->service_type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $testimonial->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ Str::limit($testimonial->message, 80) }}</div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="fa{{ $i <= $testimonial->rating ? 's' : 'r' }} fa-star text-yellow-400 text-xs"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($testimonial->is_approved)
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">No testimonials yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
