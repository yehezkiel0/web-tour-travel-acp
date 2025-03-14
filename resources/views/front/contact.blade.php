@extends('front.layout.app')
@section('content')
    @include('front.layout.nav')
    <section class="container mx-auto">
        <div class="max-w-7xl mx-auto py-20">
            <div class="text-center mb-[60px] space-y-[10px]">
                <h2 class="text-[40px] font-bold text-primary">Contact Us</h2>
                <p class="text-lg font-medium text-gray-2">Any question or remarks? Just write us a message!</p>
            </div>
            <div class="flex flex-col md:flex-row items-center rounded-xl bg-white p-3 drop-shadow-lg">
                <div class="w-full md:w-2/5">
                    <div class="bg-gradient-to-r from-[#3477F6] to-[#1D4187] rounded-md p-10 relative overflow-hidden">
                        <div class="space-y-2.5 text-white mb-[60px]">
                            <h3 class="text-[28px] font-semibold">Contact Information</h3>
                            <p>Questions, comments, or suggestions? Simply fill in the form and we’ll be in touch shortly.
                            </p>
                        </div>
                        <div class="flex flex-col gap-7 mb-28">
                            {{-- list contact --}}
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg width="24" height="27" viewBox="0 0 24 27" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21 13C21 20 12 26 12 26C12 26 3 20 3 13C3 10.6131 3.94821 8.32387 5.63604 6.63604C7.32387 4.94821 9.61305 4 12 4C14.3869 4 16.6761 4.94821 18.364 6.63604C20.0518 8.32387 21 10.6131 21 13Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="space-y-2.5 text-white font-medium">
                                    <h4 class="text-xl">Address</h4>
                                    <p class="text-sm">Jalan Balai Pustaka Timur No. 39, Rawamangun, Jakarta, Indonesia
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg width="24" height="27" viewBox="0 0 24 27" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22.0004 19.92V22.92C22.0016 23.1985 21.9445 23.4742 21.8329 23.7293C21.7214 23.9845 21.5577 24.2136 21.3525 24.4019C21.1473 24.5901 20.905 24.7335 20.6412 24.8227C20.3773 24.9119 20.0978 24.9451 19.8204 24.92C16.7433 24.5856 13.7874 23.5341 11.1904 21.85C8.77425 20.3147 6.72576 18.2662 5.19042 15.85C3.5004 13.2412 2.44866 10.271 2.12042 7.18C2.09543 6.90346 2.1283 6.62476 2.21692 6.36162C2.30555 6.09849 2.44799 5.85669 2.63519 5.65162C2.82238 5.44655 3.05023 5.28271 3.30421 5.17052C3.5582 5.05833 3.83276 5.00026 4.11042 5H7.11042C7.59573 4.99522 8.06621 5.16708 8.43418 5.48353C8.80215 5.79998 9.0425 6.23944 9.11042 6.72C9.23704 7.68006 9.47187 8.62272 9.81042 9.53C9.94497 9.88792 9.97408 10.2769 9.89433 10.6509C9.81457 11.0248 9.62928 11.3681 9.36042 11.64L8.09042 12.91C9.51398 15.4135 11.5869 17.4864 14.0904 18.91L15.3604 17.64C15.6323 17.3711 15.9756 17.1858 16.3495 17.1061C16.7235 17.0263 17.1125 17.0555 17.4704 17.19C18.3777 17.5285 19.3204 17.7634 20.2804 17.89C20.7662 17.9585 21.2098 18.2032 21.527 18.5775C21.8441 18.9518 22.0126 19.4296 22.0004 19.92Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="space-y-2.5 text-white font-medium">
                                    <h4 class="text-xl">Phone</h4>
                                    <p class="text-sm">(+62)812-8377-7765
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg width="24" height="27" viewBox="0 0 24 27" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 7H20C21.1 7 22 7.9 22 9V21C22 22.1 21.1 23 20 23H4C2.9 23 2 22.1 2 21V9C2 7.9 2.9 7 4 7Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M22 9L12 16L2 9" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="space-y-2.5 text-white font-medium">
                                    <h4 class="text-xl">Email</h4>
                                    <p class="text-sm">anugrahcahayapelangi@gmail.com
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <a href="#">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" rx="15" fill="#FFCB55" />
                                    <path
                                        d="M19.2859 7.85712H17.143C16.1958 7.85712 15.2874 8.23339 14.6176 8.90316C13.9478 9.57294 13.5716 10.4813 13.5716 11.4285V13.5714H11.4287V16.4285H13.5716V22.1428H16.4287V16.4285H18.5716L19.2859 13.5714H16.4287V11.4285C16.4287 11.2391 16.504 11.0574 16.6379 10.9235C16.7719 10.7895 16.9536 10.7143 17.143 10.7143H19.2859V7.85712Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <a href="#">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="30" height="30" rx="15" fill="#FFCB55" />
                                    <g clip-path="url(#clip0_7909_7516)">
                                        <path
                                            d="M18.5717 7.85712H11.4289C9.4564 7.85712 7.85742 9.4561 7.85742 11.4285V18.5714C7.85742 20.5438 9.4564 22.1428 11.4289 22.1428H18.5717C20.5442 22.1428 22.1431 20.5438 22.1431 18.5714V11.4285C22.1431 9.4561 20.5442 7.85712 18.5717 7.85712Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M17.8572 14.55C17.9454 15.1444 17.8438 15.7516 17.567 16.285C17.2903 16.8184 16.8523 17.251 16.3155 17.5212C15.7787 17.7914 15.1704 17.8854 14.5771 17.7899C13.9837 17.6945 13.4356 17.4143 13.0107 16.9894C12.5857 16.5644 12.3056 16.0163 12.2101 15.423C12.1146 14.8297 12.2087 14.2213 12.4789 13.6845C12.7491 13.1477 13.1816 12.7098 13.7151 12.433C14.2485 12.1562 14.8556 12.0547 15.4501 12.1428C16.0564 12.2328 16.6178 12.5153 17.0513 12.9488C17.4847 13.3822 17.7673 13.9436 17.8572 14.55Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M18.9287 11.0714H18.9359" stroke="white" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_7909_7516">
                                            <rect width="17.1429" height="17.1429" fill="white"
                                                transform="translate(6.42871 6.42856)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </div>
                        {{-- Circle 1 --}}
                        <div class="absolute right-0 bottom-0">
                            <svg width="180" height="183" viewBox="0 0 180 183" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="134.5" cy="134.5" r="134.5" fill="white" fill-opacity="0.12" />
                            </svg>
                        </div>
                        {{-- Circle 2 --}}
                        <div class="absolute md:right-20 md:bottom-[76px]">
                            <svg width="138" height="138" viewBox="0 0 138 138" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="69" cy="69" r="69" fill="#FFF9F9" fill-opacity="0.16" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-3/5">
                    <div class="px-6 py-4 md:p-[60px] flex items-center">
                        <form action="">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-11">
                                <div>
                                    <label for="first_name" class="font-medium text-gray-3 text-xs">First Name<span
                                            class="text-[#FD2D2D]">*</span></label>
                                    <input type="text" name="first_name" id="first_name"
                                        class="w-full py-2 border-0 border-b-2 border-gray-4 focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="last_name" class="font-medium text-gray-3 text-xs">Last Name<span
                                            class="text-[#FD2D2D]">*</span></label>
                                    <input type="text" name="last_name" id="last_name"
                                        class="w-full py-2 border-0 border-b-2 border-gray-4 focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="email" class="font-medium text-gray-3 text-xs">Email<span
                                            class="text-[#FD2D2D]">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="w-full py-2 border-0 border-b-2 border-gray-4 focus:outline-none" required>
                                </div>
                                <div>
                                    <label for="phone_number" class="font-medium text-gray-3 text-xs">Phone Number<span
                                            class="text-[#FD2D2D]">*</span></label>
                                    <input type="tel" name="phone_number" id="phone_number"
                                        class="w-full py-2 border-0 border-b-2 border-gray-4 focus:outline-none" required>
                                </div>
                            </div>
                            <div class="flex flex-col gap-4 mb-11">
                                <h4 class="text-sm font-semibold text-gray-1">Select Subject?</h4>
                                <div class="flex flex-wrap gap-5">
                                    <!-- Tour & Travel -->
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="subject" value="tour-travel" class="hidden" checked>
                                        <div
                                            class="w-5 h-5  rounded-full bg-[#E0E0E0] checked-bg flex items-center justify-center mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-white hidden checked-show" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-[#011C2A] text-sm">Tour & Travel</span>
                                    </label>

                                    <!-- Health & Beauty -->
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="subject" value="health-beauty" class="hidden">
                                        <div
                                            class="w-5 h-5  rounded-full bg-[#E0E0E0] checked-bg flex items-center justify-center mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-white hidden checked-show" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-[#011C2A] text-sm">Health & Beauty</span>
                                    </label>

                                    <!-- Recruitment -->
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="subject" value="recruitment" class="hidden">
                                        <div
                                            class="w-5 h-5  rounded-full bg-[#E0E0E0] checked-bg flex items-center justify-center mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-white hidden checked-show" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-[#011C2A] text-sm">Recruitment</span>
                                    </label>

                                    <!-- Entertainment -->
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="subject" value="entertainment" class="hidden">
                                        <div
                                            class="w-5 h-5  rounded-full bg-[#E0E0E0] checked-bg flex items-center justify-center mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-white hidden checked-show" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-[#011C2A] text-sm">Entertainment</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-[60px] text-[#8D8D8D]">
                                <div class="flex flex-col gap-[10px]">
                                    <label for="message" class="font-medium text-xs">Message</label>
                                    <textarea name="message" id="message" cols="10" rows="1.5"
                                        class="pb-2 border-b-2 border-[#8D8D8D] outline-none resize-none">Write your message..</textarea>
                                </div>
                            </div>
                            <button type="submit"
                                class="bg-primary py-[14px] text-sm text-white font-bold sm:py-[10px] sm:px-10 md:px-[60px] w-full rounded-[10px] border border-primary hover:bg-primary-400 transition-all ease-in-out duration-300">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.layout.footer')
@endsection

<script>
    // Event listener untuk semua radio buttons
    document.querySelectorAll('input[name="subject"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateCheckState(this);
        });
    });

    function updateCheckState(input) {
        // Hapus state checked dari semua radio buttons
        document.querySelectorAll('input[name="subject"]').forEach(radio => {
            const circle = radio.nextElementSibling;
            circle.classList.remove('bg-[#011C2A]');
            circle.classList.add('bg-[#E0E0E0]');
            const checkmark = circle.querySelector('svg');
            if (checkmark) checkmark.classList.add('hidden');
        });

        // Tambahkan state checked ke radio button yang dipilih
        const selectedCircle = input.nextElementSibling;
        selectedCircle.classList.remove('bg-[#E0E0E0]');
        selectedCircle.classList.add('bg-[#011C2A]');
        const selectedCheckmark = selectedCircle.querySelector('svg');
        if (selectedCheckmark) selectedCheckmark.classList.remove('hidden');
    }
</script>
