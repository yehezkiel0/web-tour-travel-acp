@php
    $bookingConfig = [
        'individualVisaRate' => session('booking.individual_visa_rate', 0),
        'groupVisaRate' => session('booking.group_visa_rate', 0),
        'taxPercentage' => session('booking.tax_percentage', 0),
        'adultPrice' => session('booking.adult_price', 0),
        'childPrice' => session('booking.child_price', 0),
        'adultCount' => session('booking.adult_count', 0),
        'childCount' => session('booking.child_count', 0),
        'groupDiscountThreshold' => session('booking.group_discount_threshold', 10),
        'groupDiscountPercentage' => session('booking.group_discount_percentage', 0),
        'seasonalPrices' => $seasonalPrices ?? [],
        'fromDate' => session('booking.from_date'),
        'toDate' => session('booking.to_date'),
    ];
@endphp
<div id="bill-details-container" class="bill-details lg:sticky lg:top-24"
    data-booking-config='@json($bookingConfig)'>
    <div
        class="w-full border border-gray-4 rounded-[10px] p-4 sm:p-5 lg:p-7 text-gray-1 font-medium mb-5 sm:mb-6 lg:mb-7">
        <h3 class="text-lg sm:text-xl font-semibold mb-5 sm:mb-6 lg:mb-7">Bill Details</h3>
        <div
            class="space-y-3 sm:space-y-4 text-gray-2 text-xs sm:text-sm border-b border-gray-4 pb-5 sm:pb-6 lg:pb-7 mb-5 sm:mb-6 lg:mb-7">
            <div class="grid grid-cols-3 items-center gap-2">
                <span class="text-xs sm:text-sm">Adult(s)</span>
                <span class="text-center text-xs sm:text-sm">X {{ $bookingData['adult_count'] }}</span>
                <span class="text-right text-xs sm:text-sm">{{ formatIDR($bookingData['adult_price']) }}</span>
            </div>
            <div class="grid grid-cols-3 items-center gap-2">
                <span class="text-xs sm:text-sm">Child(s)</span>
                <span class="text-center text-xs sm:text-sm">X {{ $bookingData['child_count'] }}</span>
                <span class="text-right text-xs sm:text-sm">{{ formatIDR($bookingData['child_price']) }}</span>
            </div>
            <div class="individual-visa grid grid-cols-3 items-center gap-2">
                <span class="text-xs sm:text-sm">Individual Visa</span>
                <span class="text-center text-xs sm:text-sm">X <span id="individual-visa-count">0</span></span>
                <span id="individual-visa-amount" class="text-right text-xs sm:text-sm">0</span>
            </div>
            <div class="group-visa grid-cols-3 items-center gap-2 hidden">
                <span class="text-xs sm:text-sm">Group Visa</span>
                <span class="text-center text-xs sm:text-sm">X <span id="group-visa-count">0</span></span>
                <span id="group-visa-amount" class="text-right text-xs sm:text-sm">0</span>
            </div>
            <!-- Insurance Row -->
            <div id="insurance-row" class="insurance grid-cols-3 items-center gap-2 hidden" style="color: #2563EB;">
                <span class="text-xs sm:text-sm font-semibold">Travel Insurance</span>
                <span class="text-center text-xs sm:text-sm">X <span id="insurance-count">0</span></span>
                <span id="insurance-amount" class="text-right text-xs sm:text-sm font-semibold">0</span>
            </div>
        </div>
        <div class="space-y-3 sm:space-y-4 text-gray-2">
            <div class="flex justify-between text-xs sm:text-sm font-semibold">
                <span>Sub Total</span>
                <span id="sub-total">0</span>
            </div>
            <div id="discount-row" class="hidden justify-between text-xs sm:text-sm font-semibold text-green-600">
                <span>Group Discount</span>
                <span id="discount-amount">0</span>
            </div>
            <div id="seasonal-row" class="justify-between text-xs sm:text-sm font-semibold text-orange-600 hidden">
                <span>Seasonal Adjustment</span>
                <span id="seasonal-amount">0</span>
            </div>
            <div id="installment-row" class="justify-between text-xs sm:text-sm font-semibold text-blue-600 hidden">
                <span>Payable Now (50%)</span>
                <span id="installment-amount">0</span>
            </div>
            <div class="tax grid grid-cols-3 items-center text-gray-2 text-xs sm:text-sm font-medium gap-2">
                <span>Tax</span>
                <span class="text-center">{{ round($bookingData['tax_percentage']) }}%</span>
                <span id= "tax-amount" class="text-right">0</span>
            </div>
            <div class="total flex justify-between text-lg sm:text-xl font-semibold">
                <span>Total Price</span>
                <span id="total-amount">0</span">
            </div>
            <input type="hidden" name="total_price" value="0">
            <input type="hidden" name="group_visa" value="0">
            <input type="hidden" name="individual_visa" value="0">
            <input type="hidden" name="sub_total" value="0">
        </div>
    </div>
    <p class="font-medium text-[10px] sm:text-xs text-gray-3 mb-1 text-center tracking-wider px-2">
        By completing this booking, you accept and agree to Our
    </p>
    <div
        class="flex flex-wrap justify-center sm:justify-around items-center text-[9px] sm:text-[10px] font-normal text-[#808080] mb-5 sm:mb-6 lg:mb-7 gap-2 sm:gap-0">
        <a href="#" class="underline hover:text-gray-2">Cancelation Policy</a>
        <a href="#" class="underline hover:text-gray-2">Terms & Condition</a>
        <a href="#" class="underline hover:text-gray-2">Travel Insurance</a>
    </div>
    <button type="submit" id="book-now"
        class="w-full text-white text-sm sm:text-base py-3 sm:py-4 rounded-[10px] font-bold mb-6 sm:mb-7 lg:mb-9 border border-primary bg-primary hover:bg-primary-400 transition ease-in-out duration-300"
        data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
        Book Now
    </button>
    <a href="{{ route('destination_detail', ['slug' => $destination->slug]) }}"
        class="flex justify-center text-[#FF3B3B] font-semibold text-center text-sm sm:text-base">Cancel</a>
</div>

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden" id="loginModal">
    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-4 p-6">
        <button type="button"
            class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"
            id="closeModal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>
        <div class="text-center">
            <div class="mb-4 text-yellow-500">
                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                Login Required
            </h3>

            <p class="text-gray-600 mb-6">
                Please log in to access this feature. Create an account if you don't have one yet.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('user.login_register') }}"
                    class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Go to Login
                </a>
                <a href="#"
                    class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors cursor-pointer">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
