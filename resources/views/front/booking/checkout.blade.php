@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto max-w-7xl">
        <div class="mt-14">
            <header class="mb-14">
                <h1 class="text-4xl font-bold text-center mb-14">Payment <span class="text-primary">Page</span></h1>
                <div class="w-full mx-auto bg-white px-10">
                    <x-stepper :steps="['Select Tour', 'Contact Details', 'Payment', 'Complete']" :current-step="3" />
                </div>
            </header>
            <form id="booking-payment" action="{{ route('booking_payment', $destination->slug) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-gray-800 font-medium">
                    <!-- Left Column: Details -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Trip Summary Card -->
                        <div
                            class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Your Trip
                            </h3>
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="w-full sm:w-1/3 aspect-video rounded-xl overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($destination->featured_photo) }}"
                                        alt="{{ $destination->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 space-y-3">
                                    <h4 class="text-2xl font-bold text-gray-900 leading-tight">{{ $destination->title }}
                                    </h4>
                                    <p class="text-gray-500 text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8M12 20h.01M12 11V3m0 0l-3 3m3-3l3 3">
                                            </path>
                                        </svg>
                                        {{ $destination->city }}, {{ $destination->country }}
                                    </p>
                                    <div class="flex flex-wrap gap-4 pt-2">
                                        <div class="bg-blue-50 px-4 py-2 rounded-lg">
                                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Date
                                            </p>
                                            <p class="text-sm font-semibold text-primary">
                                                {{ formatDate($destination->date_started, 'd M Y') }} -
                                                {{ formatDate($destination->date_ended, 'd M Y') }}
                                            </p>
                                        </div>
                                        <div class="bg-blue-50 px-4 py-2 rounded-lg">
                                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">
                                                Duration</p>
                                            <p class="text-sm font-semibold text-primary">
                                                {{ calculateDuration($destination->date_started, $destination->date_ended) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Details Card -->
                        <div
                            class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Contact Details
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <p class="text-xs text-gray-500 mb-1">Full Name</p>
                                    <p class="font-semibold text-gray-900">{{ $bookingData['contact_name'] }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <p class="text-xs text-gray-500 mb-1">Email Address</p>
                                    <p class="font-semibold text-gray-900">{{ $bookingData['contact_email'] }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <p class="text-xs text-gray-500 mb-1">Phone Number</p>
                                    <p class="font-semibold text-gray-900">{{ $bookingData['contact_phone'] }}</p>
                                </div>
                                @if (!empty($bookingData['notes']))
                                    <div class="bg-gray-50 p-4 rounded-xl sm:col-span-2">
                                        <p class="text-xs text-gray-500 mb-1">Notes</p>
                                        <p class="font-semibold text-gray-900">{{ $bookingData['notes'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Traveller Details Card -->
                        <div
                            class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                            <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                Traveller Details
                            </h3>
                            <div class="space-y-4">
                                @foreach ($travellers as $index => $traveller)
                                    <div
                                        class="flex items-start sm:items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-blue-50/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold text-sm">
                                                {{ $index + 1 }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $traveller['title'] }}
                                                    {{ $traveller['first_name'] }} {{ $traveller['last_name'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $traveller['nationality'] }} • Age
                                                    {{ $traveller['age'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Sticky Payment Summary -->
                    <div class="lg:col-span-1">
                        <div class="lg:sticky lg:top-24 space-y-6">

                            <!-- Promo & Points Card -->
                            <div
                                class="bg-white border border-gray-100 rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                        Promo Code
                                    </h4>
                                    <div class="flex gap-2">
                                        <input type="text" id="promo_code" name="promo_code"
                                            placeholder="Example: SUMMER25"
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm">
                                        <button type="button" id="apply-promo-btn"
                                            class="bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-800 transition-colors">Apply</button>
                                    </div>
                                    <p id="promo-message" class="text-xs mt-2 hidden"></p>
                                </div>

                                @if ($userPoints > 0)
                                    <div class="pt-6 border-t border-dashed border-gray-200">
                                        <div class="flex justify-between items-center mb-3">
                                            <h4 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                My Points
                                            </h4>
                                            <span
                                                class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">{{ number_format($userPoints) }}
                                                pts</span>
                                        </div>
                                        <div class="flex gap-2 relative">
                                            <input type="number" name="redeem_points" id="redeem_points"
                                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm"
                                                placeholder="Redeem points" min="0" max="{{ $userPoints }}">
                                            <div
                                                class="absolute right-14 top-2.5 text-xs text-gray-400 pointer-events-none">
                                                Max {{ $userPoints }}</div>
                                            <button type="button" onclick="applyPoints()"
                                                class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">Use</button>
                                        </div>
                                        <div id="points_feedback" class="text-xs mt-2 hidden font-medium"></div>
                                    </div>
                                @endif
                            </div>

                            <!-- Payment Summary Card -->
                            <div
                                class="bg-white border border-gray-100 rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
                                <h3 class="text-lg font-bold mb-6">Payment Summary</h3>
                                <div class="space-y-3 pb-6 border-b border-gray-100">
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Adults (x{{ $bookingData['adult_count'] }})</span>
                                        <span
                                            class="font-medium text-gray-900">{{ formatIDR($bookingData['adult_price']) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Children (x{{ $bookingData['child_count'] }})</span>
                                        <span
                                            class="font-medium text-gray-900">{{ formatIDR($bookingData['child_price']) }}</span>
                                    </div>

                                    @if ($bookingData['individual_visa'] > 0)
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Visa (Individual)</span>
                                            <span
                                                class="font-medium text-gray-900">{{ formatIDR($bookingData['individual_visa']) }}</span>
                                        </div>
                                    @endif
                                    @if ($bookingData['group_visa'] > 0)
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Visa (Group)</span>
                                            <span
                                                class="font-medium text-gray-900">{{ formatIDR($bookingData['group_visa']) }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between text-sm text-gray-600 pt-2">
                                        <span>Subtotal</span>
                                        <span
                                            class="font-medium text-gray-900">{{ formatIDR($bookingData['sub_total']) }}</span>
                                    </div>

                                    <!-- Placeholder for dynamic discount row -->
                                    <div class="tax"></div>

                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Tax ({{ round($bookingData['tax_percentage']) }}%)</span>
                                        <span
                                            class="font-medium text-gray-900">{{ formatIDR(($bookingData['tax_percentage'] * $bookingData['sub_total']) / 100) }}</span>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <div class="flex justify-between items-end mb-6">
                                        <span class="text-sm font-semibold text-gray-500">Total Payment</span>
                                        <span id="total-amount"
                                            class="text-2xl font-bold text-gray-900 leading-none">{{ formatIDR($bookingData['total_price']) }}</span>
                                    </div>

                                    <button type="submit" id="book-now"
                                        class="w-full text-white py-4 rounded-xl font-bold bg-primary hover:bg-blue-600 shadow-lg shadow-blue-500/30 transition ease-in-out duration-300 transform hover:-translate-y-1 mb-3"
                                        data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
                                        Pay Now
                                    </button>

                                    <a href="{{ route('destination_detail', ['slug' => $destination->slug]) }}"
                                        class="block w-full text-center py-2 text-sm text-red-400 font-medium hover:text-gray-600 transition-colors">
                                        Cancel Transaction
                                    </a>
                                </div>
                            </div>

                            <!-- Security Note -->
                            <div class="flex items-center justify-center gap-2 text-xs text-gray-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Payments are secure and encrypted
                            </div>
                        </div>
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
                var total = {{ $bookingData['total_price'] }};
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
                            msg.removeClass('hidden text-red-500').addClass('text-green-600')
                                .text(
                                    response.message);

                            // Visual update
                            $('#discount-row').remove(); // Remove existing if any
                            var discountRow = `
                                <div id="discount-row" class="flex justify-between text-sm text-green-600 pt-2">
                                    <span>Discount (${response.code})</span>
                                    <span class="font-medium">- ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.discount)}</span>
                                </div>
                            `;
                            $('.tax').after(discountRow);

                            // Update Total
                            $('#total-amount').text(new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(response.new_total));

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
