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
            <form id="booking-form" action="{{ route('booking_store', $destination->slug) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-1 font-medium">
                    <div class="col-span-2 space-y-7">
                        <div class="w-full border border-gray-4 rounded-[10px] p-7 ">
                            <h3 class="text-xl mb-7 border-b border-gray-4 pb-2">Tour Details</h3>
                            <h3 class="text-xl font-semibold mb-7">{{ $destination->title }}</h3>
                            <div class="flex flex-col gap-y-5 text-sm max-w-sm">
                                <p>Type : {{ $destination->type }}</p>
                                <div class="flex items-center justify-between">
                                    <span>Start Date : {{ formatDate($destination->date_started, 'd F', true) }}</span>
                                    <span>End Date : {{ formatDate($destination->date_ended, 'd F', true) }}</span>
                                </div>
                                <p>Duration : {{ calculateDuration($destination->date_started, $destination->date_ended) }}
                                </p>
                            </div>
                        </div>
                        <div class="traveller-details w-full border border-gray-4 rounded-[10px] p-7">
                            <h3 class="text-xl mb-7">Traveller Details</h3>
                            @include('front.partials.traveller-details')
                        </div>
                        <div class="contact w-full border border-gray-4 rounded-[10px] p-7 space-y-7">
                            <div class="flex items-center space-x-7">
                                <h3 class="text-xl">Contact Details</h3>
                                <p class="text-xs text-gray-4 font-medium"><span class="text-red-500">*</span>Your
                                    booking
                                    information will be sent here</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm font-medium text-gray-3">
                                <input type="tel" name="contact_phone" placeholder="Mobile Number"
                                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none"
                                    value="{{ old('contact_phone') }}">
                                <input type="email" name="contact_email" placeholder="Email"
                                    class="w-full py-3 px-5 border-0 border-b-2 border-gray-4 focus:outline-none"
                                    value="{{ old('contact_email') }}">
                            </div>
                        </div>
                        <div class="notes w-full">
                            <div class="flex items-center space-x-4 mb-5">
                                <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_7478_3228)">
                                        <path
                                            d="M14.7514 4.357C14.9389 4.5445 15.0996 4.79897 15.2335 5.1204C15.3675 5.44182 15.4344 5.73647 15.4344 6.00432V17.5758C15.4344 17.8436 15.3407 18.0713 15.1532 18.2588C14.9657 18.4463 14.738 18.54 14.4701 18.54H0.970145C0.702288 18.54 0.474609 18.4463 0.287109 18.2588C0.0996094 18.0713 0.00585938 17.8436 0.00585938 17.5758V1.50433C0.00585938 1.23647 0.0996094 1.00879 0.287109 0.821289C0.474609 0.633789 0.702288 0.540039 0.970145 0.540039H9.97015C10.238 0.540039 10.5326 0.607004 10.8541 0.740932C11.1755 0.874861 11.43 1.03558 11.6175 1.22308L14.7514 4.357ZM10.2916 1.90611V5.6829H14.0684C14.0014 5.4887 13.9277 5.35142 13.8474 5.27107L10.7034 2.12709C10.623 2.04674 10.4858 1.97308 10.2916 1.90611ZM14.1487 17.2543V6.96861H9.97015C9.70229 6.96861 9.47461 6.87486 9.28711 6.68736C9.09961 6.49986 9.00586 6.27218 9.00586 6.00432V1.82575H1.29157V17.2543H14.1487ZM3.863 8.57575C3.863 8.482 3.89314 8.40499 3.9534 8.34473C4.01367 8.28446 4.09068 8.25432 4.18443 8.25432H11.2559C11.3496 8.25432 11.4266 8.28446 11.4869 8.34473C11.5472 8.40499 11.5773 8.482 11.5773 8.57575V9.21861C11.5773 9.31236 11.5472 9.38937 11.4869 9.44964C11.4266 9.5099 11.3496 9.54004 11.2559 9.54004H4.18443C4.09068 9.54004 4.01367 9.5099 3.9534 9.44964C3.89314 9.38937 3.863 9.31236 3.863 9.21861V8.57575ZM11.2559 10.8258C11.3496 10.8258 11.4266 10.8559 11.4869 10.9162C11.5472 10.9764 11.5773 11.0534 11.5773 11.1472V11.79C11.5773 11.8838 11.5472 11.9608 11.4869 12.0211C11.4266 12.0813 11.3496 12.1115 11.2559 12.1115H4.18443C4.09068 12.1115 4.01367 12.0813 3.9534 12.0211C3.89314 11.9608 3.863 11.8838 3.863 11.79V11.1472C3.863 11.0534 3.89314 10.9764 3.9534 10.9162C4.01367 10.8559 4.09068 10.8258 4.18443 10.8258H11.2559ZM11.2559 13.3972C11.3496 13.3972 11.4266 13.4273 11.4869 13.4876C11.5472 13.5479 11.5773 13.6249 11.5773 13.7186V14.3615C11.5773 14.4552 11.5472 14.5322 11.4869 14.5925C11.4266 14.6528 11.3496 14.6829 11.2559 14.6829H4.18443C4.09068 14.6829 4.01367 14.6528 3.9534 14.5925C3.89314 14.5322 3.863 14.4552 3.863 14.3615V13.7186C3.863 13.6249 3.89314 13.5479 3.9534 13.4876C4.01367 13.4273 4.09068 13.3972 4.18443 13.3972H11.2559Z"
                                            fill="#333333" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_7478_3228">
                                            <rect width="15.44" height="18" fill="white"
                                                transform="matrix(1 0 0 -1 0 18.54)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <h3 class="text-xl">Notes</h3>
                            </div>
                            <textarea name="notes" id="notes" cols="30" rows="10"
                                class="w-full border border-gray-4 rounded-[10px] p-7 text-sm text-gray-4 font-medium focus:outline-none"
                                placeholder="Write your additional here..."></textarea>
                        </div>
                    </div>
                    @include('front.partials.bill-details')
                </div>
            </form>
        </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection
