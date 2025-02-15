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
            <input type="hidden" name="total_price" value="0">
            <input type="hidden" name="group_visa" value="0">
            <input type="hidden" name="individual_visa" value="0">
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
    <button type="submit" id="book-now"
        class="w-full text-white py-4 rounded-[10px] font-bold mb-9  border border-primary bg-primary hover:bg-primary-400 transition ease-in-out duration-300"
        data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
        Book Now
    </button>
    <a href="{{ route('destination_detail', ['slug' => $destination->slug]) }}"
        class="flex justify-center text-[#FF3B3B] font-semibold text-center">Cancel</a>
</div>

<div class="fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm hidden" id="loginModal">
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
                <a href="{{ route('login_register') }}"
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

    document.getElementById('book-now').addEventListener('click', function(e) {
        e.preventDefault();

        const isAuthenticated = this.dataset.authenticated === 'true';
        const closeModal = document.getElementById('closeModal');

        if (isAuthenticated) {
            document.getElementById('booking-form').submit();
        } else {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        if (closeModal) {
            closeModal.addEventListener('click', function() {
                document.getElementById('loginModal').classList.add('hidden');
            }, {
                once: true
            });
        }
    });
</script>
