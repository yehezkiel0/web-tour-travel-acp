<div id="overview" class="tab-pane active">
    <div class="flex items-center gap-x-7 mb-7">
        <h2 class="text-3xl font-semibold">{{ $destination->title }}</h2>
        <span
            class="bg-[#EBF1FE] text-primary border border-primary rounded-md px-2 py-1 font-medium text-[13px]">{{ $destination->type }}</span>
    </div>
    <div class="text-gray-1 line-clamp-3 text-xs" id="toggleText">
        {!! $destination->description !!}
    </div>
    <button id="toggleButtonText" class="text-primary font-semibold mt-4 hover:underline">
        <span>View More</span>
        <i class="fa-solid fa-chevron-down transition-transform duration-300"></i>
    </button>

    <div class="mt-8">
        <div class="flex items-center justify-around border border-[#E0E0E0] rounded-2xl p-7">
            <div class="flex items-center space-x-4">
                <i class="fas fa-map-marker-alt text-primary py-2 px-3 text-lg rounded-xl bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-base font-semibold">Meeting Point</h3>
                    <p class="text-xs">{{ $destination->city }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fa-solid fa-map-location-dot text-primary py-2 px-3 text-lg rounded-xl bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-base font-semibold">Destination</h3>
                    <p class="text-xs">{{ $destination->city }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fa-regular fa-calendar text-primary py-2 px-3 text-lg rounded-xl bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-base font-semibold">Date</h3>
                    <p class="text-xs">{{ \Carbon\Carbon::parse($destination->date_started)->format('F j, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fa-regular fa-clock text-primary py-2 px-3 text-lg rounded-xl bg-[#E8EDFF]"></i>
                <div class="text-gray-1">
                    <h3 class="text-base font-semibold">Duration</h3>
                    <p class="text-xs">{{ $destination->duration }} Days</p>
                </div>
            </div>
        </div>
    </div>
</div>
