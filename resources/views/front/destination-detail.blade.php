@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')


    <div class="container mx-auto max-w-7xl px-4 py-8">
        {{-- Header --}}
        <nav class="flex mb-7" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex gap-x-2 items-center font-medium text-gray-3 hover:underline">
                        <img src="{{ asset('images/icon/Home.svg') }}" alt="home-icon">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="ms-1 font-medium text-primary md:ms-2">{{ $destination->title }}</a>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Gallery Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-7">
            {{-- Main Image --}}
            <div class="relative md:col-span-2">
                <img src="{{ asset('uploads/' . $destination->featured_photo) }}" alt="{{ $destination->title }}"
                    class="w-full h-[400px] object-cover rounded-lg" />
            </div>

            {{-- Gallery Grid --}}
            <div id="gallery" class="grid grid-cols-1 gap-4"
                data-photos="{{ json_encode($destination_photos->pluck('photo')) }}">
                @foreach ($destination_photos as $index => $photo)
                    @if ($index < 1)
                        <div class="relative">
                            <img src="{{ asset('uploads/' . $photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-48 object-cover rounded-lg" />
                        </div>
                    @elseif ($index === 1)
                        <div class="relative cursor-pointer" id="openGalleryModal">
                            <img src="{{ asset('uploads/' . $photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-48 object-cover rounded-lg brightness-50" />
                            <div class="absolute inset-0 flex items-center justify-center bg-opacity-50 rounded-lg">
                                <span class="text-white text-xl font-semibold">See All Photos </span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Modal untuk Galeri -->
            <div id="galleryModal"
                class="hidden fixed inset-0 bg-gray-1 bg-opacity-80 items-center justify-center z-50 transition-all ease-in-out duration-300">
                <div class="relative bg-black bg-opacity-25 w-full max-h-full max-w-4xl p-4 rounded-lg">
                    <div class="bg-opacity-100">
                        <!-- Tombol Close -->
                        <button id="closeGalleryModal"
                            class="absolute top-3 right-4 text-red-500 text-3xl px-2 py-1 rounded-md z-10">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>

                        <!-- Navigasi Foto -->
                        <div class="relative flex justify-center text-gray-1">
                            <img id="currentPhoto" src="" alt="Current gallery image"
                                class="w-full h-96 object-cover rounded-md">
                            <button id="prevPhoto" class="absolute top-1/2 left-2 transform -translate-y-1/2 text-3xl ">
                                <i class="fa-solid fa-circle-chevron-left"></i>
                            </button>
                            <button id="nextPhoto" class="absolute top-1/2 right-2 transform -translate-y-1/2 text-3xl">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="border-b mb-10">
            <nav class="flex gap-x-8 z-10 text-sm font-medium text-gray-1" id="destinationTabs">
                <button data-tab="overview" class="tab-btn active py-4 px-2 custom-border">Overview</button>
                <button data-tab="price" class="tab-btn py-4 px-2 custom-border">Price</button>
                <button data-tab="itinerary" class="tab-btn py-4 px-2 custom-border">Itinerary</button>
                <button data-tab="location" class="tab-btn py-4 px-2 custom-border">Location</button>
                <button data-tab="notes" class="tab-btn py-4 px-2 custom-border">Notes</button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-8 text-gray-1 md:col-span-2">
                @include('front.partials.overview')
                @include('front.partials.price')
                @include('front.partials.itinerary')
                @include('front.partials.location')
                @include('front.partials.notes')
            </div>

            <div class="bg-white rounded-2xl px-7 py-6 w-full max-w-md border h-fit">
                <h1 class="text-xl font-semibold mb-6 text-gray-1">Start Booking</h1>
                <form action="" method="POST" class="booking-form">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label id="from-date" class="block text-gray-1 font-medium mb-2">From</label>
                            <div class="relative">
                                <input type="text" name="from_date" id="from_date"
                                    class="date-input w-full px-[18px] py-3 bg-gray-6 rounded-md" required>
                                <img src="{{ asset('images/icon/calender.svg') }}" class="calender-icon">
                            </div>
                        </div>

                        <div>
                            <label id="to-date" class="block text-gray-1 font-medium  mb-2">To</label>
                            <div class="relative">
                                <input type="text" name="to_date" id="to_date"
                                    class="date-input w-full px-[18px] py-3 bg-gray-6 rounded-md" required>
                                <img src="{{ asset('images/icon/calender.svg') }}" class="calender-icon">
                            </div>
                        </div>

                        <div>
                            <h3 class="text-gray-1 font-medium  mb-4">Add Traveller</h3>

                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Adult</span>
                                <div class="flex items-center gap-4">
                                    <button type="button"
                                        class="decrease-adult w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center">-</button>
                                    <input type="number" name="adult_count" id="adult-count" value="1"
                                        class="w-16 text-center" readonly>
                                    <button type="button"
                                        class="increase-adult w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center">+</button>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Child</span>
                                <div class="flex items-center gap-4">
                                    <button type="button"
                                        class="decrease-child w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center">-</button>
                                    <input type="number" name="child_count" id="child-count" value="0"
                                        class="w-16 text-center" readonly>
                                    <button type="button"
                                        class="increase-child w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <p class="text-gray-600 mb-2">Subtotal</p>
                            <h2 class="text-4xl font-bold text-blue-500" id="total-price">IDR 11.890.000</h2>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-500 text-white py-4 rounded-lg font-semibold hover:bg-blue-600 transition">
                            Book Now
                        </button>

                        <p class="text-gray-400 text-sm text-center">*The price shown is an estimate and subject to change.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>



    @include('front.layout.footer')
@endsection
