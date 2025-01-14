@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <div class="container mx-auto">
        <!-- Hero Section -->
        <section>
            <div class="hero max-w-7xl mx-auto pb-8">
                <div class="flex flex-col-reverse items-center lg:flex-row lg:justify-between md:px-7 lg:px-5 xl:px-0">
                    <div class="flex flex-col items-center gap-y-5 lg:items-start lg:gap-y-10 lg:pl-4">
                        <div class="flex flex-col items-center py-0 sm:gap-y-2 lg:gap-y-5 lg:py-4 lg:items-start">
                            <div class="text-2xl flex gap-x-2 md:text-4xl xl:text-5xl lg:block font-bold leading-[60px]">
                                <h1>Make Dreams a</h1>
                                <h1 class="text-primary">Destination</h1>
                            </div>
                            <p class="text-[12px] xs:text-[14px] sm:text-base text-[#4F4F4F]">
                                Make your dream trip to South Korea come true with <br />
                                unforgettable experiences from ACP Tour & Travel.
                            </p>
                        </div>
                        <button
                            class="bg-primary py-[10px] px-10 w-52 rounded-xl text-white border border-[#E0E0E0] font-semibold hover:bg-primary-400">
                            Discover Now
                        </button>
                    </div>
                    <img src="{{ asset('images/home/Hero_Image.png') }}" alt="Hero-Image"
                        class="hero-image h-auto sm:w-[450px] xl:w-[600px]" />
                </div>
            </div>
        </section>
        <!-- Popular Destination -->
        <section class="relative">
            <div class="popular-destination max-w-7xl mx-auto py-[28px]">
                <h6
                    class="flex justify-center md:gap-x-2 xl:gap-x-0 lg:block font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 pb-[20px] text-center">
                    Explore <span class="text-primary"> Destination </span>
                </h6>
                <p class="pb-[40px] text-center text-xs sm:text-sm lg:text-base">We have more than 100 destination you can
                    choose</p>
                <div class="swiper-container">
                    <div class="swiper-wrapper md:px-7 lg:px-5 xl:px-0">
                        @foreach ($popularDestinations as $destination)
                            <div class="swiper-slide card">
                                <div class="rounded-xl overflow-hidden relative flex flex-col cursor-pointer">
                                    <img src="{{ asset('uploads/' . $destination->featured_photo) }}" alt="featured-photo"
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
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-navigation">
                    <div class="swiper-button-prev" style="background-image: url('/images/icon/Prev.svg')"></div>
                    <div class="swiper-button-next" style="background-image: url('/images/icon/Next.svg')"></div>
                </div>
            </div>
        </section>
        {{-- Search --}}
        <section>
            <div class="max-w-7xl mx-auto py-[28px]">
                <div
                    class="flex flex-col gap-y-5 md:flex-row md:items-center md:justify-center md:gap-x-5 lg:gap-x-10 md:px-7 lg:px-5 xl:px-0">
                    <div class="w-full md:w-1/2 px-4 md:px-0 mx-auto h-[568]">
                        <div class="w-full flex flex-col items-center relative" id="image-search">
                            <img src="{{ asset('images/home/sectionSearch.png') }}" alt="Search"
                                class="rounded-lg w-full" />
                            <div
                                class="absolute bottom-6 w-[310px] md:w-[340px] lg:w-[432px] xl:w-[496px] px-2 md:px-4 xl:px-6 h-12 md:h-14 bg-gray-3 rounded-full border-[3px] border-gray-400 flex items-center">
                                <div class="w-full flex flex-row relative items-center justify-evenly xl:gap-x-2">
                                    <div class="flex flex-row items-center lg:gap-x-2 text-[#E0E0E0]">
                                        <i
                                            class="fa-solid fa-location-dot text-[10px] sm:text-xs lg:text-sm xl:text-base"></i>
                                        <select
                                            class="bg-transparent border-none outline-none text-[10px] md:text-xs lg:text-sm xl:text-base">
                                            <option class="hidden text-[8px] md:text-xs lg:text-sm xl:text-base"
                                                value="" disabled selected>
                                                Destination
                                            </option>
                                            <option
                                                class="bg-gray-1 text-white text-[10px] md:text-xs lg:text-sm xl:text-base">
                                                Bali
                                            </option>
                                            <option
                                                class="bg-gray-1 text-white text-[10px] md:text-xs lg:text-sm xl:text-base">
                                                Seoul
                                            </option>
                                        </select>
                                    </div>
                                    <div class="h-4 md:h-6 xl:h-8 w-px bg-gray-300"></div>

                                    <div class="flex flex-row items-center cursor-pointer pr-1 pl-1 gap-x-1 md:pr-2 lg:px-0 lg:gap-x-2 text-[#E0E0E0]"
                                        id="datepicker-container">
                                        <img src="{{ asset('images/icon/time.svg') }}" alt="date"
                                            class="md:w-3 md:h-3 lg:w-5 lg:h-5">
                                        <p id="datepicker-text" class="text-[10px] md:text-xs lg:text-sm xl:text-base">Date
                                        </p>
                                        <i class="fa-solid fa-chevron-down text-[10px] md:text-[8px] lg:text-[10px]"></i>
                                        <input type="text" id="datepicker" class="hidden">
                                    </div>
                                    <div class="h-4 md:h-6 xl:h-8 w-px bg-gray-300"></div>

                                    <div class="flex items-center pl-1 gap-x-1 md:px-2 lg:px-0 lg:gap-x-2 text-[#E0E0E0]">
                                        <img src="{{ asset('images/icon/hiking.svg') }}" alt="hiking">
                                        <select
                                            class="bg-transparent border-none outline-none text-[10px] md:text-xs lg:text-sm xl:text-base">
                                            <option class="hidden" value="" disabled selected>
                                                Type
                                            </option>
                                            <option
                                                class="bg-gray-1 text-white text-[10px] md:text-xs lg:text-sm xl:text-base">
                                                Bali
                                            </option>
                                            <option
                                                class="bg-gray-1 text-white text-[10px] md:text-xs lg:text-sm xl:text-base">
                                                Seoul
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="font-semibold text-[10px] sm:text-[11px] lg:text-sm text-gray-1 rounded-3xl bg-secondary py-2 px-3 md:py-1 md:px-2 lg:py-2 lg:px-4 hover:bg-yellow-300 transition-all ease-in-out duration-300">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-4 md:px-0 md:w-1/2 mx-auto">
                        <div class="flex flex-col gap-y-3 md:gap-y-[14px] lg:gap-y-[23px]">
                            <div class="flex flex-col gap-y-0 lg:gap-y-2 text-center md:text-start">
                                <h1 class="font-bold text-xl md:text-2xl xl:text-[35px] text-gray-1">
                                    One
                                    Click for <span class="text-primary">You</span></h1>
                                <p class="text-gray-3 text-xs xl:text-base">How it works?</p>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/date.svg') }}" alt="date"
                                    class="icon-container w-10 md:w-11 lg:w-[52px] h-auto">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">Set Your Date</h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">Choose the perfect date to
                                        start your
                                        unforgettable
                                        journey.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/flight.svg') }}" alt="date"
                                    class="icon-container w-10 md:w-11 lg:w-[52px]">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">Select Your
                                        Destination
                                    </h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">Pick stunning destinations
                                        that match
                                        your dream
                                        adventure.
                                    </p>
                                </div>
                            </div>
                            <div
                                class="step-item flex flex-row items-center gap-x-3 py-2 px-3 md:gap-x-5 xl:gap-x-10 rounded-2xl border border-[#E0E0E0] md:py-4 md:px-5 xl:py-9 xl:px-10 cursor-pointer">
                                <img src="{{ asset('images/icon/search.svg') }}" alt="date"
                                    class="icon-container w-10 md:w-11 lg:w-[52px]">
                                <div class="flex flex-col gap-y-1 lg:gap-y-2">
                                    <h3 class="font-semibold text-gray-1 text-xs md:text-sm xl:text-base">Choose Your Trip
                                        Type
                                    </h3>
                                    <p class="text-gray-1 text-[10px] xl:text-xs">From open trip, private
                                        trip, and
                                        various package, pick
                                        the trip that suits you best.
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
            <div class="open-trip max-w-7xl mx-auto py-[28px]">
                <div
                    class="flex flex-col gap-y-[20px] sm:gap-x-8 sm:grid sm:grid-cols-2 lg:grid-cols-4 md:px-7 lg:px-5 xl:px-0">
                    <div
                        class="lg:col-span-1 flex flex-col gap-y-2 lg:gap-y-[20px] justify-center items-center sm:items-start md:pl-4 lg:pl-0">
                        <h2
                            class="font-bold text-2xl block sm:flex sm:flex-col sm:gap-y-2 sm:text-4xl lg:text-[35px] text-center sm:text-left leading-[60px]">
                            Hop on Our <span class="font-semibold text-primary">Open Trip</span>
                        </h2>
                        <p class="pb-3 sm:pb-[20px] lg:pb-[40px] text-xs sm:text-base">We make exploring with
                            <br class="hidden sm:block"> trips anyone can join
                        </p>
                        <a href="#" class="">
                            <button
                                class="bg-white py-[10px] px-10 w-52 rounded-[10px] text-primary border border-primary font-semibold text-sm hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                                See More
                            </button>
                        </a>
                    </div>
                    <div class="lg:col-span-3 px-4 lg:px-0">
                        <div class="swiper-open-trip">
                            <div class="swiper-wrapper">
                                @foreach ($openTrips as $trip)
                                    <div class="swiper-slide card">
                                        <div class="rounded-[20px] overflow-hidden relative flex flex-col cursor-pointer">
                                            <div class="tag font-bold text-[12px] text-primary-800">
                                                <span>{{ $trip->type }}</span>
                                            </div>
                                            <img src="{{ asset('uploads/' . $trip->featured_photo) }}"
                                                alt="featured-photo" class="object-cover h-[420px] w-full" />
                                            <div
                                                class="w-full h-full absolute bottom-0 bg-gradient-to-b from-linearCardStart via-linearCardMid to-linearCardEnd">
                                                <div
                                                    class="background-transparent absolute bottom-0 border-t-2 border-white  bg-gradient-to-b from-radialCardStart via-radialCardMid to-radialCardEnd 
                                                    backdrop-blur-sm w-full">
                                                    <div class="p-5">
                                                        <h4 class="text-lg font-bold text-white pb-[10px]">
                                                            {{ $trip->title }}
                                                        </h4>
                                                        <div
                                                            class="flex flex-col gap-x-1 py-[10px] gap-y-1 text-white text-[13px]">
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/time.svg') }}" />
                                                                <p>{{ $trip->formatted_start_date }} -
                                                                    {{ $trip->formatted_end_date }}</p>
                                                            </div>
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/location.svg') }}" />
                                                                <p>{{ $trip->city }}</p>
                                                            </div>
                                                            <div class="flex flex-row gap-x-2">
                                                                <img src="{{ asset('images/icon/person.svg') }}" />
                                                                <p>10 - 20</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-white text-[13px]">
                                                            <p>Start From</p>
                                                            <p class="font-bold text-[20px] text-secondary">
                                                                Rp. {{ number_format($trip->price) }} <span
                                                                    class="text-[13px] text-white font-normal">/person</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Private Trip -->
        <section>
            <div class="private-trip max-w-7xl mx-auto py-[28px]">
                <div class="flex flex-col gap-y-[20px] justify-center items-center">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 text-center leading-[60px]">
                        Embark on Your Personalized
                        <span class="font-semibold text-primary">Private Trip</span>
                    </h2>
                    <p class="pb-3 sm:pb-[20px] lg:pb-[40px] text-xs sm:text-base">We create personalized journeys
                        tailored to your preferences
                    </p>
                    <div class="wrapper-accordion gap-x-4">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="accordion rounded-[20px] overflow-hidden cursor-pointer">
                                <div class="card-container">
                                    <div class="image-layer">
                                        <img src="{{ asset('images/home/NightCity.png') }}" alt=""
                                            class="object-cover" />
                                        <div class="gradient-overlay"></div>
                                    </div>

                                    <div class="content-layer">
                                        <div class="tag font-bold text-[12px] text-primary-800 px-5">
                                            <span>Private Trip</span>
                                        </div>

                                        <div class="tag-arrow font-bold text-primary-800">
                                            <i class="fa-solid fa-arrow-right text-lg"></i>
                                        </div>

                                        <div class="card-content text-white p-5">
                                            <h4 class="text-2xl font-semibold pb-[10px]">
                                                K-POP Fan Tour
                                            </h4>
                                            <p class="description">
                                                Visit stunning coastal views, fresh seafood markets, and cultural sites.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <a class="py-[50px]" href="#">
                        <button
                            class="bg-button-custom1 py-[10px] px-10 w-52 rounded-[10px] text-primary font-semibold text-sm hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                            See all
                        </button>
                    </a>
                </div>
            </div>
        </section>
        <!-- Our Services -->
        <section>
            <div class="services w-full mx-auto py-[28px]">
                <div class="flex flex-col gap-y-[20px] justify-center items-center">
                    <h2 class="font-bold text-2xl sm:text-4xl lg:text-[35px] text-gray-1 text-center leading-[60px]">
                        Our Services <span class="font-semibold text-primary">Go Beyond Travel</span>
                    </h2>
                    <p class="pb-3 sm:pb-[20px] lg:pb-[40px] text-xs sm:text-base">From entertainment and beauty to medical
                        trips and recruitment, we’ve got all your needs covered.
                    </p>
                    <div class="flex flex-col bg-primary-100">
                        <div class="flex flex-row items-start justify-center gap-x-[130px]">
                            <div class="w-[60%]">
                                <img src="{{ asset('images/home/medical-health.png') }}" alt="medical-health"
                                    class="rounded-e-[270px] h-[540px] w-full drop-shadow-xl">
                            </div>
                            <div
                                class="w-[40%] gap-y-[30px] pt-[60px] flex flex-col justify-center text-primary-800 leading-[60px]">
                                <h1 class="text-[45px] font-bold">Medical Health <br> & Beauty</h1>
                                <p class="text-xs font-normal text-justify w-[70%] leading-tight">Manjakan diri dengan
                                    layanan
                                    kesehatan dan
                                    kecantikan terbaik di
                                    Korea. Dapatkan akses ke
                                    perawatan medis modern dan pengalaman kecantikan premium dari ahli terpercaya.</p>
                                <a class="py-[20px]" href="#">
                                    <button
                                        class="bg-white py-[14px] px-[10px] w-52 rounded-[10px] border border-primary text-primary font-semibold text-sm hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                                        See all
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-row-reverse items-start justify-center gap-x-[130px]">
                            <div class="w-[60%]">
                                <img src="{{ asset('images/home/Recruitment.png') }}" alt="medical-health"
                                    class="rounded-s-[270px] h-[540px] w-full drop-shadow-xl">
                            </div>
                            <div
                                class="w-[40%] gap-y-[30px] pt-[60px] pl-[130px] flex flex-col justify-center text-primary-800 leading-[60px]">
                                <h1 class="text-[45px] font-bold">Job <br> Recruitment</h1>
                                <p class="text-xs font-normal text-justify w-[70%] leading-tight">Buka peluang karir Anda
                                    di
                                    Korea Selatan! Kami membantu Anda menemukan pekerjaan impian dengan proses mudah, mulai
                                    dari
                                    pencarian lowongan hingga pengurusan dokumen.</p>
                                <a class="py-[20px]" href="#">
                                    <button
                                        class="bg-white py-[14px] px-[10px] w-52 rounded-[10px] border border-primary text-primary font-semibold text-sm hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                                        See all
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="flex flex-row items-start justify-center gap-x-[130px]">
                            <div class="w-[60%]">
                                <img src="{{ asset('images/home/Entertainment.png') }}" alt="medical-health"
                                    class="rounded-e-[270px] h-[540px] w-full drop-shadow-xl">
                            </div>
                            <div
                                class="w-[40%] gap-y-[30px] pt-[60px] flex flex-col justify-center text-primary-800 leading-[60px]">
                                <h1 class="text-[45px] font-bold">Event <br> Entertainment</h1>
                                <p class="text-xs font-normal text-justify w-[70%] leading-tight">Manjakan diri dengan
                                    layanan
                                    kesehatan dan kecantikan terbaik di Korea. Dapatkan akses ke perawatan medis modern dan
                                    pengalaman kecantikan premium dari ahli terpercaya.</p>
                                <a class="py-[20px]" href="#">
                                    <button
                                        class="bg-white py-[14px] px-[10px] w-52 rounded-[10px] border border-primary text-primary font-semibold text-sm hover:bg-primary-400 hover:text-white transition-all ease-in-out duration-300">
                                        See all
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Us -->
        <section>
            <div class="why-choose-us mx-auto max-w-7xl bg-white py-[28px]">
                <div class="flex flex-row items-center justify-center">
                    <div class="w-[40%] gap-y-[30px] pt-[60px] flex flex-col justify-center leading-[60px]">
                        <h1 class="text-[35px] font-bold text-gray-1 text-justify">Reason for <br> <span
                                class="text-primary">Choosing
                                Us</span>
                        </h1>
                        <p class="text-xs font-normal text-gray-3 text-justify w-[80%] leading-tight">Anugrah Cahaya
                            Pelangi offers a safe and comfortable travel experience with professional tour guides. We
                            provide diverse travel destinations, comfortable transportation, and quality accommodations.
                            Easy booking, including visa processing, with transparent and competitive pricing.</p>
                        <div class="flex flex-row justify-evenly pt-8 gap-x-10">
                            <div class="flex flex-col gap-y-[6px] items-center">
                                <img src="{{ asset('images/icon/backpack.svg') }}" alt="backpack"
                                    class="w-[57px] h-[57px]" />
                                <p class="font-semibold text-primary">Success Tour</p>
                            </div>
                            <div class="flex flex-col gap-y-[6px] items-center">
                                <img src="{{ asset('images/icon/happy.svg') }}" alt="backpack"
                                    class="w-[57px] h-[57px]" />
                                <p class="font-semibold text-primary">Happy Clients</p>
                            </div>
                            <div class="flex flex-col gap-y-[6px] items-center">
                                <img src="{{ asset('images/icon/years.svg') }}" alt="backpack"
                                    class="w-[57px] h-[57px]" />
                                <p class="font-semibold text-primary">Year Experience</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-[60%] relative flex items-end justify-center py-6">
                        <img src="{{ asset('images/home/WCU2.png') }}" alt="w1"
                            class="rounded-full h-[135px] w-[135px] absolute bottom-4 left-16">
                        <img src="{{ asset('images/home/WCU1.png') }}" alt="w2"
                            class="rounded-full h-[450px] w-[450px] drop-shadow-[25px_45px_45px_rgba(52,119,246,0.4)]">
                        <img src="{{ asset('images/home/WCU3.png') }}" alt="w3"
                            class="rounded-full h-[225px] w-[225px] absolute top-6 right-0">
                    </div>
                </div>
            </div>
        </section>
        <!-- Our Partners -->
        <section class="our-partners">
            {{-- <div class="max-w-7xl mx-auto py-[100px]">
                <div class="flex flex-col gap-y-8">
                    <div class="scroll transition-all ease-in-out duration-300">
                        <div class="item-logo">
                            @for ($i = 0; $i < 6; $i++)
                                <img src="{{ asset('images/home/Partner.png') }}" alt="partner"
                                    class="w-[230px] h-[100px] object-contain rounded-xl" />
                            @endfor
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
    </div>
    @include('front.layout.footer')
@endsection
