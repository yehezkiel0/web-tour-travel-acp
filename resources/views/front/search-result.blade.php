@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="bg-[#EBF1FE] bg-opacity-70">
        <div class="max-w-7xl mx-auto flex flex-row items-start justify-center gap-x-5 py-[60px]">
            <div class="max-w-md py-[30px] bg-white rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-[30px] px-7">
                    <h2 class="text-base font-medium text-gray-2">Advance Search</h2>
                    <button class="clear-all-btn text-gray-3 text-xs hover:text-gray-500">Clear All</button>
                </div>
                <hr class="border-[#E0E0E0]">

                <form id="searchForm" class="px-7">
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
                                <option value="bali">Bali</option>
                                <option value="jakarta">Jakarta</option>
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
                            class="date-input w-full text-xs p-3 bg-[#EBF1FE] rounded-lg text-gray-3 focus:outline-none"
                            value="2025-09-01">
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="text-gray-2 font-semibold text-sm block mb-2">Price Range</label>
                        <div class="space-y-4">
                            <input type="range" class="price-range w-full" min="0" max="16000000" step="100000">
                            <div class="flex items-center space-x-4">
                                <input type="text"
                                    class="min-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    placeholder="IDR 0" value="IDR 0">
                                <p class="text-[#8B8B8B]">-</p>
                                <input type="text"
                                    class="max-price w-1/2 py-2 px-4 border border-[#8B8B8B] rounded-full font-normal text-[#3C3C3C] text-sm"
                                    placeholder="IDR 16,000,000" value="IDR 16,000,000">
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
                        <div class="space-y-3 p-5 rounded-lg">
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    value="open">
                                <span class="text-gray-2 font-normal text-xs">Open trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    value="private">
                                <span class="text-gray-2 font-normal text-xs">Private trip</span>
                            </label>
                            <label class="flex flex-row-reverse justify-between items-center">
                                <input type="checkbox" class="trip-type form-checkbox h-5 w-5 accent-primary"
                                    value="package">
                                <span class="text-gray-2 font-normal text-xs">Package</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="w-full flex flex-col gap-y-4">
                <div class="max-h-60 flex flex-row gap-x-6 p-5 bg-white border border-[#E0E0E0] rounded-md">
                    <div class="max-w-[285px] ">
                        <img src="{{ asset('images/home/Jeju.png') }}" alt=""
                            class="w-full object-cover rounded-md">
                    </div>
                    <div class="max-w-sm flex flex-col gap-y-[10px]">
                        <h2 class="text-xl font-medium text-gray">Beautiful Jeju Island Private UNESCO</h2>
                        <div class="inline-flex space-x-3 font-medium text-[13px]">
                            <div class="text-primary bg-[#EBF1FE] py-1 px-2 rounded-[10px] border border-primary">Private
                                Tour</div>
                            <div
                                class="text-[#FFB100] bg-[#FFFAEE] py-1 px-2 rounded-[10px] border border-[#FFB100] flex items-center gap-x-2">
                                <img src="{{ asset('images/icon/time-rotate.svg') }}">
                                8-9 Days
                            </div>
                        </div>
                        <p class="text-gray-2 font-normal text-xs pb-[10px]">Relaxed tour to Jeju’s top spots: Oedolgae,
                            Seongsan, and
                            more. No shopping stops, just unforgettable moments!</p>
                        <a href="#"
                            class="text-white bg-primary font-medium text-xs text-center rounded-md py-2 px-8 w-[140px]">Book
                            Now</a>
                    </div>
                    <div class="flex flex-col justify-end pl-[30px] pb-4">
                        <p class="text-gray-2 font-normal text-sm text-end">Start From</p>
                        <p class="text-gray-2 font-semibold text-[17px]">IDR 1.377.000</p>
                        <span class="flex justify-end text-gray-2 font-normal text-xs">/pax</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
