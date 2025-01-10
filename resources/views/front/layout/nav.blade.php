<div class="navbar-container">
    <nav class="navbar" id="navbar-home">
        <div
            class="nav-home flex flex-row-reverse lg:flex-row max-w-7xl mx-auto justify-between items-center px-4 pt-4 lg:px-0">
            <a href="#" class="cursor-pointer">
                <img src="{{ asset('images/icon/Logo.svg') }}" alt="Logo-Acp" />
            </a>
            <ul class="hidden lg:flex flex-row gap-x-6 lg:gap-x-10">
                <li><a href="#" class="flex pb-[26px] pt-7 custom-border">Home</a>
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
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-person-walking-luggage text-lg"></i>
                                Open Trip
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
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
                <li><a href="#" class=" flex pb-[26px] pt-7 custom-border">Hotel</a></li>
                <li class="relative">
                    <a href="#" class="flex flex-row items-center gap-x-2 pb-[26px] pt-7 "
                        data-dropdown="services">
                        Services
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="bg-white w-48 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-services">
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                Medical Health & Beauty
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                Recruitment
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                Entertainment
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#" class="flex pb-[26px] pt-7 custom-border">About Us</a></li>
                <li><a href="#" class="flex pb-[26px] pt-7 custom-border">Contact Us</a></li>
            </ul>
            <div class="hidden xl:flex flex-row gap-x-[30px]">
                @guest
                    <div>
                        <a href="{{ route('login_register') }}">
                            <button
                                class="border-[3px] border-primary w-[70px] xl:w-[122px] h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary  transition-all ease-in-out duration-300">
                                Login
                            </button>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('login_register') }}">
                            <button
                                class="bg-primary w-[70px] xl:w-[122px] h-10 rounded-lg text-white font-medium hover:bg-primary-400  transition-all ease-in-out duration-300">
                                Sign Up
                            </button>
                        </a>
                    </div>
                @endguest
                @auth('web')
                    <ul>
                        <li class="relative">
                            <a href="#" data-dropdown="profile-user">
                                <i class="fa-regular fa-circle-user text-4xl font-light text-primary"></i>
                            </a>
                            <ul class="flex flex-col justify-center bg-white text-[#687176] shadow-lg border w-40 -left-4 absolute top-14 rounded-md z-[1000]"
                                id="dropdown-user-profile">
                                <li class="z-[1000] py-3 px-4">
                                    <a href="#" class="text-sm flex items-center gap-x-3">
                                        <i class="fa-solid fa-gear"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="z-[1000] px-4">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm flex items-center gap-x-3">
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
            <div class="lg:hidden">
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box ">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>


        {{-- Sidebar --}}
        <div
            class="sidebar-home flex flex-col justify-start items-start gap-y-5 pt-20 h-screen w-screen bg-white overflow-y-auto">
            <div class="flex flex-row gap-x-3 px-6 py-4 border-b w-full">
                <div>
                    <button
                        class="border-[3px] border-primary w-[70px] h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary  transition-all ease-in-out duration-300">
                        Login
                    </button>
                </div>
                <div>
                    <button
                        class="bg-primary w-[100px] h-10 rounded-lg text-white font-medium hover:bg-primary-400  transition-all ease-in-out duration-300">
                        Sign Up
                    </button>
                </div>
            </div>
            <ul class="flex flex-col w-full px-2 gap-y-5 text-[#687176]">
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-house text-xl"></i>
                        Home
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-person-walking-luggage text-xl"></i>
                        Open Trip
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
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
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-heart text-xl"></i>
                        Medical Health & Beauty
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-user-tie text-xl"></i>
                        Recruitment
                    </a>
                </li>
                <li class="py-3 px-4">
                    <a href="#" class="text-lg flex items-center gap-x-5">
                        <i class="fa-solid fa-champagne-glasses text-xl"></i>
                        Entertainment
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="navbar-placeholder"></div>
</div>
