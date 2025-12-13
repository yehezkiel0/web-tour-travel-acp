@extends('front.layout.app')

@section('preloads')
    <link rel="preload" as="image" href="{{ asset('images/home/Hero_Image.webp') }}" fetchpriority="high" type="image/webp">
    <link rel="preload" as="image" href="{{ asset('images/home/Hero_Image.png') }}" fetchpriority="high" type="image/png">
@endsection

@section('content')
    @include('front.layout.nav')
    <main class="container mx-auto">
        <!-- Hero Section -->
        <section>
            <div class="hero max-w-7xl mx-auto pb-8">
                <div class="flex flex-col-reverse items-center lg:flex-row lg:justify-between px-4 md:px-7 lg:px-5 xl:px-0">
                    <div class="flex flex-col items-center gap-6 lg:items-start lg:gap-10 lg:pl-4">
                        <div class="flex flex-col items-center py-0 gap-y-5 sm:gap-y-2 lg:gap-y-5 lg:py-4 lg:items-start">
                            <div
                                class="text-xl sm:text-2xl flex gap-x-2 md:text-4xl xl:text-5xl lg:block font-bold lg:leading-[60px]">
                                <h1>{{ __('messages.hero_title_1') }}</h1>
                                <h1 class="text-primary">{{ __('messages.hero_title_2') }}</h1>
                            </div>
                            <p class="text-[12px] sm:text-[14px] md:text-base text-[#4F4F4F]">
                                {!! __('messages.hero_subtitle') !!}
                            </p>
                        </div>
                        <button
                            class="bg-primary py-[10px] sm:py-[10px] sm:px-10 w-[164px] md:w-52 rounded-xl text-xs md:text-base text-white border border-[#E0E0E0] font-semibold hover:bg-primary-400">
                            {{ __('messages.discover_now') }}
                        </button>
                    </div>
                    <picture>
                        <source srcset="{{ asset('images/home/Hero_Image.webp') }}" type="image/webp">

                        <img src="{{ asset('images/home/Hero_Image.png') }}" alt="Hero-Image" width="600" height="400"
                            class="hero-image h-auto sm:w-[450px] xl:w-[600px]" fetchpriority="high" decoding="async" />
                    </picture>
                </div>
            </div>
        </section>
        <!-- Popular Destination -->
        <section class="popular-destination relative">
            <div class="max-w-7xl mx-auto py-7 px-6 md:px-7 lg:px-5 xl:px-0">
                <h6
                    class="flex justify-center gap-x-2 xl:gap-x-0 lg:block font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 pb-[20px] text-center">
                    {{ __('messages.explore_destination') }} <span class="text-primary">{{ __('messages.destination') }}
                    </span>
                </h6>
                <p class="pb-[40px] text-center text-xs sm:text-sm lg:text-base">{{ __('messages.explore_subtitle') }}</p>
                <div class="swiper-popular-destination swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($popularDestinations as $destination)
                            <a href="{{ route('destination_detail', $destination->slug) }}" class="swiper-slide card">
                                <div class="rounded-xl overflow-hidden relative flex flex-col cursor-pointer">
                                    <img src="{{ Storage::url($destination->featured_photo) }}"
                                        alt="{{ $destination->title }}" loading="lazy"
                                        class="object-cover h-[220px] w-full" />
                                    <div
                                        class="w-full h-full absolute bottom-0 bg-gradient-to-b from-linearCardStart via-linearCardMid to-linearCardEnd">
                                        <div
                                            class="absolute bottom-3 sm:bottom-4 px-3 sm:px-5 bg-blend-multiply bg-[#BDBDBD] bg-opacity-30 w-full">
                                            <h3
                                                class="text-white text-xl sm:text-lg lg:text-sm xl:text-xl font-semibold md:font-bold">
                                                {{ $destination->title }}</h3>
                                            <div
                                                class="flex flex-row items-center gap-x-1 sm:gap-x-2 text-white text-lg sm:text-base lg:text-sm">
                                                <i class="fa-solid fa-location-dot text-sm lg:text-base"></i>
                                                <p class="text-sm xl:text-base font-normal">{{ $destination->city }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-navigation navigation-popular-destination">
                    <div class="swiper-button-prev" style="background-image: url('/images/icon/Prev.svg')"></div>
                    <div class="swiper-button-next" style="background-image: url('/images/icon/Next.svg')"></div>
                </div>
            </div>
        </section>
        {{-- Search --}}
        <section>
            <div class="max-w-7xl mx-auto py-7 scroll-m-10">
                <div
                    class="flex flex-col-reverse gap-y-5 md:flex-row md:items-center md:justify-center md:gap-x-5 lg:gap-x-10 px-6 md:px-7 lg:px-5 xl:px-0">
                    <div class="w-full md:w-1/2 mx-auto h-[568]">
                        <div class="w-full flex flex-col items-center relative" id="image-search">
                            <img src="{{ asset('images/home/sectionSearch.png') }}" alt="Search" loading="lazy"
                                class="rounded-lg w-full" />
                            <form action="{{ route('search_result') }}" method="GET"
                                class="absolute bottom-6 z-50 flex flex-row items-center justify-between w-[95%] xl:w-[90%] left-1/2 -translate-x-1/2 bg-gray-3 rounded-full border border-gray-400 p-1 md:p-2 shadow-lg glass">

                                <div class="flex-1 flex items-center justify-between px-2 md:px-4 gap-2">
                                    <!-- Destination -->
                                    <div class="flex items-center gap-2 flex-1 min-w-0">
                                        <i class="fa-solid fa-location-dot text-gray-400 text-xs md:text-sm"></i>
                                        <input type="text" id="destination_input" name="q"
                                            placeholder="Destination"
                                            class="w-full bg-transparent border-none outline-none text-xs md:text-sm text-gray-700 placeholder-gray-500 truncate focus:ring-0">
                                    </div>

                                    <div class="h-4 md:h-6 w-px bg-gray-300 mx-1"></div>

                                    <!-- Date -->
                                    <div
                                        class="datepicker-container flex items-center gap-2 cursor-pointer relative group flex-1 min-w-0">
                                        <i class="fa-regular fa-calendar text-gray-400 text-xs md:text-sm"></i>
                                        <input type="text" name="date" id="destination_date"
                                            class="datepicker w-full bg-transparent border-none outline-none text-xs md:text-sm text-gray-700 placeholder-gray-500 cursor-pointer focus:ring-0 p-0"
                                            placeholder="Date" readonly>
                                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                                    </div>

                                    <div class="h-4 md:h-6 w-px bg-gray-300 mx-1"></div>

                                    <!-- Type -->
                                    <div class="flex items-center gap-2 relative flex-1 min-w-0">
                                        <i class="fa-solid fa-person-hiking text-gray-400 text-xs md:text-sm"></i>

                                        <!-- Hidden Input for Form Submission -->
                                        <input type="hidden" name="trip_type" id="destination_type_input">

                                        <!-- Custom Dropdown Trigger -->
                                        <div id="dropdown-trigger"
                                            class="cursor-pointer flex items-center justify-between w-full">
                                            <span id="selected-type"
                                                class="text-[9px] md:text-xs lg:text-sm xl:text-base text-gray-400 truncate">{{ __('messages.type') }}</span>
                                            <i class="fa-solid fa-chevron-down text-[10px] md:text-[8px] lg:text-[10px] transition-transform duration-200 ml-1"
                                                id="dropdown-icon"></i>
                                        </div>

                                        <!-- Custom Dropdown Options -->
                                        <div id="dropdown-options"
                                            class="hidden absolute top-full left-0 mt-2 w-full min-w-[120px] bg-white rounded-lg shadow-xl z-50 overflow-hidden border border-gray-100">
                                            <div class="option-item px-4 py-2 text-gray-700 hover:bg-blue-50 cursor-pointer text-[10px] md:text-xs lg:text-sm transition-colors"
                                                data-value="Open Trip">
                                                {{ __('messages.open_trip') }}
                                            </div>
                                            <div class="option-item px-4 py-2 text-gray-700 hover:bg-blue-50 cursor-pointer text-[10px] md:text-xs lg:text-sm transition-colors"
                                                data-value="Private Trip">
                                                {{ __('messages.private_tour') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="font-semibold text-[10px] sm:text-[11px] lg:text-sm w-1/4 text-gray-1 rounded-full bg-secondary py-1 px-2 lg:py-2 lg:px-6 hover:bg-yellow-300 transition-all ease-in-out duration-300">{{ __('messages.search') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 mx-auto">
                        <div class="flex flex-col gap-y-3 md:gap-y-[14px] lg:gap-y-[23px]">
                            <div class="flex flex-col gap-y-0 lg:gap-y-2 text-center md:text-start">
                                <h1 class="font-bold text-xl md:text-2xl xl:text-[35px] text-gray-1">
                                    {{ __('messages.one_click_for') }} <span
                                        class="text-primary">{{ __('messages.you') }}</span></h1>
                                <p class="text-gray-3 text-xs xl:text-base">{{ __('messages.how_it_works') }}</p>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/date.svg') }}" alt="date"
                                    class="icon-container w-10 md:w-11 lg:w-[52px] h-auto">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">
                                        {{ __('messages.set_date') }}
                                    </h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">{{ __('messages.set_date_desc') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/flight.svg') }}" alt="flight"
                                    class="icon-container w-10 md:w-11 lg:w-[52px]">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">
                                        {{ __('messages.select_destination') }}
                                    </h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">
                                        {{ __('messages.select_destination_desc') }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/search.svg') }}" alt="search"
                                    class="icon-container w-10 md:w-11 lg:w-[52px]">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">
                                        {{ __('messages.choose_trip_type') }}
                                    </h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">
                                        {{ __('messages.choose_trip_type_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Open Trip -->
        <section>
            <div class="open-trip max-w-7xl mx-auto py-7">
                <div
                    class="flex flex-col gap-y-[20px] sm:gap-x-8 sm:grid sm:grid-cols-2 lg:grid-cols-4 px-6 md:px-7 lg:px-5 xl:px-0">
                    <div
                        class="lg:col-span-1 flex flex-col gap-y-2 lg:gap-y-[20px] justify-center items-center sm:items-start md:pl-4 lg:pl-0">
                        <h2
                            class="font-bold text-2xl block sm:flex sm:flex-col sm:gap-y-2 sm:text-4xl lg:text-[35px] text-center sm:text-left lg:leading-[60px]">
                            {{ __('messages.hop_on_open_trip') }} <span
                                class="font-semibold text-primary">{{ __('messages.open_trip') }}</span>
                        </h2>
                        <p class="pb-3 sm:pb-[20px] lg:pb-[40px] text-xs sm:text-base">{{ __('messages.open_trip_desc') }}
                        </p>
                        <a href="{{ route('destination', ['type' => 'open-trip']) }}"
                            class="bg-white py-2 px-5 text-xs text-center sm:py-[10px] sm:px-10 w-40 md:w-52 md:text-base rounded-[10px] text-primary border border-primary font-semibold hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                            {{ __('messages.see_more') }}

                        </a>
                    </div>
                    <div class="lg:col-span-3 lg:px-0">
                        <div class="swiper-open-trip swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($openTrips as $trip)
                                    <a href="{{ route('destination_detail', $trip->slug) }}" class="swiper-slide card">
                                        <div class="rounded-3xl overflow-hidden relative flex flex-col cursor-pointer">
                                            <div class="tag font-bold text-[12px] text-primary-800">
                                                <span>{{ $trip->type }}</span>
                                            </div>
                                            <img src="{{ Storage::url($trip->featured_photo) }}" loading="lazy"
                                                alt="{{ $trip->title }}"
                                                class="object-cover h-[360px] md:h-[420px] w-full" />
                                            <div
                                                class="w-full h-full absolute bottom-0 bg-gradient-to-b from-linearCardStart via-linearCardMid to-linearCardEnd">
                                                <div
                                                    class="background-transparent absolute bottom-0 border-t-2 border-white  bg-gradient-to-b from-radialCardStart via-radialCardMid to-radialCardEnd 
                                                    backdrop-blur-sm w-full h-auto rounded-3xl">
                                                    <div class="px-4 py-2 md:px-5 md:py-5">
                                                        <h4
                                                            class="text-[15px] md:text-lg font-bold text-white md:pb-[10px] line-clamp-3 min-h-[3.4em] md:min-h-[3.6em]">
                                                            {{ $trip->title }}
                                                        </h4>
                                                        <div
                                                            class="flex flex-col gap-x-1 py-[5px] md:py-[10px] gap-y-1 text-white text-[10px] md:text-[13px]">
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/time.svg') }}"
                                                                    alt="time" />
                                                                <p>{{ formatDate($trip->date_started) }} -
                                                                    {{ formatDate($trip->date_ended) }}</p>
                                                            </div>
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/location.svg') }}"
                                                                    alt="location" />
                                                                <p>{{ $trip->city }}</p>
                                                            </div>
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/person.svg') }}"
                                                                    alt="person" />
                                                                <p>10 - 20</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-white text-[10px] md:text-[13px]">
                                                            <p>{{ __('messages.start_from') }}</p>
                                                            <p class="font-bold text-sm md:text-[20px] text-secondary">
                                                                {{ formatIDR($trip->price) }} <span
                                                                    class="text-[13px] text-white font-normal">{{ __('messages.per_person') }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Private Trip -->
        <section>
            <div class="private-trip max-w-7xl mx-auto py-7 scroll-m-10">
                <div
                    class="flex flex-col gap-y-4 sm:gap-y-[20px] justify-center items-center px-6 md:px-7 lg:px-5 xl:px-0">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 text-center lg:leading-[60px]">
                        {{ __('messages.embark_private_trip') }}
                        <span class="font-semibold text-primary">{{ __('messages.private_tour') }}</span>
                    </h2>
                    <p class="pb-3 sm:pb-[20px] lg:pb-[40px] text-xs sm:text-base text-center">
                        {{ __('messages.private_trip_desc') }}
                    </p>
                    <div class="wrapper-accordion xl:gap-x-4">
                        @foreach ($privateTrips as $trip)
                            <a href="{{ route('destination_detail', $trip->slug) }}"
                                class="accordion rounded-[20px] overflow-hidden cursor-pointer">
                                <div class="card-container">
                                    <div class="image-layer">
                                        <img src="{{ Storage::url($trip->featured_photo) }}" alt="{{ $trip->title }}"
                                            loading="lazy" class="object-cover" />
                                        <div class="gradient-overlay"></div>
                                    </div>

                                    <div class="content-layer"
                                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 45%, rgba(52, 119, 246, 1) 120%);">
                                        <div class="tag font-bold text-[12px] text-primary-800 px-5">
                                            <span>Private Trip</span>
                                        </div>

                                        <div class="tag-arrow font-bold text-primary-800">
                                            <i class="fa-solid fa-arrow-right text-lg"></i>
                                        </div>

                                        <div class="card-content text-white px-3 py-7">
                                            <h4 class="text-lg md:text-2xl font-semibold mb-3">
                                                {{ $trip->title }}
                                            </h4>
                                            <div class="text-description text-xs mb-2 md:mb-1 md:text-base">
                                                {!! $trip->description !!}
                                            </div>
                                            <div
                                                class="description text-white text-lg sm:text-base lg:text-sm xl:text-base">
                                                <div class="flex flex-row items-center gap-x-1 sm:gap-x-2 mb-1 md:mb-3">
                                                    <i class="fa-solid fa-location-dot text-xs md:text-base"></i>
                                                    <p class="text-xs md:text-base font-normal">{{ $trip->city }}</p>
                                                </div>
                                                <div class="text-white text-[10px] md:text-[13px]">
                                                    <p>Start From</p>
                                                    <p class="font-bold text-sm md:text-[20px] text-secondary">
                                                        {{ formatIDR($trip->price) }} <span
                                                            class="text-[13px] text-white font-normal">/person</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a class="py-[20px] md:py-[50px]" href="{{ route('destination', ['type' => 'private-trip']) }}">
                        <p
                            class="bg-button-custom1 text-center py-2 px-5 sm:py-[10px] sm:px-10 w-40 md:w-52 rounded-[10px] text-xs md:text-base text-primary font-semibold hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                            See all
                        </p>
                    </a>
                </div>
            </div>
        </section>
        <!-- Our Services -->
        <section class="services">
            <div class="container mx-auto py-7 scroll-m-10">
                <div class="flex flex-col gap-y-4 lg:gap-y-5 justify-center items-center px-6 xl:px-0">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 text-center">
                        {{ __('messages.our_services_title') }} <span
                            class="font-semibold text-primary">{{ __('messages.go_beyond_travel') }}</span>
                    </h2>
                    <p class="pb-4 sm:pb-5 lg:pb-10 text-xs sm:text-base text-center">
                        {{ __('messages.services_subtitle') }}
                    </p>

                    <div class="swiper-services w-full">
                        <div class="swiper-wrapper xl:flex-col">
                            @php
                                $services = [
                                    [
                                        'image' => 'Medical-health.webp',
                                        // 'title' => 'Medical Health & Beauty', -- REPLACED
                                        'title_key' => 'messages.medical_title',
                                        // 'description' => '...', -- REPLACED
                                        'description_key' => 'messages.medical_desc',
                                        'imageClass' => 'xl:rounded-e-[270px]',
                                        'reverse' => false,
                                    ],
                                    [
                                        'image' => 'Recruitment.webp',
                                        // 'title' => 'Recruitment', -- REPLACED
                                        'title_key' => 'messages.recruitment_title',
                                        // 'description' => '...', -- REPLACED
                                        'description_key' => 'messages.recruitment_desc',
                                        'imageClass' => 'xl:rounded-s-[270px]',
                                        'reverse' => true,
                                    ],
                                    [
                                        'image' => 'Entertainment.webp',
                                        // 'title' => 'Entertainment', -- REPLACED
                                        'title_key' => 'messages.entertainment_title',
                                        // 'description' => '...', -- REPLACED
                                        'description_key' => 'messages.entertainment_desc',
                                        'imageClass' => 'xl:rounded-e-[270px]',
                                        'reverse' => false,
                                    ],
                                ];
                            @endphp
                            @foreach ($services as $service)
                                <div class="swiper-slide service">
                                    <div
                                        class="flex flex-col rounded-xl overflow-hidden border border-[#E0E0E0] xl:rounded-none xl:border-none {{ $service['reverse'] ? 'xl:flex-row-reverse' : 'xl:flex-row' }} items-center gap-y-3 xl:gap-x-14">
                                        <div class="w-full xl:w-3/5">
                                            {{-- Optimized responsive image with proper loading strategy --}}
                                            <picture>
                                                <!-- Modern format for browsers that support it -->
                                                <source
                                                    srcset="{{ asset('images/home/' . pathinfo($service['image'], PATHINFO_FILENAME) . '.webp') }}"
                                                    type="image/webp">
                                                <!-- Original format fallback -->
                                                <img src="{{ asset('images/home/' . $service['image']) }}"
                                                    alt="{{ Str::slug(__($service['title_key'])) }}"
                                                    class="w-full h-40 xl:h-[540px] xl:drop-shadow-xl object-cover {{ $service['imageClass'] }}"
                                                    {{ $loop->first ? 'fetchpriority="high" decoding="async"' : 'loading="lazy" decoding="async"' }}
                                                    width="600" height="540">
                                            </picture>
                                        </div>
                                        <div
                                            class="xl:w-2/5 gap-y-1 px-4 xl:px-0 xl:gap-y-[30px] {{ $service['reverse'] ? 'xl:pl-[130px]' : '' }} flex flex-col justify-center text-primary-800">
                                            <h1 class="text-lg xl:text-[45px] font-bold xl:leading-[60px]">
                                                @php
                                                    $title = __($service['title_key']);
                                                    $titleParts = explode(' & ', $title);
                                                @endphp
                                                {{ $titleParts[0] }} <br class="hidden xl:block">
                                                {{ isset($titleParts[1]) ? '& ' . $titleParts[1] : '' }}
                                            </h1>
                                            <p
                                                class="text-[10px] line-clamp-2 lg:line-clamp-none xl:text-sm font-normal xl:w-3/4 xl:text-justify leading-tight">
                                                {{ __($service['description_key']) }}
                                            </p>
                                            <div class="py-5 xl:pb-0 xl:py-[20px] flex justify-center xl:justify-start">
                                                <button
                                                    class="bg-white py-2 px-5 text-[10px] xl:text-sm md:py-[14px] md:px-[10px] w-40 md:w-52 rounded-[10px] border border-primary text-primary font-semibold transition-colors duration-200 hover:bg-primary-400 hover:text-white will-change-auto"
                                                    type="button">
                                                    {{ __('messages.see_all') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Us -->
        <section class="why-choose-us scroll-m-10">
            <div class="mx-auto max-w-7xl bg-white py-7 px-6 xl:px-0">
                <div class="flex flex-row items-center justify-center">
                    <!-- Left Content -->
                    <div class="w-full md:w-2/5 flex flex-col justify-center gap-y-4 lg:gap-y-[30px]">
                        <h2 class="text-2xl sm:text-4xl lg:text-[35px] font-bold text-gray-1 text-center sm:text-left">
                            {{ __('messages.reason_for') }} <br class="hidden sm:block">
                            <span class="text-primary">{{ __('messages.choosing_us') }}</span>
                        </h2>
                        <p
                            class="text-xs font-normal text-gray-3 text-justify sm:w-[90%] lg:w-4/5 leading-5 mb-4 sm:mb-6 lg:mb-8 xl:mb-14">
                            {{ __('messages.reason_desc') }}
                        </p>
                        <div
                            class="flex flex-row justify-center sm:justify-normal space-x-4 md:space-x-6 lg:space-x-8 text-[10px] lg:text-xs xl:text-normal text-primary font-semibold">
                            @foreach ([['icon' => 'backpack.svg', 'text' => 'messages.success_tour'], ['icon' => 'happy.svg', 'text' => 'messages.happy_clients'], ['icon' => 'years.svg', 'text' => 'messages.year_experience']] as $item)
                                <div
                                    class="flex flex-col space-y-2 items-center hover:scale-105 transition-transform duration-300">
                                    <img src="{{ asset('images/icon/' . $item['icon']) }}" alt="{{ __($item['text']) }}"
                                        class="w-9 lg:w-14" loading="lazy">
                                    <p>{{ __($item['text']) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Right Images -->
                    <div class="hidden md:w-3/5 relative md:flex justify-center pb-6">
                        <img src="{{ asset('images/home/WCU2.png') }}" alt="Feature Image 1"
                            class="rounded-full w-24 lg:w-28 xl:w-[135px] absolute bottom-0 left-0 lg:bottom-3 lg:left-5 xl:bottom-5 xl:left-14"
                            loading="lazy">
                        <img src="{{ asset('images/home/WCU1.png') }}" alt="Feature Image 2"
                            class="rounded-full w-80 lg:w-96 xl:w-[450px] drop-shadow-[25px_45px_45px_rgba(52,119,246,0.4)]"
                            loading="lazy">
                        <img src="{{ asset('images/home/WCU3.png') }}" alt="Feature Image 3"
                            class="rounded-full w-40 lg:w-48 xl:w-[225px] absolute top-0 -right-1 lg:top-1 lg:-right-2 xl:top-6 xl:right-0"
                            loading="lazy">
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Articles -->
        <section class="latest-articles py-10 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6 xl:px-0">
                <div class="text-center mb-10">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1">
                        {{ __('messages.latest_articles') }} <span
                            class="font-semibold text-primary">{{ __('messages.articles') }}</span>
                    </h2>
                    <p class="text-gray-500 mt-2">{{ __('messages.latest_subtitle') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($latestBlogs as $blog)
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-2 text-xs text-secondary mb-3">
                                        <span
                                            class="bg-blue-50 text-primary px-2 py-1 rounded-full">{{ $blog->category->name ?? 'Travel' }}</span>
                                        <span class="text-gray-400">{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <h3
                                        class="font-bold text-lg text-gray-800 mb-2 line-clamp-2 hover:text-primary transition-colors">
                                        {{ $blog->title }}
                                    </h3>
                                    <p class="text-gray-500 text-sm line-clamp-3 mb-4">
                                        {{ Str::limit(strip_tags($blog->content), 100) }}
                                    </p>
                                    <div class="flex items-center text-primary font-semibold text-sm">
                                        {{ __('messages.read_more') }} <i
                                            class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('blog.index') }}"
                        class="inline-block border border-primary text-primary px-8 py-3 rounded-xl font-semibold hover:bg-primary hover:text-white transition-all duration-300">
                        {{ __('messages.view_all_articles') }}
                    </a>
                </div>
            </div>
        </section>

        <!-- Our Partners -->
        <section class="our-partners">
            <div class="max-w-7xl mx-auto py-7">
                <div class="text-center mb-7">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 text-center">
                        Our <span class="font-semibold text-primary">Partners</span>
                    </h2>
                </div>

                <div class="flex flex-wrap items-center justify-evenly gap-10 px-4 md:px-0 lg:gap-8">
                    @foreach (include resource_path('views/front/data/partners.php') as $partner)
                        <div class="w-16 h-16 md:w-24 md:h-24 mb-2">
                            <img src="{{ asset('images/home/' . $partner['logo']) }}" alt="{{ $partner['name'] }} logo"
                                class="w-full h-full object-contain grayscale hover:grayscale-0 transition-all duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    @include('front.layout.footer')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const trigger = document.getElementById('dropdown-trigger');
                const options = document.getElementById('dropdown-options');
                const icon = document.getElementById('dropdown-icon');
                const selectedText = document.getElementById('selected-type');
                const hiddenInput = document.getElementById('destination_type_input');
                const optionItems = document.querySelectorAll('.option-item');

                // Toggle Dropdown
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    options.classList.toggle('hidden');
                    icon.style.transform = options.classList.contains('hidden') ? 'rotate(0deg)' :
                        'rotate(180deg)';
                });

                // Select Option
                optionItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        selectedText.textContent = value;
                        selectedText.classList.remove('text-gray-400');
                        selectedText.classList.add(
                            'text-white'); // Change to white or desired color when selected
                        hiddenInput.value = value;

                        // Close dropdown
                        options.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    });
                });

                // Close when clicking outside
                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !options.contains(e.target)) {
                        options.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                });
            });
        </script>
    @endpush
@endsection
