@forelse ($results as $result)
    <div class="max-h-60 flex flex-row md:justify-between gap-2 md:gap-6 p-3 md:p-5 bg-white border border-[#E0E0E0] rounded-lg cursor-pointer"
        onclick="window.location.href='{{ route('destination_detail', $result->slug) }}';">
        <div class="w-40 md:w-80 h-auto">
            <img src="{{ Storage::url($result->featured_photo) }}" alt="{{ $result->title }}"
                class="w-full max-h-full object-cover rounded-md" loading="lazy">
        </div>
        <div class="w-full md:w-2/3">
            <div class="flex flex-col gap-y-[10px]">
                <div class="flex flex-row items-center md:items-start md:flex-col gap-1 md:gap-y-[10px]">
                    <h2 class="text-xs md:text-xl font-medium text-gray">{{ $result->title }}</h2>
                    <div
                        class="flex md:inline-flex items-center gap-1 md:space-x-3 font-medium text-[7px] md:text-[13px]">
                        <div class="text-primary bg-[#EBF1FE] md:py-1 px-2 rounded-[10px] border border-primary">
                            {{ $result->type }}</div>
                        <div
                            class="text-[#FFB100] bg-[#FFFAEE] md:py-1 px-2 rounded-[10px] border border-[#FFB100] flex items-center gap-x-2">
                            <img src="{{ asset('images/icon/time-rotate.svg') }}" class="w-3 h-3 md:w-4 md:h-4"
                                alt="time">
                            {{ $result->duration }}
                        </div>
                    </div>
                </div>
                <div class="description-result max-w-sm text-gray-2 font-normal text-[8px] md:text-xs line-clamp-2">
                    {!! $result->description_result !!}
                </div>
                <div class="flex flex-col md:flex-row-reverse md:justify-between md:items-center gap-2">
                    <div class="min-w-[117px] flex flex-col md:justify-end md:pb-4">
                        <p class="text-gray-2 font-normal text-[7px] md:text-sm md:text-end">Start From</p>
                        <div class="flex flex-row gap-1 items-center md:items-end md:gap-0 md:justify-end md:flex-col">
                            <p class="text-gray-2 font-semibold text-[9px] md:text-[17px]">
                                {{ formatIDR($result->price) }}
                            </p>
                            <span class="flex md:justify-end text-gray-2 font-normal text-[8px] md:text-xs">/pax</span>
                        </div>
                    </div>
                    <a href="{{ route('destination_detail', $result->slug) }}"
                        class="text-white bg-primary font-medium text-[8px] md:text-xs text-center rounded-md py-1 md:py-2 px-6 md:px-8 md:w-[140px] hover:bg-primary-400 transition-all ease-in-out duration-300">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-8 bg-white rounded-lg">
        <p class="text-gray-2">No results found</p>
    </div>
@endforelse
