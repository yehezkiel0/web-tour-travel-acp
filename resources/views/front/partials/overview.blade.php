<div id="overview" class="tab-pane active">
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-x-7 mb-4 sm:mb-6 lg:mb-7">
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold">{{ $destination->title }}</h2>
        <span
            class="bg-[#EBF1FE] text-primary border border-primary rounded-md px-2 py-1 font-medium text-xs sm:text-[13px] w-fit">{{ $destination->type }}</span>
    </div>
    <div class="text-gray-1 line-clamp-3 text-xs sm:text-sm" id="toggleText">
        {!! $destination->description !!}
    </div>
    <button id="toggleButtonText" class="text-primary font-semibold text-sm sm:text-base mt-3 sm:mt-4 hover:underline">
        <span>View More</span>
        <i class="fa-solid fa-chevron-down transition-transform duration-300"></i>
    </button>

    <div class="mt-6 sm:mt-7 lg:mt-8">
        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:items-center lg:justify-around border border-[#E0E0E0] rounded-2xl p-4 sm:p-5 lg:p-7 gap-4 sm:gap-5 lg:gap-0">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <i
                    class="fas fa-map-marker-alt text-primary py-2 px-3 text-base sm:text-lg rounded-full bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-sm sm:text-base font-semibold">Meeting Point</h3>
                    <p class="text-xs">{{ $destination->city }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-4">
                <i
                    class="fa-solid fa-map-location-dot text-primary py-2 px-3 text-base sm:text-lg rounded-full bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-sm sm:text-base font-semibold">Destination</h3>
                    <p class="text-xs">{{ $destination->city }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-4">
                <i
                    class="fa-regular fa-calendar text-primary py-2 px-3 text-base sm:text-lg rounded-full bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-sm sm:text-base font-semibold">Date</h3>
                    <p class="text-xs">{{ \Carbon\Carbon::parse($destination->date_started)->format('F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-4">
                <i
                    class="fa-regular fa-clock text-primary py-2 px-3 text-base sm:text-lg rounded-full bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-sm sm:text-base font-semibold">Duration</h3>
                    <p class="text-xs">{{ $destination->duration }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
