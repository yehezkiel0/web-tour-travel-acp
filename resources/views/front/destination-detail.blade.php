@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')

    <div class="container mx-auto max-w-7xl px-4 py-8">
        {{-- Header Section --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-3xl font-bold mb-2">{{ $destination->title }}</h2>
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>({{ $destination->count }} Reviews)</span>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold">${{ number_format($destination->price) }}</p>
                <p class="text-gray-600">per night</p>
            </div>
        </div>

        {{-- Gallery Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            {{-- Main Image --}}
            <div class="relative">
                <img src="{{ asset('uploads/' . $destination->featured_photo) }}" alt="{{ $destination->title }}"
                    class="w-full h-96 object-cover rounded-lg" />
            </div>

            {{-- Gallery Grid --}}
            <div id="gallery" class="grid grid-cols-2 gap-4"
                data-photos="{{ json_encode($destination_photos->pluck('photo')) }}">
                @foreach ($destination_photos as $index => $photo)
                    @if ($index < 3)
                        <div class="relative">
                            <img src="{{ asset('uploads/' . $photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-44 object-cover rounded-lg" />
                        </div>
                    @elseif ($index === 3)
                        <div class="relative cursor-pointer" id="openGalleryModal">
                            <img src="{{ asset('uploads/' . $photo->photo) }}"
                                alt="{{ $destination->title }} gallery image {{ $index + 1 }}"
                                class="w-full h-44 object-cover rounded-lg brightness-50" />
                            <div class="absolute inset-0 flex items-center justify-center bg-opacity-50 rounded-lg">
                                <p class="text-gray-300 text-3xl">+{{ $destination_photos->count() - 4 }}</p>
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
        <div class="border-b mb-8">
            <nav class="flex gap-8 overflow-x-auto" id="destinationTabs">
                <button data-tab="overview" class="tab-btn active py-4 px-2 border-b-2 border-black">Overview</button>
                <button data-tab="amenities" class="tab-btn py-4 px-2 border-b-2 border-transparent">Amenities</button>
                <button data-tab="policies" class="tab-btn py-4 px-2 border-b-2 border-transparent">Policies</button>
                <button data-tab="location" class="tab-btn py-4 px-2 border-b-2 border-transparent">Location</button>
                <button data-tab="included" class="tab-btn py-4 px-2 border-b-2 border-transparent">What's Included</button>
                <button data-tab="reviews" class="tab-btn py-4 px-2 border-b-2 border-transparent">Reviews</button>
                <button data-tab="availability"
                    class="tab-btn py-4 px-2 border-b-2 border-transparent">Availability</button>
                <button data-tab="faqs" class="tab-btn py-4 px-2 border-b-2 border-transparent">FAQs</button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
            <div id="overview" class="tab-pane active">
                <!-- Overview content -->
                <h1>Overview</h1>
            </div>
            <div id="amenities" class="tab-pane hidden">
                <!-- Amenities content -->
            </div>
            <div id="policies" class="tab-pane hidden">
                <!-- Policies content -->
            </div>
            <!-- Add other tab panes -->
        </div>

        {{-- Packages Section --}}
        <section class="mb-16">
            <h3 class="text-2xl font-bold mb-8">Packages</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- @foreach ($packages as $package)
                    <div class="border rounded-lg overflow-hidden">
                        <img src="{{ $package->image }}" alt="{{ $package->title }}" class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <h4 class="font-bold mb-2">{{ $package->title }}</h4>
                            <p class="text-gray-600 text-sm mb-4">{{ $package->description }}</p>
                            <div class="flex gap-2">
                                @foreach ($package->tags as $tag)
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach --}}
            </div>
        </section>
    </div>

    @include('front.layout.footer')
@endsection
