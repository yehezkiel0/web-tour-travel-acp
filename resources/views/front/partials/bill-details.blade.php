<div class="bill-details">
    <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium mb-7">
        <h3 class="text-xl font-semibold mb-7">Bill Details</h3>
        <div class="space-y-4 text-gray-2 text-xs border-b border-gray-4 pb-7 mb-7">
            <div class="grid grid-cols-3 items-center">
                <span>Adult(s)</span>
                <span class="text-center">X {{ $bookingData['adult_count'] }}</span>
                <span class="text-right">{{ formatIDR($bookingData['adult_price']) }}</span>
            </div>
            <div class="grid grid-cols-3 items-center">
                <span>Child(s)</span>
                <span class="text-center">X {{ $bookingData['child_count'] }}</span>
                <span class="text-right">{{ formatIDR($bookingData['child_price']) }}</span>
            </div>
            <div class="individual-visa grid grid-cols-3 items-center">
                <span>Individual Visa</span>
                <span class="text-center">X <span id="individual-visa-count">0</span></span>
                <span id="individual-visa-amount" class="text-right">0</span>
            </div>
            <div class="group-visa grid-cols-3 items-center hidden">
                <span>Group Visa</span>
                <span class="text-center">X <span id="group-visa-count">0</span></span>
                <span id="group-visa-amount" class="text-right">0</span>
            </div>
            <div class="grid grid-cols-3 items-center">
                <span>Tour Tips</span>
                <span class="text-center">X 5</span>
                <span class="text-right">{{ formatIDR(3500000) }}</span>
            </div>
        </div>
        <div class="space-y-4 text-gray-2">
            <div class="flex justify-between text-xs font-semibold">
                <span>Sub Total</span>
                <span id="sub-total">0</span">
            </div>
            <div class="tax grid grid-cols-3 items-center text-gray-2 text-xs font-medium">
                <span>Tax</span>
                <span class="text-center">{{ round($bookingData['tax_percentage']) }}%</span>
                <span id= "tax-amount" class="text-right">0</span>
            </div>
            <div class="total flex justify-between text-xl font-semibold">
                <span>Total Price</span>
                <span id="total-amount">0</span">
            </div>
        </div>
    </div>
    <p class="font-medium text-xs text-gray-3 mb-1 text-center tracking-wider">By completing this booking,you accept and
        agree to Our
    </p>
    <div class="flex justify-around items-center text-[10px] font-normal text-[#808080] mb-7">
        <a href="#" class="underline hover:text-gray-2">Cancelation Policy</a>
        <a href="#" class="underline hover:text-gray-2">Terms & Condition</a>
        <a href="#" class="underline hover:text-gray-2">Travel Insurance</a>
    </div>
    <button type="submit"
        class="w-full text-white py-4 rounded-[10px] font-bold mb-9  border border-primary bg-primary hover:bg-primary-400 transition ease-in-out duration-300">
        Book Now
    </button>
    <a href="{{ route('destination_detail', ['slug' => $destination->slug]) }}"
        class="flex justify-center text-[#FF3B3B] font-semibold text-center">Cancel</a>
</div>

<script>
    window.bookingData = {
        individualVisaRate: {{ session('booking.individual_visa_rate', 0) }},
        groupVisaRate: {{ session('booking.group_visa_rate', 0) }},
        taxPercentage: {{ session('booking.tax_percentage', 0) }},
        adultPrice: {{ session('booking.adult_price', 0) }},
        childPrice: {{ session('booking.child_price', 0) }},
        adultCount: {{ session('booking.adult_count', 0) }},
        childCount: {{ session('booking.child_count', 0) }},
    };
</script>
