@props(['steps' => [], 'currentStep' => 1])

<div class="w-full py-6" id="stepper" data-current-step="{{ $currentStep }}">
    <div class="flex items-center justify-center">
        @foreach ($steps as $index => $step)
            {{-- Step circle --}}
            <div class="flex flex-col items-center">
                <span class="font-medium step-label absolute -translate-y-10">
                    {{ $step }}
                </span>
                <div class="relative flex flex-col items-center space-y-4">
                    <div class="w-4 h-4 rounded-full flex items-center justify-center border-2 step-circle"
                        data-step="{{ $index + 1 }}" data-current="{{ $currentStep }}">
                        <svg class="step-active-indicator hidden" width="8" height="8" viewBox="0 0 7 8"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="1.25" width="6" height="6" rx="3" fill="#3477F6"
                                stroke="#3477F6" />
                        </svg>
                    </div>
                </div>
            </div>

            @if ($index < count($steps) - 1)
                <div class="flex-1 items-center step-line border-primary border-t-2 border-dashed"
                    data-step="{{ $index + 1 }}" data-current="{{ $currentStep }}">
                </div>
            @endif
        @endforeach
    </div>
</div>
