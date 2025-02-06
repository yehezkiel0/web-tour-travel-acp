@php
    $totalTravelers = $bookingData['adult_count'] + $bookingData['child_count'];
@endphp

@for ($i = 1; $i <= $totalTravelers; $i++)
    <div class="form-group-booking space-y-7 mb-7">
        <h4 class="text-base font-medium bg-primary-50 p-4 rounded-[10px]" id="labelName">Traveller
            {{ $i }}</h4>
        <div class="grid grid-cols-6 grid-rows-3 gap-4 text-sm font-medium text-gray-3">
            <div class="relative">
                <select name="travellers[{{ $i }}][title]"
                    class="w-full py-3 px-5 bg-transparent border-0 border-b-2 border-gray-4 focus:outline-none focus:ring-0 focus:border-gray-200 appearance-none">
                    <option value="Mr." selected>Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                </select>
                <svg class="absolute right-4 top-1/2 transform -translate-y-1/2" width="10" height="9"
                    viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 0.381042L10 3.55285L5 8.61893L-1.38644e-07 3.55285L0 0.381042L5 5.46915L10 0.381042Z"
                        fill="#BDBDBD" />
                </svg>
            </div>
            <div>
                <input type="text" name="travellers[{{ $i }}][age]" placeholder="Age"
                    class="w-full py-3 px-10 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="col-span-2">
                <input type="text" name="travellers[{{ $i }}][first_name]" placeholder="First Name"
                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="col-span-2">
                <input type="text" name="travellers[{{ $i }}][last_name]" placeholder="Last Name"
                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="col-span-2 relative">
                <select name="travellers[{{ $i }}][nationality]"
                    class="w-full py-3 px-5 bg-transparent border-0 border-b-2 border-gray-4 focus:outline-none focus:ring-0 focus:border-gray-200 appearance-none">
                    <option value="" disabled selected>
                        Nationality
                    </option>
                    @foreach (config('countries') as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
                <svg class="absolute right-4 top-1/2 transform -translate-y-1/2" width="10" height="9"
                    viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 0.381042L10 3.55285L5 8.61893L-1.38644e-07 3.55285L0 0.381042L5 5.46915L10 0.381042Z"
                        fill="#BDBDBD" />
                </svg>
            </div>
            <div class="col-span-2">
                <input type="tel" name="travellers[{{ $i }}][phone]" placeholder="Phone"
                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="col-span-2 row-start-3">
                <input type="text" name="travellers[{{ $i }}][passportNumber]"
                    placeholder="Passport Number"
                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="col-span-2 row-start-3 relative">
                <label for="passportExpiredDate_{{ $i }}"
                    class="absolute top-1/2 transform -translate-y-1/2 left-4">Exp</label>
                <input type="date" id="passportExpiredDate_{{ $i }}"
                    name="travellers[{{ $i }}][passportExpiredDate]"
                    class="w-full py-3 pl-16 border-0 border-b-2 border-gray-4 focus:outline-none">
            </div>
            <div class="row-start-3 inline-flex  items-center">
                <div id="tooltip"
                    data-tippy-content="<div><p class='title-tooltip'>Notes <span>*</span></p><p class='sub-title-tooltip'>Pastikan masa berlaku paspor setidaknya 6 bulan dari tanggal keberangkatan</p></div>"
                    class="cursor-pointer z-10">
                    <i class="fa-regular fa-circle-question text-lg pl-2"></i>
                </div>
            </div>
        </div>
        <div class="visa-checkbox inline-flex items-center gap-7 pl-5">
            <label class="text-[10px] font-normal text-gray-1" for="visa_{{ $i }}">With Visa?</label>
            <input type="checkbox" class="with-visa h-4 w-4" id="visa_{{ $i }}"
                name="travellers[{{ $i }}][with_visa]" value="1">
        </div>
    </div>
@endfor
