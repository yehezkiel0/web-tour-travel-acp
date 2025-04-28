@extends('front.layout.app')
@section('title', 'About Us - ACP Tours & Travel')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto">
        <div class="relative py-14 md:py-20 overflow-hidden bg-blue-100">
            <div class="hidden md:block absolute inset-0 z-0">
                <img src="{{ asset('images/home/about-2.jpg') }}" alt="hero-section-about"
                    class="object-cover w-full h-auto opacity-20">
            </div>
            <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 z-10 text-center">
                <h1 class="text-2xl md:text-5xl font-bold text-primary mb-4 md:mb-6">About Us</h1>
                <p class="text-base md:text-xl font-semibold text-primary-700 italic mb-6 md:mb-8">“Fulfilling Your Dreams
                    with
                    Complete &
                    Integrated
                    Business Solutions”</p>
                <p class="text-sm md:text-lg text-gray-2 max-w-3xl mx-auto">Anugerah Cahaya Pelangi is your trusted
                    partner, delivering
                    comprehensive
                    solutions that
                    empower your
                    business and personal goals. We believe every dream deserves to be realized through innovative,
                    dedicated service. Since our inception, we've proudly supported thousands of clients, especially by
                    bridging opportunities between Indonesia and South Korea, with our proven premium services.</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto py-14 md:py-20">
            <div class="grid grid-cols-1 px-8 md:px-0 md:grid-cols-2 gap-6 md:gap-12">
                <div class="rounded-2xl stroke-1 stroke-[#E5E7EB] drop-shadow-md bg-white p-8">
                    <div class="mb-4 md:mb-6">
                        <svg class="w-10 h-10 md:w-16 md:h-16" viewBox="0 0 64 64" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 32C0 14.3269 14.3269 0 32 0C49.6731 0 64 14.3269 64 32C64 49.6731 49.6731 64 32 64C14.3269 64 0 49.6731 0 32Z"
                                fill="#DBEAFE" />
                            <path
                                d="M0 32C0 14.3269 14.3269 0 32 0C49.6731 0 64 14.3269 64 32C64 49.6731 49.6731 64 32 64C14.3269 64 0 49.6731 0 32Z"
                                stroke="#E5E7EB" />
                            <g clip-path="url(#clip0_7909_6742)">
                                <path
                                    d="M31.9998 21.5C28.2123 21.5 25.1795 23.225 22.9717 25.2781C20.7779 27.3125 19.3107 29.75 18.617 31.4234C18.4623 31.7937 18.4623 32.2062 18.617 32.5766C19.3107 34.25 20.7779 36.6875 22.9717 38.7219C25.1795 40.775 28.2123 42.5 31.9998 42.5C35.7873 42.5 38.8201 40.775 41.0279 38.7219C43.2217 36.6828 44.6889 34.25 45.3873 32.5766C45.542 32.2062 45.542 31.7937 45.3873 31.4234C44.6889 29.75 43.2217 27.3125 41.0279 25.2781C38.8201 23.225 35.7873 21.5 31.9998 21.5ZM25.2498 32C25.2498 30.2098 25.961 28.4929 27.2268 27.227C28.4927 25.9612 30.2096 25.25 31.9998 25.25C33.79 25.25 35.5069 25.9612 36.7728 27.227C38.0386 28.4929 38.7498 30.2098 38.7498 32C38.7498 33.7902 38.0386 35.5071 36.7728 36.773C35.5069 38.0388 33.79 38.75 31.9998 38.75C30.2096 38.75 28.4927 38.0388 27.2268 36.773C25.961 35.5071 25.2498 33.7902 25.2498 32ZM31.9998 29C31.9998 30.6547 30.6545 32 28.9998 32C28.667 32 28.3482 31.9437 28.0482 31.8453C27.7904 31.7609 27.4904 31.9203 27.4998 32.1922C27.5139 32.5156 27.5607 32.8391 27.6498 33.1625C28.292 35.5625 30.7623 36.9875 33.1623 36.3453C35.5623 35.7031 36.9873 33.2328 36.3451 30.8328C35.8248 28.8875 34.1045 27.5797 32.192 27.5C31.9201 27.4906 31.7607 27.7859 31.8451 28.0484C31.9436 28.3484 31.9998 28.6672 31.9998 29Z"
                                    fill="#3477F6" />
                            </g>
                            <defs>
                                <clipPath id="clip0_7909_6742">
                                    <rect width="27" height="24" fill="white" transform="translate(18.5 20)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <h4 class="text-lg md:text-2xl font-bold text-gray-1 mb-2 md:mb-4">Our Vision</h4>
                    <p class="text-gray-2 text-xs md:text-base">To create a better world by inspiring positive change
                        through innovative and
                        reliable business
                        solutions in South Korea.</p>
                </div>
                <div class="rounded-2xl stroke-1 stroke-[#E5E7EB] drop-shadow-md bg-white p-8">
                    <div class="mb-4 md:mb-6">
                        <svg class="w-10 h-10 md:w-16 md:h-16" viewBox="0 0 64 64" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 32C0 14.3269 14.3269 0 32 0C49.6731 0 64 14.3269 64 32C64 49.6731 49.6731 64 32 64C14.3269 64 0 49.6731 0 32Z"
                                fill="#DBEAFE" />
                            <path
                                d="M0 32C0 14.3269 14.3269 0 32 0C49.6731 0 64 14.3269 64 32C64 49.6731 49.6731 64 32 64C14.3269 64 0 49.6731 0 32Z"
                                stroke="#E5E7EB" />
                            <g clip-path="url(#clip0_7909_6752)">
                                <path
                                    d="M27.3407 38.0422L25.8922 36.5938C25.4938 36.1953 25.3532 35.6187 25.5313 35.0844C25.6719 34.6672 25.8594 34.1234 26.0844 33.5H21.125C20.7219 33.5 20.3469 33.2844 20.1454 32.9328C19.9438 32.5812 19.9485 32.15 20.1547 31.8031L22.6157 27.6547C23.225 26.6281 24.3266 26 25.5172 26H29.375C29.4875 25.8125 29.6 25.6391 29.7125 25.4703C33.5516 19.8078 39.2704 19.6203 42.6829 20.2484C43.2266 20.3469 43.6485 20.7734 43.7516 21.3172C44.3797 24.7344 44.1875 30.4484 38.5297 34.2875C38.3657 34.4 38.1875 34.5125 38 34.625V38.4828C38 39.6734 37.3719 40.7797 36.3454 41.3844L32.1969 43.8453C31.85 44.0516 31.4188 44.0562 31.0672 43.8547C30.7157 43.6531 30.5 43.2828 30.5 42.875V37.85C29.8391 38.0797 29.2625 38.2672 28.8266 38.4078C28.3016 38.5766 27.7297 38.4312 27.336 38.0422H27.3407ZM38 27.875C38.4973 27.875 38.9742 27.6775 39.3259 27.3258C39.6775 26.9742 39.875 26.4973 39.875 26C39.875 25.5027 39.6775 25.0258 39.3259 24.6742C38.9742 24.3225 38.4973 24.125 38 24.125C37.5028 24.125 37.0259 24.3225 36.6742 24.6742C36.3226 25.0258 36.125 25.5027 36.125 26C36.125 26.4973 36.3226 26.9742 36.6742 27.3258C37.0259 27.6775 37.5028 27.875 38 27.875Z"
                                    fill="#3477F6" />
                            </g>
                            <defs>
                                <clipPath id="clip0_7909_6752">
                                    <rect width="24" height="24" fill="white" transform="translate(20 20)" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <h4 class="text-lg md:text-2xl font-bold text-gray-1 mb-2 md:mb-4">Our Mision</h4>
                    <p class="text-gray-2 text-xs md:text-base">To provide integrated, professional solutions across various
                        sectors while
                        embracing innovation and building lasting partnerships with our clients.</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col-reverse md:flex-row items-center gap-8 md:gap-10">
                <div class="w-full md:w-1/2 pr-0 md:pr-20 md:mb-0">
                    <h2 class="text-3xl md:text-5xl text-center md:text-left font-semibold text-primary mb-3 md:mb-5">Our
                        Business
                        Lines</h2>
                    <p class="text-base md:text-xl text-center md:text-left text-gray-2 mb-8 md:mb-10">
                        We offer a wide range of services tailored to meet your diverse needs:
                    </p>

                    <div class="space-y-3 px-6 md:px-0">
                        <a href="{{ route('destination') }}"
                            class="business-line-item bg-primary text-white rounded-xl flex justify-between items-center px-4 py-3 md:px-6 md:py-4 border-[0.5px] border-primary-800 cursor-pointer hover:bg-primary-400 hover:scale-105 transition-all duration-300">
                            <span class="text-xs md:text-base">Tour and Travel</span>
                            <span class="arrow-icon transform transition-transform duration-300"><svg
                                    class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></span>
                        </a>

                        <a href="{{ route('services_medical') }}"
                            class="business-line-item bg-primary text-white rounded-xl flex justify-between items-center px-4 py-3 md:px-6 md:py-4 border-[0.5px] border-primary-800 cursor-pointer hover:bg-primary-400 hover:scale-105 transition-all duration-300">
                            <span class="text-xs md:text-base">Health & Beauty</span>
                            <span class="arrow-icon transform transition-transform duration-300"><svg
                                    class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('services_recruitment') }}"
                            class="business-line-item bg-primary text-white rounded-xl flex justify-between items-center px-4 py-3 md:px-6 md:py-4 border-[0.5px] border-primary-800 cursor-pointer hover:bg-primary-400 hover:scale-105 transition-all duration-300">
                            <span class="text-xs md:text-base">Recruitment</span>
                            <span class="arrow-icon transform transition-transform duration-300"><svg
                                    class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></span>
                        </a>

                        <a href="{{ route('services_entertainment') }}"
                            class="business-line-item bg-primary text-white rounded-xl flex justify-between items-center px-4 py-3 md:px-6 md:py-4 border-[0.5px] border-primary-800 cursor-pointer hover:bg-primary-400 hover:scale-105 transition-all duration-300">
                            <span class="text-xs md:text-base">Entertainment</span>
                            <span class="arrow-icon transform transition-transform duration-300"><svg
                                    class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg></span>
                        </a>
                    </div>
                </div>

                <!-- Right Content with Image -->
                <div class="w-4/5 md:w-1/2 relative">
                    <div class="p-4 max-w-full mx-auto">
                        <img src="{{ asset('images/home/about-1.png') }}" alt="Business professionals" />
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#F9FAFB] py-14 md:py-20">
            <div class="max-w-7xl mx-auto">
                <div class="text-center space-y-3 mb-8 md:mb-16">
                    <h2 class="text-2xl md:text-4xl font-semibold text-primary">Our Core Values</h2>
                    <p class="text-gray-2 text-xs md:text-base">The principles that guide everything we do</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5 px-4 md:px-0">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 md:mb-6">
                            <svg class="w-14 h-14 md:w-16 md:h-16" viewBox="0 0 65 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    fill="#DBEAFE" />
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    stroke="#E5E7EB" />
                                <g clip-path="url(#clip0_7909_6807)">
                                    <path
                                        d="M34.3548 20.8438C34.1064 20.3281 33.5814 20 33.0048 20C32.4282 20 31.9079 20.3281 31.6548 20.8438L28.6407 27.0453L21.9095 28.0391C21.347 28.1234 20.8782 28.5172 20.7048 29.0562C20.5314 29.5953 20.672 30.1906 21.0751 30.5891L25.9595 35.4219L24.8064 42.2516C24.7126 42.8141 24.947 43.3859 25.411 43.7188C25.8751 44.0516 26.4892 44.0938 26.9954 43.8266L33.0095 40.6156L39.0235 43.8266C39.5298 44.0938 40.1439 44.0562 40.6079 43.7188C41.072 43.3813 41.3064 42.8141 41.2126 42.2516L40.0548 35.4219L44.9392 30.5891C45.3423 30.1906 45.4876 29.5953 45.3095 29.0562C45.1314 28.5172 44.6673 28.1234 44.1048 28.0391L37.3689 27.0453L34.3548 20.8438Z"
                                        fill="#3477F6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_7909_6807">
                                        <rect width="27" height="24" fill="white"
                                            transform="translate(19.5 20)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <h4 class="text-base md:text-xl font-semibold text-gray-1 mb-2.5">Experience</h4>
                        <p class="text-gray-2 text-xs md:text-base">Our experts deliver top-quality services.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 md:mb-6">
                            <svg class="w-14 h-14 md:w-16 md:h-16" viewBox="0 0 65 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    fill="#DBEAFE" />
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    stroke="#E5E7EB" />
                                <path
                                    d="M36.25 38C36.7 36.5047 37.6328 35.2297 38.5563 33.9594C38.8 33.6266 39.0438 33.2937 39.2781 32.9562C40.2063 31.6203 40.75 30.0031 40.75 28.2547C40.75 23.6938 37.0562 20 32.5 20C27.9438 20 24.25 23.6938 24.25 28.25C24.25 29.9984 24.7938 31.6203 25.7219 32.9516C25.9563 33.2891 26.2 33.6219 26.4437 33.9547C27.3719 35.225 28.3047 36.5047 28.75 37.9953H36.25V38ZM32.5 44C34.5719 44 36.25 42.3219 36.25 40.25V39.5H28.75V40.25C28.75 42.3219 30.4281 44 32.5 44ZM28.75 28.25C28.75 28.6625 28.4125 29 28 29C27.5875 29 27.25 28.6625 27.25 28.25C27.25 25.3484 29.5984 23 32.5 23C32.9125 23 33.25 23.3375 33.25 23.75C33.25 24.1625 32.9125 24.5 32.5 24.5C30.4281 24.5 28.75 26.1781 28.75 28.25Z"
                                    fill="#3477F6" />
                            </svg>
                        </div>
                        <h4 class="text-base md:text-xl font-semibold text-gray-1 mb-2.5">Innovation</h4>
                        <p class="text-gray-2 text-xs md:text-base">We leverage trends for unique interactions.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 md:mb-6">
                            <svg class="w-14 h-14 md:w-16 md:h-16" viewBox="0 0 65 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    fill="#DBEAFE" />
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    stroke="#E5E7EB" />
                                <g clip-path="url(#clip0_7909_6825)">
                                    <path
                                        d="M24.25 20C25.2446 20 26.1984 20.3951 26.9017 21.0983C27.6049 21.8016 28 22.7554 28 23.75C28 24.7446 27.6049 25.6984 26.9017 26.4017C26.1984 27.1049 25.2446 27.5 24.25 27.5C23.2554 27.5 22.3016 27.1049 21.5983 26.4017C20.8951 25.6984 20.5 24.7446 20.5 23.75C20.5 22.7554 20.8951 21.8016 21.5983 21.0983C22.3016 20.3951 23.2554 20 24.25 20ZM41.5 20C42.4946 20 43.4484 20.3951 44.1516 21.0983C44.8549 21.8016 45.25 22.7554 45.25 23.75C45.25 24.7446 44.8549 25.6984 44.1516 26.4017C43.4484 27.1049 42.4946 27.5 41.5 27.5C40.5054 27.5 39.5516 27.1049 38.8484 26.4017C38.1451 25.6984 37.75 24.7446 37.75 23.75C37.75 22.7554 38.1451 21.8016 38.8484 21.0983C39.5516 20.3951 40.5054 20 41.5 20ZM17.5 34.0016C17.5 31.2406 19.7406 29 22.5016 29H24.5031C25.2484 29 25.9563 29.1641 26.5938 29.4547C26.5328 29.7922 26.5047 30.1438 26.5047 30.5C26.5047 32.2906 27.2922 33.8984 28.5344 35C28.525 35 28.5156 35 28.5016 35H18.4984C17.95 35 17.5 34.55 17.5 34.0016ZM36.4984 35C36.4891 35 36.4797 35 36.4656 35C37.7125 33.8984 38.4953 32.2906 38.4953 30.5C38.4953 30.1438 38.4625 29.7969 38.4062 29.4547C39.0438 29.1594 39.7516 29 40.4969 29H42.4984C45.2594 29 47.5 31.2406 47.5 34.0016C47.5 34.5547 47.05 35 46.5016 35H36.4984ZM28 30.5C28 29.3065 28.4741 28.1619 29.318 27.318C30.1619 26.4741 31.3065 26 32.5 26C33.6935 26 34.8381 26.4741 35.682 27.318C36.5259 28.1619 37 29.3065 37 30.5C37 31.6935 36.5259 32.8381 35.682 33.682C34.8381 34.5259 33.6935 35 32.5 35C31.3065 35 30.1619 34.5259 29.318 33.682C28.4741 32.8381 28 31.6935 28 30.5ZM23.5 42.7484C23.5 39.2984 26.2984 36.5 29.7484 36.5H35.2516C38.7016 36.5 41.5 39.2984 41.5 42.7484C41.5 43.4375 40.9422 44 40.2484 44H24.7516C24.0625 44 23.5 43.4422 23.5 42.7484Z"
                                        fill="#3477F6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_7909_6825">
                                        <rect width="30" height="24" fill="white"
                                            transform="translate(17.5 20)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <h4 class="text-base md:text-xl font-semibold text-gray-1 mb-2.5">Integrated</h4>
                        <p class="text-gray-2 text-xs md:text-base">Our approach offers an
                            all-in-one experience.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 md:mb-6">
                            <svg class="w-14 h-14 md:w-16 md:h-16" viewBox="0 0 65 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    fill="#DBEAFE" />
                                <path
                                    d="M0.5 32C0.5 14.3269 14.8269 0 32.5 0C50.1731 0 64.5 14.3269 64.5 32C64.5 49.6731 50.1731 64 32.5 64C14.8269 64 0.5 49.6731 0.5 32Z"
                                    stroke="#E5E7EB" />
                                <g clip-path="url(#clip0_7909_6834)">
                                    <path
                                        d="M22.7312 34.0813L31.2016 41.9891C31.5531 42.3172 32.0172 42.5 32.5 42.5C32.9828 42.5 33.4469 42.3172 33.7984 41.9891L42.2687 34.0813C43.6938 32.7547 44.5 30.8938 44.5 28.9484V28.6766C44.5 25.4 42.1328 22.6063 38.9031 22.0672C36.7656 21.7109 34.5906 22.4094 33.0625 23.9375L32.5 24.5L31.9375 23.9375C30.4094 22.4094 28.2344 21.7109 26.0969 22.0672C22.8672 22.6063 20.5 25.4 20.5 28.6766V28.9484C20.5 30.8938 21.3062 32.7547 22.7312 34.0813Z"
                                        fill="#3477F6" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_7909_6834">
                                        <rect width="24" height="24" fill="white"
                                            transform="translate(20.5 20)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <h4 class="text-base md:text-xl font-semibold text-gray-1 mb-2.5">Satisfaction</h4>
                        <p class="text-gray-2 text-xs md:text-base">Your trust drives us, reflected in our testimonials.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-4 mb-14 md:mb-20">
            <div class="text-center mb-5">
                <h2 class="text-2xl md:text-4xl font-semibold text-primary md:mb-3">Our Gallery</h2>
                <p class="text-gray-2 text-xs md:text-base">see our latest updates</p>
            </div>
            <div class="pb-10 relative">
                <div class="swiper-about-us swiper-container relative px-4 md:px-0">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="swiper-slide">
                                <img src="{{ asset('images/home/Diamond-Beach.png') }}"
                                    class="w-full h-56 md:h-[398px] object-cover" alt="Gallery Image" />
                            </div>
                        @endfor
                    </div>
                    <div
                        class="swiper-navigation absolute top-1/2 transform -translate-y-1/2 w-full flex justify-between z-10 pointer-events-none">
                        <div class="swiper-button-prev pointer-events-auto cursor-pointer">
                            <div class="rounded-full w-10 h-10 bg-white flex items-center justify-center">
                                <i class="fa-solid fa-arrow-left"></i>
                            </div>
                        </div>
                        <div class="swiper-button-next pointer-events-auto cursor-pointer">
                            <div class="rounded-full w-10 h-10 bg-white flex items-center justify-center">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const businessLineItems = document.querySelectorAll('.business-line-item');

        businessLineItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                const arrow = this.querySelector('.arrow-icon');
                arrow.classList.add('translate-x-1');
            });

            item.addEventListener('mouseleave', function() {
                const arrow = this.querySelector('.arrow-icon');
                arrow.classList.remove('translate-x-1');
            });
        });
    });
</script>
