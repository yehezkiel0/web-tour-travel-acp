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
        </div>
    </div>
@endsection
