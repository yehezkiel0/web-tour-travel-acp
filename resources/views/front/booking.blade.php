@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto max-w-7xl">
        <div class="mt-14">
            <header class="mb-14">
                <h1 class="text-4xl font-bold text-center mb-14">Review Your <span class="text-primary">Booking</span></h1>
                <div class="w-full mx-auto bg-white px-10">
                    <x-stepper :steps="['Select Tour', 'Contact Details', 'Payment', 'Complete']" :current-step="2" />
                </div>
            </header>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-2">
                    <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium">
                        <h3 class="text-xl mb-7 border-b border-gray-4 pb-2">Tour Details</h3>
                        <h3 class="text-xl font-semibold mb-7">{{ $destination->title }}</h3>
                        <div class="flex flex-col gap-y-5 text-sm max-w-sm">
                            <p>Type : {{ $destination->type }}</p>
                            <div class="flex items-center justify-between">
                                <span>Start Date : {{ formatDate($destination->date_started, 'd F', true) }}</span>
                                <span>End Date : {{ formatDate($destination->date_ended, 'd F', true) }}</span>
                            </div>
                            <p>Duration : {{ calculateDuration($destination->date_started, $destination->date_ended) }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="w-full border border-gray-4 rounded-[10px] p-7 text-gray-1 font-medium">
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
                                <span class="text-center">X 0</span>
                                <span id="visa-amount" class="text-right">0</span>
                            </div>
                            <div class="group-visa  grid-cols-3 items-center hidden">
                                <span>Group Visa</span>
                                <span></span>
                                <span id="visa-amount" class="text-right">0</span>
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
                                <span>{{ formatIDR(59000000) }}</span">
                            </div>
                            <div class="tax grid grid-cols-3 items-center text-gray-2 text-xs font-medium">
                                <span>Tax</span>
                                <span class="text-center">{{ round($bookingData['tax_percentage']) }}%</span>
                                <span id= "tax-amount" class="text-right">0</span>
                            </div>
                            <div class="total flex justify-between text-xl font-semibold">
                                <span>Total Price</span>
                                <span id="total-amount">{{ formatIDR(79000000) }}</span">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
