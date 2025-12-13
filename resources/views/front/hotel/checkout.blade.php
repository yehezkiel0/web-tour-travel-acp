@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto max-w-7xl">
        <div class="mt-14">
            <header class="mb-14">
                <h1 class="text-4xl font-bold text-center mb-14">Hotel Booking <span class="text-primary">Payment</span></h1>
                <div class="w-full mx-auto bg-white px-10">
                    {{-- Reusing stepper component if compatible, or manual --}}
                    <div class="flex items-center justify-between relative">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>
                        <div class="flex flex-col items-center bg-white px-4">
                            <div
                                class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold mb-2">
                                1</div>
                            <span class="text-sm font-medium">Select Room</span>
                        </div>
                        <div class="flex flex-col items-center bg-white px-4">
                            <div
                                class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold mb-2">
                                2</div>
                            <span class="text-sm font-medium">Review & Pay</span>
                        </div>
                        <div class="flex flex-col items-center bg-white px-4">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold mb-2">
                                3</div>
                            <span class="text-sm font-medium">Complete</span>
                        </div>
                    </div>
                </div>
            </header>
            <form id="hotel-booking-payment" action="{{ route('hotel.booking.payment', $hotel->slug) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-gray-1 font-medium">
                    {{-- Left Column: Contact Details --}}
                    <div class="col-span-2 space-y-6">
                        <div class="border border-gray-4 rounded-[10px] p-7 space-y-7 text-sm">
                            <div class="space-y-4">
                                <h3 class="text-xl pb-2 font-semibold">Contact Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-2" for="contact_name">
                                            Name
                                        </label>
                                        <input
                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="contact_name" name="contact_name" type="text"
                                            value="{{ Auth::user()->name ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-2" for="contact_email">
                                            Email
                                        </label>
                                        <input
                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="contact_email" name="contact_email" type="email"
                                            value="{{ Auth::user()->email ?? '' }}" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 text-xs font-bold mb-2" for="contact_phone">
                                            Phone Number
                                        </label>
                                        <input
                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="contact_phone" name="contact_phone" type="text" required>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-gray-700 text-xs font-bold mb-2" for="special_request">
                                            Special Request (Optional)
                                        </label>
                                        <textarea
                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="special_request" name="special_request" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Selected Rooms List --}}
                        <div class="border border-gray-4 rounded-[10px] p-7 text-sm">
                            <h3 class="text-xl pb-4 font-semibold">Selected Rooms</h3>
                            @foreach ($rooms as $item)
                                <div class="flex justify-between items-start border-b border-gray-100 py-4 last:border-0">
                                    <div>
                                        <h4 class="font-bold text-base">{{ $item['room']->room_name }}</h4>
                                        <p class="text-gray-500 text-xs">{{ $item['quantity'] }} Room(s) x
                                            {{ $nights }} Night(s)</p>
                                        <p class="text-gray-500 text-xs mt-1">
                                            @if ($item['breakfast'] === 'with')
                                                <i class="fas fa-coffee mr-1"></i> Breakfast Included
                                            @else
                                                <i class="fas fa-ban mr-1"></i> No Breakfast
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">{{ number_format($item['price'], 0, ',', '.') }} /
                                            night</p>
                                        <p class="text-gray-900 font-semibold mt-1">Total:
                                            {{ number_format($item['subtotal'] * $nights, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Right Column: Summary --}}
                    <div class="total-bill">
                        <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium mb-7">
                            <h4 class="text-lg font-semibold mb-2">{{ $hotel->name }}</h4>
                            <p class="text-gray-500 text-xs mb-4"><i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $hotel->city }}, {{ $hotel->country }}</p>

                            <div class="space-y-4 text-gray-2 text-xs border-t border-gray-4 pt-4 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span>Check-in</span>
                                    <span class="font-semibold text-gray-900">{{ $checkIn->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span>Check-out</span>
                                    <span class="font-semibold text-gray-900">{{ $checkOut->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span>Duration</span>
                                    <span class="font-semibold text-gray-900">{{ $nights }} Night(s)</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium mb-7">
                            <h3 class="text-xl font-semibold mb-4">Promo Code</h3>
                            <div class="flex gap-2">
                                <input type="text" id="promo_code" name="promo_code" placeholder="Enter promo code"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                                <button type="button" id="apply-promo-btn"
                                    class="bg-gray-800 text-white px-6 rounded-lg font-semibold hover:bg-gray-700 transition-colors">Apply</button>
                            </div>
                            <p id="promo-message" class="text-xs mt-2 hidden"></p>
                        </div>

                        <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium mb-7">
                            <h3 class="text-xl font-semibold mb-7">Price Details</h3>
                            <div class="space-y-4 text-gray-2 text-xs border-b border-gray-4 pb-7 mb-7">
                                <div class="flex justify-between items-center">
                                    <span>Total Room Price</span>
                                    <span class="text-right font-semibold">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>Taxes & Fees</span>
                                    <span class="text-right font-semibold">Included</span>
                                </div>
                            </div>
                            <div class="space-y-4 text-gray-2">
                                <div class="total flex justify-between text-xl font-bold text-primary">
                                    <span>Total Price</span>
                                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="pay-now-btn"
                            class="w-full text-white py-4 rounded-[10px] font-bold mb-9  border border-primary bg-primary hover:bg-primary-400 transition ease-in-out duration-300">
                            Pay Now <i class="fas fa-lock ml-2"></i>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="promo_code_id" id="applied_promo_id">
            </form>
        </div>
    </section>
    @include('front.layout.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#apply-promo-btn').click(function() {
                var code = $('#promo_code').val();
                var total = {{ $grandTotal }};
                var btn = $(this);

                if (!code) {
                    alert('Please enter a promo code');
                    return;
                }

                btn.text('Applying...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('promo_code_check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        code: code,
                        total_amount: total
                    },
                    success: function(response) {
                        btn.text('Apply').prop('disabled', false);
                        var msg = $('#promo-message');

                        if (response.success) {
                            msg.removeClass('hidden text-red-500').addClass('text-green-500')
                                .text(
                                    response.message);

                            // Visual update
                            $('#discount-row').remove(); // Remove existing if any
                            var discountRow = `
                                <div id="discount-row" class="flex justify-between items-center text-green-600 font-semibold animate-pulse">
                                    <span>Discount (${response.code})</span>
                                    <span>- Rp ${new Intl.NumberFormat('id-ID').format(response.discount)}</span>
                                </div>
                            `;
                            $('.space-y-4.text-gray-2.text-xs.border-b').append(discountRow);

                            // Update Total
                            $('.total span:last-child').text('Rp ' + new Intl.NumberFormat(
                                'id-ID').format(response.new_total));

                            // Update hidden input
                            $('#applied_promo_id').val(response.promo_id);

                        } else {
                            msg.removeClass('hidden text-green-500').addClass('text-red-500')
                                .text(
                                    response.message);
                        }
                    },
                    error: function() {
                        btn.text('Apply').prop('disabled', false);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
