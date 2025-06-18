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
                        <div class="p-3 rounded-full" style="background-color: rgba(59, 130, 246, 0.75);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Destinations</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalDestinations) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full" style="background-color: rgba(34, 197, 94, 0.75);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full" style="background-color: rgba(147, 51, 234, 0.75);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a3 3 0 01-3 3H9m-8.248 0H1.5a3 3 0 01-3-3V5.25a3 3 0 013-3h8.748">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full" style="background-color: rgba(245, 158, 11, 0.75);">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}
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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
                                            alt="{{ $destination->title }}"
                                            class="w-10 h-10 rounded-lg object-cover mr-3">
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
                                    <p class="text-xs text-gray-500">{{ $destination->view_count }} views</p>
                                    <p class="text-xs" style="color: #059669;">{{ $destination->type }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">No destinations yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
