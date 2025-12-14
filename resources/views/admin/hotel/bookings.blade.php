@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Hotel Bookings</h1>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Bookings</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        </div>
                        <i class="fa-solid fa-clipboard-list text-3xl text-blue-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        </div>
                        <i class="fa-solid fa-clock text-3xl text-yellow-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Confirmed</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
                        </div>
                        <i class="fa-solid fa-check-circle text-3xl text-green-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Cancelled</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
                        </div>
                        <i class="fa-solid fa-times-circle text-3xl text-red-500"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Revenue</p>
                            <p class="text-xl font-bold text-primary">Rp
                                {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        </div>
                        <i class="fa-solid fa-money-bill-wave text-3xl text-green-500"></i>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <form method="GET" action="{{ route('admin.hotels.bookings.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Booking Code</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="HTL123456"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    </div>

                    <div class="md:col-span-4 flex gap-2">
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-800">
                            <i class="fa-solid fa-filter mr-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('admin.hotels.bookings.index') }}"
                            class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                            <i class="fa-solid fa-rotate-right mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Bookings Table --}}
            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Booking Code</th>
                                <th scope="col" class="px-4 py-3">Hotel</th>
                                <th scope="col" class="px-4 py-3">Guest</th>
                                <th scope="col" class="px-4 py-3">Check In/Out</th>
                                <th scope="col" class="px-4 py-3">Room & Nights</th>
                                <th scope="col" class="px-4 py-3">Total Price</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        <div class="font-semibold">{{ $booking->booking_code }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $booking->hotel->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->room->room_name }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium">{{ $booking->guest_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->guest_email }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->guest_phone }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs">
                                            <div><strong>In:</strong> {{ $booking->check_in_date->format('d M Y') }}</div>
                                            <div><strong>Out:</strong> {{ $booking->check_out_date->format('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-xs">
                                            <div>{{ $booking->number_of_rooms }} room(s)</div>
                                            <div>{{ $booking->number_of_nights }} night(s)</div>
                                            <div>{{ $booking->number_of_guests }} guest(s)</div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-primary whitespace-nowrap">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($booking->status == 'pending')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Confirmed</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Cancelled</span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.hotels.bookings.show', $booking->id) }}"
                                                class="text-blue-600 hover:text-blue-800" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            {{-- Quick Status Update --}}
                                            <form
                                                action="{{ route('admin.hotels.bookings.update_status', $booking->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="text-xs border border-gray-300 rounded px-2 py-1">
                                                    <option value="pending"
                                                        {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="confirmed"
                                                        {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                    <option value="completed"
                                                        {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                </select>
                                            </form>

                                            <button type="button"
                                                onclick="openDeleteModal('{{ route('admin.hotels.bookings.destroy', $booking->id) }}')"
                                                class="text-red-600 hover:text-red-800">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                        No bookings found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
