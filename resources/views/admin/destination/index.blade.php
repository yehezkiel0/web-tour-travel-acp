@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Dashboard</h1>
            </div>
            <div class="py-4">
                <div class="w-full mx-auto px-4 sm:px-0">
                    <div class="bg-white rounded-lg overflow-hidden">
                        <div class="relative shadow-md sm:rounded-lg overflow-hidden">
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full md:w-2/3">
                                    <form method="GET" action="{{ route('admin_destination_index') }}"
                                        class="flex items-center gap-3">
                                        <div class="relative flex-1">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2"
                                                placeholder="Search destinations by title, city, or country...">
                                        </div>

                                        <!-- Filter by Country -->
                                        <select name="country"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2">
                                            <option value="">All Countries</option>
                                            <option value="South Korea"
                                                {{ request('country') == 'South Korea' ? 'selected' : '' }}>South Korea
                                            </option>
                                            <option value="Japan" {{ request('country') == 'Japan' ? 'selected' : '' }}>
                                                Japan</option>
                                            <option value="Thailand"
                                                {{ request('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                            <option value="Indonesia"
                                                {{ request('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                        </select>

                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                            <i class="fa-solid fa-filter mr-1"></i>
                                            Filter
                                        </button>

                                        @if (request('search') || request('country'))
                                            <a href="{{ route('admin_destination_index') }}"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                                <i class="fa-solid fa-times mr-1"></i>
                                                Clear
                                            </a>
                                        @endif
                                    </form>
                                </div>
                                <div
                                    class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                    <a href="{{ route('admin_destination_create') }}">
                                        <button type="button"
                                            class="flex items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2">
                                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                            </svg>
                                            Add product
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto px-4">
                                <table class="min-w-full divide-y divide-gray-200 border-collapse border border-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="w-3 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                SL
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Item Name
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Photo
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Gallery
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($destinations as $destination)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    {{ $loop->iteration }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    {{ $destination->title }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    <img src="{{ Storage::url($destination->featured_photo) }}"
                                                        alt="{{ $destination->title }}" class="w-[100px] object-cover">
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    <div class="flex justify-center items-center space-x-2">
                                                        <a href="{{ route('destination_photos', ['slug' => $destination->slug]) }}"
                                                            class="rounded-md shadow-sm text-sm font-medium bg-green-500 text-white px-3 py-2 hover:bg-green-600">
                                                            Photo Gallery
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex justify-center items-center space-x-2">
                                                        @if ($destination->destination_detail)
                                                            <a href="{{ route('admin_destination_details_edit', ['slug' => $destination->slug]) }}"
                                                                class="inline-flex items-center px-3 py-2 border border-blue-400 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200">
                                                                <i class="fas fa-list mr-1"></i> Details
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin_destination_details', ['slug' => $destination->slug]) }}"
                                                                class="inline-flex items-center px-3 py-2 border border-green-400 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200">
                                                                <i class="fas fa-plus mr-1"></i> Add Details
                                                            </a>
                                                        @endif
                                                        <a
                                                            href="{{ route('admin_destination_edit', ['slug' => $destination->slug]) }}">
                                                            <button type="button"
                                                                class="inline-flex items-center px-3 py-2 border border-blue-400 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </a>
                                                        <form
                                                            action="{{ route('admin_destination_delete', ['id' => $destination->id]) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit"
                                                                class="inline-flex items-center px-3 py-2 border border-red-400 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                <i class="fas fa-trash"></i>
                                                            </button>

                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <!-- Pagination -->
                            <div class="px-4 py-3 border-t border-gray-200">
                                <div class="flex items-center justify-between flex-wrap gap-3">
                                    <div class="text-sm text-gray-700">
                                        Showing <span class="font-medium">{{ $destinations->firstItem() ?? 0 }}</span> to
                                        <span class="font-medium">{{ $destinations->lastItem() ?? 0 }}</span> of
                                        <span class="font-medium">{{ $destinations->total() }}</span> results
                                    </div>
                                    <div>
                                        {{ $destinations->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
