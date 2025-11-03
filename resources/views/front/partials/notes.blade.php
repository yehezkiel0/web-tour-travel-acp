<div id="notes" class="tab-pane">
    <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6 lg:mb-7">Notes</h2>
    <div class="flex flex-col sm:flex-row gap-4 sm:gap-5">
        <div class="relative border border-primary-400 w-full sm:w-1/2 h-fit rounded-2xl sm:rounded-[30px] bg-primary">
            <h1
                class="text-white text-center py-4 sm:py-5 font-bold text-base sm:text-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>Include</span>
            </h1>
            <div class="notes-list bg-white rounded-2xl sm:rounded-[30px] p-4 sm:p-5 text-xs sm:text-sm text-gray-2">
                {!! $destination->destination_detail->include !!}
            </div>
        </div>
        <div class="relative border border-primary-400 w-full sm:w-1/2 h-fit rounded-2xl sm:rounded-[30px] bg-primary">
            <h1
                class="text-white text-center py-4 sm:py-5 font-bold text-base sm:text-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-xmark"></i>
                <span>Exclude</span>
            </h1>
            <div class="notes-list bg-white rounded-2xl sm:rounded-[30px] p-4 sm:p-5 text-xs sm:text-sm text-gray-2">
                {!! $destination->destination_detail->exclude !!}
            </div>
        </div>
    </div>
</div>
