<header class="navbar-container">
    <nav class="navbar" id="navbar-home">
        <div
            class="nav-home flex flex-row-reverse xl:flex-row max-w-7xl mx-auto justify-between items-center p-2 overflow-hidden md:overflow-visible xl:pt-4 xl:px-0">
            <a href="{{ route('home') }}" class="cursor-pointer">
                <div class="w-28 md:w-full">
                    <img src="{{ asset('images/icon/Logo.svg') }}" alt="Logo-Acp" />
                </div>
            </a>
            <ul class="nav-menu hidden xl:flex flex-row gap-x-6 xl:gap-x-10 items-center">
                <li><a href="{{ route('home') }}"
                        class="{{ request()->is('home') ? 'is-active custom-border' : '' }}flex pb-[26px] pt-7 custom-border">Home</a>
                </li>
                <li class="relative">
                    <a href="#" class="relative flex flex-row items-baseline gap-x-2 pb-[26px] pt-7"
                        data-dropdown="travel">
                        Travel
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="bg-white w-48 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-travel">
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('destination', ['type' => 'open-trip']) }}"
                                class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-person-walking-luggage text-lg"></i>
                                Open Trip
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('destination', ['type' => 'private-trip']) }}"
                                class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-suitcase text-lg"></i>
                                Private Tour
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-briefcase text-lg"></i>
                                Various Package
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('hotel.index') }}" class=" flex pb-[26px] pt-7 custom-border">Hotel</a></li>
                <li class="relative">
                    <a href="#" class="flex flex-row items-center gap-x-2 pb-[26px] pt-7 "
                        data-dropdown="services">
                        Services
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="bg-white w-48 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-services">
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_medical') }}" class="text-sm flex items-center gap-x-3">
                                Medical Health & Beauty
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_recruitment') }}" class="text-sm flex items-center gap-x-3">
                                Recruitment
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_entertainment') }}" class="text-sm flex items-center gap-x-3">
                                Entertainment
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('about') }}" class="flex pb-[26px] pt-7 custom-border">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="flex pb-[26px] pt-7 custom-border">Contact Us</a></li>
            </ul>
            <div class="hidden xl:flex flex-row gap-x-[30px]">
                @guest
                    <div>
                        <a href="{{ route('login_register') }}"
                            class="border-[3px] border-primary px-10 py-2 h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary  transition-all ease-in-out duration-300">
                            Login
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('login_register') }}"
                            class="border-[3px] border-primary bg-primary px-10 py-2 h-10 rounded-lg text-white font-medium hover:bg-primary-400  transition-all ease-in-out duration-300">
                            Sign Up
                        </a>
                    </div>
                @endguest
                @auth('web')
                    <ul>
                        <li class="relative">
                            <a href="#" data-dropdown="profile-user" class="flex items-center gap-2">
                                @if (Auth::user()->photo)
                                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                        alt="{{ Auth::user()->name }}"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-primary">
                                @else
                                    <i class="fa-regular fa-circle-user text-4xl font-light text-primary"></i>
                                @endif
                            </a>
                            <ul class="hidden flex-col justify-center bg-white text-[#687176] shadow-xl border w-52 -left-16 absolute top-14 rounded-xl z-[1000] overflow-hidden"
                                id="dropdown-user-profile">
                                <!-- User Info -->
                                <li class="z-[1000] py-3 px-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b">
                                    <div class="flex items-center gap-3">
                                        @if (Auth::user()->photo)
                                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                                alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                                <i class="fa-solid fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div class="overflow-hidden">
                                            <p class="font-semibold text-gray-800 text-sm truncate">
                                                {{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </li>
                                <!-- My Bookings -->
                                <li class="z-[1000] hover:bg-gray-50 transition-colors">
                                    <a href="{{ route('profile.bookings') }}"
                                        class="text-sm flex items-center gap-x-3 py-3 px-4">
                                        <i class="fa-solid fa-ticket text-primary"></i>
                                        My Bookings
                                    </a>
                                </li>
                                <!-- Edit Profile -->
                                <li class="z-[1000] hover:bg-gray-50 transition-colors">
                                    <a href="{{ route('profile.edit') }}"
                                        class="text-sm flex items-center gap-x-3 py-3 px-4">
                                        <i class="fa-solid fa-gear text-primary"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <!-- Logout -->
                                <li class="z-[1000] border-t">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-sm flex items-center gap-x-3 py-3 px-4 w-full text-left hover:bg-red-50 text-red-600 transition-colors">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            </div>
            <div class="xl:hidden">
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box scale-75">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        {{-- Sidebar --}}
        <div
            class="sidebar-home flex flex-col justify-start items-start gap-y-5 pt-20 max-h-dvh w-screen bg-white overflow-y-auto">
            <div class="flex flex-row gap-x-3 px-6 py-4 border-b w-full">
                <div>
                    <a href="{{ route('login') }}"
                        class="border-[3px] border-primary px-6 py-2 h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary  transition-all ease-in-out duration-300">
                        Sign In
                    </a>
                </div>
                <div>
                    <a href="{{ route('register') }}"
                        class="bg-primary px-6 py-2 h-10 rounded-lg text-white font-medium hover:bg-primary-400  transition-all ease-in-out duration-300">
                        Sign Up
                    </a>
                </div>
            </div>
            <ul class="flex flex-col w-full px-2 gap-y-5 text-[#687176]">
                <li class="py-3 px-4">
                    <a href="{{ route('home') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-house text-xl"></i>
                        Home
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('destination', ['type' => 'open-trip']) }}"
                        class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-person-walking-luggage text-xl"></i>
                        Open Trip
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('destination', ['type' => 'private-trip']) }}"
                        class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-suitcase text-xl"></i>
                        Private Tour
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-briefcase text-xl"></i>
                        Various Package
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('hotel.index') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-hotel text-xl"></i>
                        Hotel
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('services_medical') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-heart text-xl"></i>
                        Medical Health & Beauty
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('services_recruitment') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-user-tie text-xl"></i>
                        Recruitment
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('services_entertainment') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                        Entertainment
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('about') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-circle-info text-xl"></i>
                        About Us
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="{{ route('contact') }}" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-address-book text-xl"></i>
                        Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="navbar-placeholder"></div>
</header>
