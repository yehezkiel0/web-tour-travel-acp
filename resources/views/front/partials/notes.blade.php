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
                @if ($destination->destination_detail && $destination->destination_detail->include)
                    <ul class="space-y-2 ml-0">
                        @foreach (preg_split('/[.\n]/', strip_tags($destination->destination_detail->include), -1, PREG_SPLIT_NO_EMPTY) as $item)
                            @php
                                $trimmed = trim($item);
                                // Remove Won currency and replace with IDR if found
                                $trimmed = preg_replace('/₩[\d,]+/', '', $trimmed);
                                $trimmed = preg_replace('/\bwon\b/i', 'IDR', $trimmed);
                                $trimmed = trim($trimmed);
                            @endphp
                            @if ($trimmed && strlen($trimmed) > 3)
                                <li class="leading-relaxed flex">
                                    <span class="text-primary mr-2 flex-shrink-0">•</span>
                                    <span class="flex-1">{{ $trimmed }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">No information available</p>
                @endif
            </div>
        </div>
        <div class="relative border border-primary-400 w-full sm:w-1/2 h-fit rounded-2xl sm:rounded-[30px] bg-primary">
            <h1
                class="text-white text-center py-4 sm:py-5 font-bold text-base sm:text-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-xmark"></i>
                <span>Exclude</span>
            </h1>
            <div class="notes-list bg-white rounded-2xl sm:rounded-[30px] p-4 sm:p-5 text-xs sm:text-sm text-gray-2">
                @if ($destination->destination_detail && $destination->destination_detail->exclude)
                    <ul class="space-y-2 ml-0">
                        @foreach (preg_split('/[.\n]/', strip_tags($destination->destination_detail->exclude), -1, PREG_SPLIT_NO_EMPTY) as $item)
                            @php
                                $trimmed = trim($item);
                                // Remove Won currency and replace with IDR if found
                                $trimmed = preg_replace('/₩[\d,]+/', '', $trimmed);
                                $trimmed = preg_replace('/\bwon\b/i', 'IDR', $trimmed);
                                $trimmed = trim($trimmed);
                            @endphp
                            @if ($trimmed && strlen($trimmed) > 3)
                                <li class="leading-relaxed flex">
                                    <span class="text-primary mr-2 flex-shrink-0">•</span>
                                    <span class="flex-1">{{ $trimmed }}</span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">No information available</p>
                @endif
            </div>
        </div>
    </div>
</div>
