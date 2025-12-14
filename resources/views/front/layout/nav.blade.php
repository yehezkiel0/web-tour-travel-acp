<header class="navbar-container sticky top-0 z-[2000] bg-white transition-all duration-300 shadow-sm">
    <nav class="navbar" id="navbar-home">
        <div
            class="nav-home flex flex-row-reverse xl:flex-row max-w-7xl mx-auto justify-between items-center p-2 xl:pt-4 xl:px-0">
            <a href="{{ route('home') }}" class="cursor-pointer">
                <div class="w-28 md:w-full">
                    <img src="{{ asset('images/icon/Logo.svg') }}" alt="Logo-Acp" />
                </div>
            </a>
            <ul class="nav-menu hidden xl:flex flex-row gap-x-6 xl:gap-x-8 items-center">
                <li><a href="{{ route('home') }}"
                        class="{{ request()->is('home') ? 'is-active custom-border' : '' }}flex pb-[26px] pt-7 custom-border">{{ __('messages.home') }}</a>
                </li>
                <li class="relative">
                    <a href="#" class="relative flex flex-row items-baseline gap-x-2 pb-[26px] pt-7"
                        data-dropdown="travel">
                        {{ __('messages.travel') }}
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="hidden bg-white w-48 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-travel">
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-person-walking-luggage text-lg"></i>
                                {{ __('messages.open_trip') }}
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-suitcase text-lg"></i>
                                {{ __('messages.private_tour') }}
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="#" class="text-sm flex items-center gap-x-3">
                                <i class="fa-solid fa-briefcase text-lg"></i>
                                {{ __('messages.various_package') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('hotel.index') }}"
                        class=" flex pb-[26px] pt-7 custom-border">{{ __('messages.hotel') }}</a></li>
                <li class="relative">
                    <a href="#" class="flex flex-row items-center gap-x-2 pb-[26px] pt-7 "
                        data-dropdown="services">
                        {{ __('messages.services') }}
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="hidden bg-white w-48 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-services">
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_medical') }}" class="text-sm flex items-center gap-x-3">
                                {{ __('messages.medical') }}
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_recruitment') }}" class="text-sm flex items-center gap-x-3">
                                {{ __('messages.recruitment') }}
                            </a>
                        </li>
                        <li class="py-3 z-[1000] px-4">
                            <a href="{{ route('services_entertainment') }}" class="text-sm flex items-center gap-x-3">
                                {{ __('messages.entertainment') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('blog.index') }}"
                        class="flex pb-[26px] pt-7 custom-border">{{ __('messages.blog') }}</a></li>
                <li><a href="{{ route('about') }}"
                        class="flex pb-[26px] pt-7 custom-border">{{ __('messages.about_us') }}</a></li>
                <li><a href="{{ route('contact') }}"
                        class="flex pb-[26px] pt-7 custom-border">{{ __('messages.contact_us') }}</a></li>

                {{-- Language Selector --}}
                <li class="relative">
                    <a href="#"
                        class="relative flex flex-row items-baseline gap-x-2 pb-[26px] pt-7 font-semibold text-blue-600 uppercase"
                        data-dropdown="language">
                        {{ LaravelLocalization::getCurrentLocale() }}
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </a>
                    <ul class="hidden bg-white w-24 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-language">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                    class="block py-2 z-[1000] px-4 hover:bg-gray-100 cursor-pointer">
                                    <span
                                        class="text-sm font-medium uppercase {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'text-blue-600' : '' }}">
                                        {{ $localeCode }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Currency Selector --}}
                <li class="relative">
                    <a href="#"
                        class="relative flex flex-row items-baseline gap-x-2 pb-[26px] pt-7 font-semibold text-blue-600"
                        data-dropdown="currency">
                        {{ $currentCurrency ?? 'IDR' }}
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </a>
                    <ul class="hidden bg-white w-24 shadow-lg border absolute top-14 py-2 rounded-lg z-[1000] text-[#687176]"
                        id="dropdown-currency">
                        @foreach (['IDR', 'USD', 'KRW', 'SGD', 'MYR', 'EUR'] as $curr)
                            <li class="py-2 z-[1000] px-4 hover:bg-gray-100 cursor-pointer"
                                onclick="document.getElementById('form-currency-{{ $curr }}').submit()">
                                <span
                                    class="text-sm font-medium {{ ($currentCurrency ?? 'IDR') == $curr ? 'text-blue-600' : '' }}">{{ $curr }}</span>
                                <form id="form-currency-{{ $curr }}" action="{{ route('currency.switch') }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="currency" value="{{ $curr }}">
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <div class="hidden xl:flex flex-row gap-x-4 items-center">
                @guest
                    <div>
                        <a href="{{ route('login_register') }}"
                            class="border-[3px] border-primary px-6 py-1.5 rounded-lg font-medium hover:ring-1 hover:ring-primary transition-all ease-in-out duration-300 whitespace-nowrap">
                            Login
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('login_register') }}"
                            class="border-[3px] border-primary bg-primary px-6 py-1.5 rounded-lg text-white font-medium hover:bg-primary-400 transition-all ease-in-out duration-300 whitespace-nowrap">
                            Sign Up
                        </a>
                    </div>
                @endguest
                @auth('web')
                    @if (Auth::guard('web')->user() && Auth::guard('web')->user()->role !== 'admin')
                        <ul>
                            <li class="relative">
                                <a href="#" data-dropdown="profile-user" class="flex items-center gap-2">
                                    @if (Auth::guard('web')->user()->photo)
                                        <img src="{{ asset('storage/' . Auth::guard('web')->user()->photo) }}"
                                            alt="{{ Auth::guard('web')->user()->name }}"
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
                                            @if (Auth::guard('web')->user()->photo)
                                                <img src="{{ asset('storage/' . Auth::guard('web')->user()->photo) }}"
                                                    alt="{{ Auth::guard('web')->user()->name }}"
                                                    class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div
                                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                                    <i class="fa-solid fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div class="overflow-hidden">
                                                <p class="font-semibold text-gray-800 text-sm truncate">
                                                    {{ Auth::guard('web')->user()->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">
                                                    {{ Auth::guard('web')->user()->email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- My Itineraries -->
                                    <li class="z-[1000] hover:bg-gray-50 transition-colors">
                                        <a href="{{ route('itineraries.index') }}"
                                            class="text-sm flex items-center gap-x-3 py-3 px-4">
                                            <i class="fa-solid fa-map-location-dot text-primary"></i>
                                            My Itineraries
                                        </a>
                                    </li>
                                    <!-- My Bookings -->
                                    <li class="z-[1000] hover:bg-gray-50 transition-colors">
                                        <a href="{{ route('profile.bookings') }}"
                                            class="text-sm flex items-center gap-x-3 py-3 px-4">
                                            <i class="fa-solid fa-ticket text-primary"></i>
                                            My Bookings
                                        </a>
                                    </li>
                                    <!-- My Points -->
                                    <li class="z-[1000] hover:bg-gray-50 transition-colors">
                                        <a href="{{ route('profile.points') }}"
                                            class="text-sm flex items-center gap-x-3 py-3 px-4">
                                            <i class="fa-solid fa-coins text-primary"></i>
                                            My Points
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
                    @else
                        {{-- Admin logged in - show login/register buttons instead --}}
                        <div class="flex flex-row gap-x-3">
                            <a href="{{ route('login_register') }}"
                                class="border-[3px] border-primary px-6 py-2 h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary transition-all ease-in-out duration-300">
                                Login
                            </a>
                            <a href="{{ route('login_register') }}"
                                class="bg-primary text-white px-6 py-2 h-10 rounded-lg font-medium hover:ring-1 hover:ring-primary transition-all ease-in-out duration-300">
                                Sign Up
                            </a>
                        </div>
                    @endif
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
            class="sidebar-home fixed inset-0 z-[1999] flex flex-col justify-start items-start pt-24 h-screen w-screen bg-white/95 backdrop-blur-sm overflow-y-auto transition-all duration-300">
            <div class="flex flex-col w-full px-6 gap-y-4 mb-6">
                <a href="{{ route('login') }}"
                    class="w-full text-center border-2 border-primary text-primary px-6 py-3 rounded-xl font-bold hover:bg-primary-50 transition-all">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="w-full text-center bg-primary text-white border-2 border-primary px-6 py-3 rounded-xl font-bold hover:bg-primary-800 transition-all shadow-lg shadow-blue-200">
                    Sign Up
                </a>
            </div>

            <div class="w-full px-6 pb-20">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Menu</p>
                <ul
                    class="flex flex-col w-full text-gray-600 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-50">
                    <li>
                        <a href="{{ route('home') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                            <span class="font-medium">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('destination', ['type' => 'open-trip']) }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-person-walking-luggage text-lg w-6 text-center"></i>
                            <span class="font-medium">Open Trip</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('destination', ['type' => 'private-trip']) }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-suitcase text-lg w-6 text-center"></i>
                            <span class="font-medium">Private Tour</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-briefcase text-lg w-6 text-center"></i>
                            <span class="font-medium">Various Package</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hotel.index') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-hotel text-lg w-6 text-center"></i>
                            <span class="font-medium">Hotel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services_medical') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-heart text-lg w-6 text-center"></i>
                            <span class="font-medium">Medical Health & Beauty</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services_recruitment') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-user-tie text-lg w-6 text-center"></i>
                            <span class="font-medium">Recruitment</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services_entertainment') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-wand-magic-sparkles text-lg w-6 text-center"></i>
                            <span class="font-medium">Entertainment</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-newspaper text-lg w-6 text-center"></i>
                            <span class="font-medium">Blog</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-circle-info text-lg w-6 text-center"></i>
                            <span class="font-medium">About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                            class="flex items-center gap-x-4 py-4 px-5 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-address-book text-lg w-6 text-center"></i>
                            <span class="font-medium">Contact Us</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="navbar-placeholder"></div>
</header>
