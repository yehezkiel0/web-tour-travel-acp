@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Hotel Management</h1>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="py-4">
                <div class="w-full mx-auto px-4 sm:px-0">
                    <div class="bg-white rounded-lg overflow-hidden">
                        <div class="relative shadow-md sm:rounded-lg overflow-hidden">
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full md:w-2/3">
                                    <form method="GET" action="{{ route('admin_hotel_index') }}"
                                        class="flex items-center gap-3">
                                        <div class="relative flex-1">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <i class="fa-solid fa-search text-gray-500"></i>
                                            </div>
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                                                placeholder="Search hotels by name, city, or country...">
                                        </div>

                                        <!-- Filter by Rating -->
                                        <select name="rating"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2">
                                            <option value="">All Ratings</option>
                                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars
                                            </option>
                                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars
                                            </option>
                                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars
                                            </option>
                                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars
                                            </option>
                                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star
                                            </option>
                                        </select>

                                        <!-- Filter by Status -->
                                        <select name="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2">
                                            <option value="">All Status</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>

                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                            <i class="fa-solid fa-filter mr-1"></i>
                                            Filter
                                        </button>

                                        @if (request('search') || request('rating') || request('status'))
                                            <a href="{{ route('admin_hotel_index') }}"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                                <i class="fa-solid fa-times mr-1"></i>
                                                Clear
                                            </a>
                                        @endif
                                    </form>
                                </div>
                                <div
                                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                    <a href="{{ route('admin_hotel_create') }}">
                                        <button type="button"
                                            class="flex items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2">
                                            <i class="fa-solid fa-plus mr-2"></i>
                                            Add New Hotel
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Hotel Name</th>
                                            <th scope="col" class="px-4 py-3">Location</th>
                                            <th scope="col" class="px-4 py-3">Rating</th>
                                            <th scope="col" class="px-4 py-3">Rooms</th>
                                            <th scope="col" class="px-4 py-3">Bookings</th>
                                            <th scope="col" class="px-4 py-3">Status</th>
                                            <th scope="col" class="px-4 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($hotels as $hotel)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ Storage::url($hotel->featured_photo) }}"
                                                            alt="{{ $hotel->name }}"
                                                            class="w-12 h-12 object-cover rounded">
                                                        <div>
                                                            <div class="font-semibold">{{ $hotel->name }}</div>
                                                            <div class="text-xs text-gray-500">{{ $hotel->slug }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-sm">{{ $hotel->city }}, {{ $hotel->country }}</div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-1">
                                                        @for ($i = 0; $i < $hotel->star_rating; $i++)
                                                            <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                        {{ $hotel->rooms_count }} rooms
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span
                                                        class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                        {{ $hotel->bookings_count }} bookings
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if ($hotel->is_active)
                                                        <span
                                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Active</span>
                                                    @else
                                                        <span
                                                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ route('admin_hotel_edit', $hotel->id) }}"
                                                            class="text-blue-600 hover:text-blue-800">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin_hotel_rooms', $hotel->id) }}"
                                                            class="text-green-600 hover:text-green-800"
                                                            title="Manage Rooms">
                                                            <i class="fa-solid fa-bed"></i>
                                                        </a>
                                                        <a href="{{ route('admin_hotel_amenities', $hotel->id) }}"
                                                            class="text-purple-600 hover:text-purple-800"
                                                            title="Manage Amenities">
                                                            <i class="fa-solid fa-list"></i>
                                                        </a>
                                                        <form action="{{ route('admin_hotel_delete', $hotel->id) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-red-600 hover:text-red-800">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                                    No hotels found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-4 py-3 border-t border-gray-200">
                                <div class="flex items-center justify-between flex-wrap gap-3">
                                    <div class="text-sm text-gray-700">
                                        Showing <span class="font-medium">{{ $hotels->firstItem() ?? 0 }}</span> to
                                        <span class="font-medium">{{ $hotels->lastItem() ?? 0 }}</span> of
                                        <span class="font-medium">{{ $hotels->total() }}</span> results
                                    </div>
                                    <div>
                                        {{ $hotels->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
