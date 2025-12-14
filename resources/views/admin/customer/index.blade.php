@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Customer Management</h1>
            </div>
            <div class="py-4">
                <div class="w-full mx-auto px-4 sm:px-0">
                    <div class="bg-white rounded-lg overflow-hidden">
                        <div class="relative shadow-md sm:rounded-lg overflow-hidden">
                            <div
                                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                                <div class="w-full md:w-2/3">
                                    <form method="GET" action="{{ route('admin.customers.index') }}"
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
                                                placeholder="Search by name, email, or referral code...">
                                        </div>

                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                            <i class="fa-solid fa-search mr-1"></i>
                                            Search
                                        </button>

                                        @if (request('search'))
                                            <a href="{{ route('admin.customers.index') }}"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                                <i class="fa-solid fa-times mr-1"></i>
                                                Clear
                                            </a>
                                        @endif
                                    </form>
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
                                                Photo
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Name
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Email
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Referral Code
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Referred By
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-300">
                                                Joined Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    {{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    @if ($customer->photo)
                                                        <img src="{{ Storage::url($customer->photo) }}"
                                                            alt="{{ $customer->name }}"
                                                            class="w-[40px] h-[40px] rounded-full object-cover">
                                                    @else
                                                        <div
                                                            class="w-[40px] h-[40px] rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                            {{ substr($customer->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300 font-medium">
                                                    {{ $customer->name }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 border border-gray-300">
                                                    {{ $customer->email }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border border-gray-300">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded font-mono border border-blue-400">{{ $customer->referral_code ?? 'N/A' }}</span>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 border border-gray-300">
                                                    @if ($customer->referrer)
                                                        {{ $customer->referrer->name }}
                                                        <br>
                                                        <span
                                                            class="text-xs text-gray-400">({{ $customer->referrer->referral_code }})</span>
                                                    @else
                                                        <span class="text-gray-400 italic">-</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 border border-gray-300">
                                                    {{ $customer->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <!-- Pagination -->
                            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-t border-gray-200">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div
                                        class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm">
                                        Showing <span
                                            class="font-semibold text-blue-600">{{ $customers->firstItem() ?? 0 }}</span>
                                        to
                                        <span class="font-semibold text-blue-600">{{ $customers->lastItem() ?? 0 }}</span>
                                        of
                                        <span class="font-semibold text-gray-800">{{ $customers->total() }}</span>
                                        results
                                    </div>
                                    <div>
                                        {{ $customers->appends(request()->query())->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
