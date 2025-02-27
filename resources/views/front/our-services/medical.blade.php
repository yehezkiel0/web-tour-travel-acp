@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto w-full py-8">
        <nav class="flex-col mb-7 space-y-4 max-w-7xl mx-auto px-4" aria-label="Breadcrumb">
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
                        <a href="#" class="ms-1 font-medium text-primary md:ms-2">Medical Health and Beauty</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="bg-[#DFE9FF] w-full">
            <div class="container mx-auto">
                <div class="flex items-center max-w-7xl mx-auto space-x-24">
                    <figure class="w-[395px] max-h-[391px]">
                        <img src="{{ asset('images/services/service-medical-hero.png') }}" alt="medical-hero">
                    </figure>
                    <div class="text-center max-w-lg">
                        <h1 class="text-4xl font-medium text-primary-700 mb-4">Medical & Beauty Care</h1>
                        <p class="text-gray-2 text-sm mb-6">Anugerah Cahaya Pelangi presents The Best Medical & Beauty Care
                            for You with professional, safe, and technology-driven services, ensuring optimal health and
                            beauty in one integrated solution.</p>
                        <a href="#">
                            <button
                                class="bg-primary py-2 px-5 text-xs sm:py-[10px] sm:px-10 w-40 md:w-52 md:text-base rounded-[10px] text-white border border-primary font-semibold hover:bg-primary-400 transition-all ease-in-out duration-300">
                                Contact Us
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto py-16 px-8 md:px-6 lg:px-14 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="w-full md:w-1/2 space-y-7">
                <div class="space-y-7">
                    <h2 class="text-3xl font-semibold text-primary-700 leading-tight">
                        We Provide Special Care for Your Health & Well-Being
                    </h2>
                    <p class="text-gray-700">
                        Your health is your greatest asset. Our medical services focus on early detection, expert
                        consultation, and continuous care to help you maintain a healthy and balanced life.
                    </p>
                </div>
                <div class="flex flex-col gap-y-6">
                    @foreach ($features as $feature)
                        <div class="flex gap-7">
                            <div class="flex-shrink-0">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M34.3333 16.1429V17.6762C34.3313 21.2702 33.1675 24.7673 31.0156 27.6459C28.8636 30.5245 25.8388 32.6303 22.3923 33.6494C18.9457 34.6684 15.2621 34.546 11.8908 33.3005C8.51947 32.055 5.64109 29.753 3.68493 26.738C1.72878 23.7229 0.799652 20.1563 1.03613 16.5701C1.2726 12.9838 2.66201 9.57008 4.99713 6.83799C7.33225 4.1059 10.488 2.20184 13.9936 1.40978C17.4993 0.617723 21.1671 0.980101 24.45 2.44287M34.3337 4.34277L17.667 21.0261L12.667 16.0261"
                                        stroke="#3477F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-1">{{ $feature['title'] }}</h3>
                                <p class="text-gray-2">{{ $feature['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full md:w-1/2 relative">
                <img src="{{ asset('images/services/service-medical-1.png') }}" alt="Medical Professional"
                    class="w-full h-auto">
            </div>
        </div>
        <div class="bg-[#DFE9FF] w-full py-10">
            <div class="flex flex-col md:flex-row items-center justify-center gap-14 max-w-4xl mx-auto relative">
                <div
                    class="absolute bg-[#2554AF] w-full h-full md:h-[calc(100%-80px)] flex items-center justify-center z-0">
                </div>
                <figure class="w-[360px] max-h-[450px] z-10">
                    <img src="{{ asset('images/services/service-medical-2.png') }}" alt="medical-hero"
                        class="w-full object-cover">
                </figure>
                <div class="text-white max-w-sm z-10">
                    <h1 class="text-3xl font-medium mb-4">It’s your gateway to premium medical and beauty care in Korea.
                    </h1>
                    <p class="text-sm font-normal mb-6">We connect you with top specialists, combining advanced treatments
                        with a
                        personalized touch. Every experience is seamless, safe, and designed around your needs. With modern
                        facilities and the latest technology, we make world-class healthcare and beauty treatments
                        effortless—so you can focus on looking and feeling your best.</p>
                </div>
            </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
