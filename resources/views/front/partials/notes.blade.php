<div id="notes" class="tab-pane">
    <h2 class="text-2xl font-semibold mb-7">Notes</h2>
    <div class="flex space-x-5">
        <div class="relative border border-primary-400 w-1/2 h-fit rounded-[30px] bg-primary">
            <h1 class=" text-white text-center py-5 font-bold text-lg">
                Include
            </h1>
            <div class="notes-list bg-white rounded-[30px] p-5 text-xs text-gray-2">
                {!! $destination->destination_detail->include !!}
            </div>
        </div>
        <div class="relative border border-primary-400 w-1/2 h-fit rounded-[30px] bg-primary">
            <h1 class=" text-white text-center py-5 font-bold text-lg">
                Exclude
            </h1>
            <div class="notes-list bg-white rounded-[30px] p-5 text-xs text-gray-2">
                {!! $destination->destination_detail->exclude !!}
            </div>
        </div>
    </div>
</div>
