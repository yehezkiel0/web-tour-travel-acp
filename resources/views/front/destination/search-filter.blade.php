@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="bg-[#EBF1FE] bg-opacity-70">
        {{-- Overlay Mobile --}}
        <div
            class="mobile-filter-overlay fixed inset-0 z-[999] bg-white transform translate-x-full transition-transform duration-300 overflow-y-auto">
            <div class="max-w-md mx-auto py-[30px] bg-white">
                <div class="flex justify-between items-center mb-[30px] px-7">
                    <h2 class="text-base font-medium text-gray-2">Advance Search</h2>
                    <button class="close-filter-btn text-gray-3 text-xs hover:text-gray-500">Close</button>
                </div>
                <hr class="border-[#E0E0E0]">

                <!-- Isi filter sama seperti kode sebelumnya -->
                <div class="px-7">
                    <!-- Location -->
                    <div class="my-[30px]">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-2 font-semibold text-sm">Location</label>
                            <button type="button"
                                class="clear-location-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <div class="relative">
                            <select
                                class="location-select appearance-none w-full p-3 bg-[#EBF1FE] rounded-lg text-gray-3 text-xs focus:outline-none">
                                <option value="">Place to Go</option>
                                <option value="seoul">Seoul</option>
                                <option value="jeju">Jeju</option>
                                <option value="yogyakarta">Yogyakarta</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-2 font-semibold text-sm">Date</label>
                            <button type="button"
                                class="clear-date-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <input type="date"
                            class="date-input w-full text-xs p-3 bg-[#EBF1FE] rounded-lg text-gray-3 focus:outline-none">
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="text-gray-2 font-semibold text-sm block mb-2">Price Range</label>
                        <div class="space-y-4">
                            <input type="range" class="price-range w-full" min="0" max="0" step="100000">
                            <div class="flex items-center space-x-4">
                                <input type="text"
                                    class="min-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    value="0">
                                <p class="text-[#8B8B8B]">-</p>
                                <input type="text"
                                    class="max-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    data-max-price="{{ $maxPrice }}" value="{{ $maxPrice }}">
                            </div>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="mb-6 rounded-md border-2">
                        <div class="flex justify-between bg-[#EBF1FE] items-center px-5 py-[10px] border-b-2">
                            <label class="text-gray-2 font-semibold text-sm">Type</label>
                            <button type="button"
                                class="clear-type-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <div class="space-y-3 p-5 rounded-lg" id="trip-type-container">
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Open Trip">
                                <span class="text-gray-2 font-normal text-xs">Open trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Private Trip">
                                <span class="text-gray-2 font-normal text-xs">Private trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Package">
                                <span class="text-gray-2 font-normal text-xs">Package</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-start md:justify-center gap-x-5 py-[60px] relative">
            {{-- Overlay Desktop --}}
            <div class="hidden md:block max-w-md py-[30px] bg-white rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-[30px] px-7">
                    <h1 class="text-base font-medium text-gray-2">Advance Search</h1>
                    <button class="clear-all-btn text-gray-3 text-xs hover:text-gray-500">Clear All</button>
                </div>
                <hr class="border-[#E0E0E0]">

                <div class="px-7">
                    <!-- Location -->
                    <div class="my-[30px]">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-2 font-semibold text-sm">Location</label>
                            <button type="button"
                                class="clear-location-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <div class="relative">
                            <select
                                class="location-select appearance-none w-full p-3 bg-[#EBF1FE] rounded-lg text-gray-3 text-xs focus:outline-none">
                                <option value="">Place to Go</option>
                                <option value="seoul">Seoul</option>
                                <option value="jeju">Jeju</option>
                                <option value="yogyakarta">Yogyakarta</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-gray-2 font-semibold text-sm">Date</label>
                            <button type="button"
                                class="clear-date-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <input type="date"
                            class="date-input w-full text-xs p-3 bg-[#EBF1FE] rounded-lg text-gray-3 focus:outline-none">
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="text-gray-2 font-semibold text-sm block mb-2">Price Range</label>
                        <div class="space-y-4">
                            <input type="range" class="price-range w-full" min="0" max="0"
                                step="100000">
                            <div class="flex items-center space-x-4">
                                <input type="text"
                                    class="min-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    value="0">
                                <p class="text-[#8B8B8B]">-</p>
                                <input type="text"
                                    class="max-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    data-max-price="{{ $maxPrice }}" value="{{ $maxPrice }}">
                            </div>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="mb-6 rounded-md border-2">
                        <div class="flex justify-between bg-[#EBF1FE] items-center px-5 py-[10px] border-b-2">
                            <label class="text-gray-2 font-semibold text-sm">Type</label>
                            <button type="button"
                                class="clear-type-btn text-gray-3 text-xs hover:text-gray-500">Clear</button>
                        </div>
                        <div class="space-y-3 p-5 rounded-lg" id="trip-type-container">
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Open Trip">
                                <span class="text-gray-2 font-normal text-xs">Open trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Private Trip">
                                <span class="text-gray-2 font-normal text-xs">Private trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    name="trip-type[]" value="Package">
                                <span class="text-gray-2 font-normal text-xs">Package</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="search-results" class="w-full flex flex-col gap-y-4 overflow-y-auto max-h-dvh px-4 md:px-0 relative">
                @if (@isset($results) && count($results) > 0)
                    @include('front.partials.search-result', ['results' => $results])
                @endif
            </div>
            <button
                class="md:hidden fixed bottom-3 left-1/2 -translate-x-1/2 z-50 bg-primary text-white py-2 px-4 text-xs inline-flex items-center gap-4 rounded-full shadow-lg filter-toggle-btn">
                <i class="fa-solid fa-filter"></i>
                Filter Destinasi
            </button>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
