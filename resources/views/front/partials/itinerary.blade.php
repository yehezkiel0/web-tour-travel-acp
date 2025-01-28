<div id="itinerary" class="tab-pane md:col-span-2 mb-14">
    <h2 class="text-2xl font-semibold mb-3">Itinerary</h2>
    <p class="text-gray-3 text-[10px] mb-7">*Changes may occur according to on-site conditions without reducing
        the
        planned attractions</p>
    <div class="relative space-y-8">
        {{-- Main vertical dashed line --}}
        <div
            class="absolute top-5 left-6 h-[calc(100%-8rem)] w-px border-l-2 border-dashed border-secondary -translate-x-1/2 ">
        </div>

        {{-- Itinerary items --}}
        @foreach ($itineraries as $index => $item)
            <div class="relative flex flex-row items-start space-x-10">
                @if ($loop->last)
                    <div class="flex items-center justify-center shrink-0 z-10">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M42.8865 41.2934C42.8865 44.5832 34.4307 47.25 23.9999 47.25C13.5691 47.25 5.11328 44.5832 5.11328 41.2934C5.11328 38.7091 10.332 36.5095 17.6266 35.6848C18.5007 36.8603 19.3537 37.9713 20.1483 38.9886C17.3728 39.3831 15.4703 40.1904 15.4703 41.1225C15.4703 42.4431 19.2891 43.5136 23.9999 43.5136C28.7106 43.5136 32.5294 42.4431 32.5294 41.1225C32.5294 40.1913 30.6303 39.3845 27.8587 38.9896C28.658 37.9708 29.5145 36.8604 30.3913 35.6869C37.6764 36.5131 42.8865 38.7112 42.8865 41.2934ZM23.9999 0.75C15.7487 0.75 9.05987 7.43888 9.05987 15.69C9.05987 22.5468 19.0192 35.2102 23.6344 40.9713C23.7262 41.0859 23.8527 41.1466 23.9998 41.1466C24.1467 41.1469 24.2731 41.0861 24.3651 40.9718C28.7892 35.4588 38.9398 22.7351 38.9398 15.69C38.9399 7.43888 32.251 0.75 23.9999 0.75ZM23.9999 7.8435C28.3232 7.8435 31.8282 11.3484 31.8282 15.6718C31.8282 19.9953 28.3233 23.5001 23.9999 23.5001C19.6764 23.5001 16.1716 19.9953 16.1716 15.6718C16.1716 11.3484 19.6764 7.8435 23.9999 7.8435Z"
                                fill="#FFCB55" />
                        </svg>

                    </div>
                @else
                    <div
                        class="flex items-center justify-center w-12 h-12 rounded-lg bg-secondary text-white font-bold shrink-0 z-10">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                @endif

                <div>
                    <h3 class="text-lg font-semibold text-secondary-600">
                        {{ $item->title }}
                    </h3>
                    <p class="mt-2 text-primary-700 font-semibold">
                        {{ $item->duration }}
                    </p>
                    <p class="mt-2 text-gray-1">
                        {{ $item->description }}
                    </p>
                    @if (isset($item->alternative))
                        <p class="mt-2 text-gray-1 italic">
                            {{ $item->alternative }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
