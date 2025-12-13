@extends('front.layout.app')

@section('title', 'Hotels - ACP Tours & Travel')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    @include('front.layout.nav')

    <!-- Hero Section with Search -->
    <div class="hotel-hero relative"
        style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920'); background-size: cover; background-position: center; padding: 120px 0 80px 0;">
        <div class="container mx-auto px-4">
            <div class="flex justify-center mb-12">
                <div class="text-center text-white max-w-3xl">
                    <h1 class="text-5xl font-bold mb-4">BOOK A HOTEL AT ACP TOURS</h1>
                    <p class="text-xl">Always available. Get discount here</p>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="w-full max-w-4xl">
                    <div class="bg-white p-6 rounded-xl shadow-2xl">
                        <form action="{{ route('hotel.index') }}" method="GET" id="searchForm">
                            <!-- Search Input -->
                            <div class="mb-4">
                                <div class="flex items-center border border-gray-300 rounded-lg px-4 py-3 bg-white">
                                    <i class="fas fa-search text-gray-400 mr-3"></i>
                                    <input type="text" name="search" id="searchInput"
                                        class="w-full focus:outline-none text-gray-700" placeholder="Malang"
                                        value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Date and Guest Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Check-in Date -->
                                <div>
                                    <div
                                        class="flex items-center border border-gray-300 rounded-lg px-4 py-3 bg-white cursor-pointer">
                                        <i class="far fa-calendar text-gray-400 mr-3 text-xl"></i>
                                        <div class="flex-1">
                                            <input type="text" id="checkInDate" name="check_in"
                                                class="w-full focus:outline-none text-gray-700 font-medium cursor-pointer"
                                                placeholder="21 Nov 2025" readonly>
                                            <div class="text-xs text-gray-500 mt-0.5">Jumat</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Check-out Date -->
                                <div>
                                    <div
                                        class="flex items-center border border-gray-300 rounded-lg px-4 py-3 bg-white cursor-pointer">
                                        <i class="far fa-calendar text-gray-400 mr-3 text-xl"></i>
                                        <div class="flex-1">
                                            <input type="text" id="checkOutDate" name="check_out"
                                                class="w-full focus:outline-none text-gray-700 font-medium cursor-pointer"
                                                placeholder="24 Nov 2025" readonly>
                                            <div class="text-xs text-gray-500 mt-0.5">Senin</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guest Selection -->
                                <div class="relative">
                                    <div class="flex items-center border border-gray-300 rounded-lg px-4 py-3 bg-white cursor-pointer hover:border-blue-400 transition"
                                        id="guestDropdownBtn" data-dropdown="guests">
                                        <i class="fas fa-users text-gray-400 mr-3 text-xl"></i>
                                        <div class="flex-1" id="guestDisplayWrapper">
                                            <div class="text-gray-700 font-medium">2 dewasa</div>
                                            <div class="text-xs text-gray-500 mt-0.5">1 kamar</div>
                                        </div>
                                        <i
                                            class="fa-solid fa-chevron-down text-gray-400 ml-2 transition-transform text-sm"></i>
                                    </div>
                                    <input type="hidden" name="rooms" id="roomsInput" value="1">
                                    <input type="hidden" name="adults" id="adultsInput" value="2">
                                    <input type="hidden" name="children" id="childrenInput" value="0">

                                    <!-- Dropdown Menu -->
                                    <div class="bg-white shadow-lg border absolute top-[calc(100%+8px)] left-0 right-0 py-4 px-4 rounded-lg z-[1000]"
                                        id="dropdown-guests" style="display: none;">
                                        <div class="space-y-4">
                                            <!-- Rooms -->
                                            <div class="flex items-center justify-between py-2">
                                                <div>
                                                    <div class="font-semibold text-gray-800">Kamar</div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <button type="button" class="counter-btn" id="roomsDecrease">
                                                        <i class="fas fa-minus text-xs text-gray-600"></i>
                                                    </button>
                                                    <span class="w-10 text-center font-bold text-gray-800 text-lg"
                                                        id="roomsCount">1</span>
                                                    <button type="button" class="counter-btn counter-btn-add"
                                                        id="roomsIncrease">
                                                        <i class="fas fa-plus text-xs text-blue-600"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Adults -->
                                            <div class="flex items-center justify-between py-2 border-t pt-3">
                                                <div>
                                                    <div class="font-semibold text-gray-800">Dewasa</div>
                                                    <div class="text-xs text-gray-500">Usia 18 tahun ke atas</div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <button type="button" class="counter-btn" id="adultsDecrease">
                                                        <i class="fas fa-minus text-xs text-gray-600"></i>
                                                    </button>
                                                    <span class="w-10 text-center font-bold text-gray-800 text-lg"
                                                        id="adultsCount">2</span>
                                                    <button type="button" class="counter-btn counter-btn-add"
                                                        id="adultsIncrease">
                                                        <i class="fas fa-plus text-xs text-blue-600"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Children -->
                                            <div class="flex items-center justify-between py-2 border-t pt-3">
                                                <div>
                                                    <div class="font-semibold text-gray-800">Anak</div>
                                                    <div class="text-xs text-gray-500">Usia 0-17 tahun</div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <button type="button" class="counter-btn" id="childrenDecrease">
                                                        <i class="fas fa-minus text-xs text-gray-600"></i>
                                                    </button>
                                                    <span class="w-10 text-center font-bold text-gray-800 text-lg"
                                                        id="childrenCount">0</span>
                                                    <button type="button" class="counter-btn counter-btn-add"
                                                        id="childrenIncrease">
                                                        <i class="fas fa-plus text-xs text-blue-600"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition shadow-lg">
                                    <i class="fas fa-search mr-2"></i>Cari Hotel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Listing Section -->
    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <!-- Search Summary Card (Only show when search is active) -->
            @if (isset($searchParams) &&
                    ($searchParams['check_in'] ||
                        $searchParams['check_out'] ||
                        $searchParams['rooms'] > 1 ||
                        $searchParams['adults'] > 2 ||
                        $searchParams['children'] > 0))
                <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-md p-6 mb-8 border border-blue-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="bg-blue-600 rounded-full p-3 mr-4">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Hasil Pencarian Hotel</h3>
                                <p class="text-sm text-gray-600">{{ $hotels->total() }} hotel tersedia</p>
                            </div>
                        </div>
                        <a href="{{ route('hotel.index') }}" class="text-blue-600 hover:text-blue-800 transition">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Dates -->
                        @if ($searchParams['check_in'] && $searchParams['check_out'])
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                    <span class="text-xs text-gray-500 font-semibold">Tanggal</span>
                                </div>
                                <p class="text-sm font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($searchParams['check_in'])->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($searchParams['check_out'])->format('d M Y') }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ $nights }} malam</p>
                            </div>
                        @endif

                        <!-- Rooms -->
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-door-open text-blue-600 mr-2"></i>
                                <span class="text-xs text-gray-500 font-semibold">Kamar</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ $searchParams['rooms'] }}</p>
                            <p class="text-xs text-gray-600">{{ $searchParams['rooms'] > 1 ? 'kamar' : 'kamar' }}</p>
                        </div>

                        <!-- Adults -->
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user text-blue-600 mr-2"></i>
                                <span class="text-xs text-gray-500 font-semibold">Dewasa</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ $searchParams['adults'] }}</p>
                            <p class="text-xs text-gray-600">orang</p>
                        </div>

                        <!-- Children -->
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-child text-blue-600 mr-2"></i>
                                <span class="text-xs text-gray-500 font-semibold">Anak</span>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ $searchParams['children'] }}</p>
                            <p class="text-xs text-gray-600">anak</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <i class="fas fa-hotel text-blue-600 text-3xl mr-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800">Kalian bisa pilih hotel sepuas kalian!</h3>
                </div>
                <p class="text-gray-600 mb-6">Jangan sampai tidak bisa menginap dengan sekali pesan. Selaras pesan, hotel
                    berjugan kebutuhan</p>

                <!-- City Filter Pills -->
                <div class="flex flex-wrap gap-3 mb-8" id="cityFilters">
                    <button
                        class="city-filter-btn px-6 py-2 rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition active"
                        data-city="">
                        All Cities
                    </button>
                    @foreach ($cities as $city)
                        <button
                            class="city-filter-btn px-6 py-2 rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition"
                            data-city="{{ $city }}">
                            {{ $city }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Hotel List Container -->
            <div id="hotelResults" class="mb-8">
                @if ($hotels->count() > 0)
                    <!-- Desktop Grid -->
                    <div class="hidden md:grid grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($hotels as $hotel)
                            @include('front.hotel.partials.hotel-card', ['hotel' => $hotel])
                        @endforeach
                    </div>

                    <!-- Mobile Swiper -->
                    <div class="md:hidden swiper-hotel-list overflow-hidden relative pb-10">
                        <div class="swiper-wrapper">
                            @foreach ($hotels as $hotel)
                                <div class="swiper-slide h-auto">
                                    @include('front.hotel.partials.hotel-card', ['hotel' => $hotel])
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-hotel text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500 text-lg">No hotels found</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mb-8">
                {{ $hotels->links() }}
            </div>

            <!-- See All Button -->
            <div class="text-center">
                <a href="{{ route('hotel.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-12 py-3 rounded-full transition">
                    See all Hotels
                </a>
            </div>
        </div>
    </div>

    <!-- Refund Section -->
    <div class="py-16" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="text-white">
                    <h2 class="text-3xl font-bold mb-4">Bisa refund ataupun reschedule secara gratis apapun alasannya!</h2>
                    <p class="text-lg mb-6">Yuk, segera daftar di ACP Tours untuk ikopan yang menyebabkan bisa refund dan
                        reschedule dengan mudah.</p>
                    <button
                        class="bg-white text-purple-600 hover:bg-gray-100 font-semibold px-8 py-3 rounded-lg transition">
                        Cek Infonya
                    </button>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800" alt="Tokyo Tower"
                        class="rounded-xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Top Destinations -->
    <div class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-2 text-gray-800">TOP DESTINATIONS IN KOREA</h2>
                <p class="text-gray-600">Saatnya kalian memilih destinasi yang menarik</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                @php
                    $topDestinations = \App\Models\Destination::orderBy('view_count', 'desc')->take(5)->get();
                @endphp
                @foreach ($topDestinations as $destination)
                    <a href="{{ route('destination_detail', $destination->slug) }}" class="block">
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                            <img src="{{ Storage::url($destination->featured_photo) }}" class="w-full h-40 object-cover"
                                alt="{{ $destination->city }}">
                            <div class="p-4 text-center">
                                <h6 class="font-bold text-gray-800 mb-1">{{ $destination->city }}</h6>
                                <small class="text-gray-500">{{ $destination->view_count }} accommodations</small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('destination') }}"
                    class="inline-block bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold px-12 py-3 rounded-full transition">
                    See all
                </a>
            </div>
        </div>
    </div>

    <!-- Why Book Section -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa kamu harus <span class="text-blue-600">Booking
                    Hotel</span> di ACP Tours?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="rounded-xl p-8 text-center text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="mb-6 flex justify-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-6">
                            <i class="fas fa-hotel text-5xl"></i>
                        </div>
                    </div>
                    <h5 class="font-bold text-xl mb-4">Paket Akomodasi yang Variatif</h5>
                    <p class="text-sm opacity-90">ACP Travel & Tours menyediakan berbagai pilihan hotel dan penginapan yang
                        luas dan budget-friendly hingga resor, sesuai dengan preferensi dan anggaran Anda.</p>
                </div>

                <!-- Card 2 -->
                <div class="rounded-xl p-8 text-center text-white"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="mb-6 flex justify-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-6">
                            <i class="fas fa-tags text-5xl"></i>
                        </div>
                    </div>
                    <h5 class="font-bold text-xl mb-4">Harga Kompetitif</h5>
                    <p class="text-sm opacity-90">Kami kami menawarkan harga yang kompetitif dengan diskon yang menarik
                        memperhatikan biaya anda.</p>
                </div>

                <!-- Card 3 -->
                <div class="rounded-xl p-8 text-center text-white"
                    style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <div class="mb-6 flex justify-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-6">
                            <i class="fas fa-calendar-check text-5xl"></i>
                        </div>
                    </div>
                    <h5 class="font-bold text-xl mb-4">Kemudahan Reservasi</h5>
                    <p class="text-sm opacity-90">Proses pemesanan yang mudah, baik secara online maupun melalui layanan
                        pelanggan, membuat pengaturan perjalanan menjadi efisien.</p>
                </div>

                <!-- Card 4 -->
                <div class="rounded-xl p-8 text-center"
                    style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                    <div class="mb-6 flex justify-center">
                        <div class="bg-white bg-opacity-30 rounded-full p-6">
                            <i class="fas fa-map-marker-alt text-5xl text-orange-600"></i>
                        </div>
                    </div>
                    <h5 class="font-bold text-xl mb-4 text-gray-800">Lokasi Strategis</h5>
                    <p class="text-sm text-gray-700">Kami pengalaman terbaik di lokasi-lokasi strategis yang dekat dengan
                        dengan daya tarik utama. Anda tidak perlu khawatir menemukan lokasi-lokasi menarik, membuat Anda
                        mudah.</p>
                </div>
            </div>
        </div>
    </div>

    @include('front.layout.footer')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite(['resources/js/front/modules/hotel-datepicker.js', 'resources/js/front/modules/hotel-search.js'])

@endsection
