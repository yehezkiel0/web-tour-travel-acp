@forelse ($results as $result)
    <div class="max-h-60 flex flex-row justify-between gap-x-6 p-5 bg-white border border-[#E0E0E0] rounded-lg cursor-pointer"
        onclick="window.location.href='{{ route('destination_detail', $result->slug) }}';">
        <div class="w-80 ">
            <img src="{{ asset('uploads/' . $result->featured_photo) }}" alt="featured_photo"
                class="w-full object-cover rounded-md">
        </div>
        <div class="w-2/5 flex flex-col gap-y-[10px]">
            <h2 class="text-xl font-medium text-gray">{{ $result->title }}</h2>
            <div class="inline-flex space-x-3 font-medium text-[13px]">
                <div class="text-primary bg-[#EBF1FE] py-1 px-2 rounded-[10px] border border-primary">
                    {{ $result->type }}</div>
                <div
                    class="text-[#FFB100] bg-[#FFFAEE] py-1 px-2 rounded-[10px] border border-[#FFB100] flex items-center gap-x-2">
                    <img src="{{ asset('images/icon/time-rotate.svg') }}">
                    {{ $result->duration }}
                </div>
            </div>
            <div class="description-result text-gray-2 font-normal text-xs pb-[10px]">
                {!! $result->description_result !!}
            </div>
            <a href="">
                <button
                    class="text-white bg-primary font-medium text-xs text-center rounded-md py-2 px-8 w-[140px] hover:bg-primary-400 transition-all ease-in-out duration-300">
                    Book Now</button>
            </a>
        </div>
        <div class="min-w-[117px] flex flex-col justify-end pb-4">
            <p class="text-gray-2 font-normal text-sm text-end">Start From</p>
            <p class="text-gray-2 font-semibold text-[17px]">IDR {{ number_format($result->price) }}</p>
            <span class="flex justify-end text-gray-2 font-normal text-xs">/pax</span>
        </div>
    </div>
@empty
    <div class="text-center py-8 bg-white rounded-lg">
        <p class="text-gray-2">No results found</p>
    </div>
@endforelse
