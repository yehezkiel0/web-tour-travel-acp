<footer class="footer lg:py-16 border-t border-[#E0E0E0]">
    <div class="container w-[90%] md:w-[80%] lg:w-[90%] xl:max-w-7xl mx-auto py-8">
        <div>
            <img src="{{ asset('images/icon/Logo.svg') }}" alt="Logo-Footer" class="w-32 md:w-40 h-auto" />
            <div class="grid grid-cols-2 md:grid-cols-5 gap-10">
                <div class="col-span-1 pt-7 md:col-span-2 md:pt-10">
                    <h4 class="text-[#333333] text-xs font-normal px-0 md:w-[90%] md:text-base md:px-4">
                        {{ __('messages.footer_tagline') }}
                    </h4>
                </div>
                <div class="text-[#333333]">
                    <h3 class="font-bold text-sm mb-2 md:text-lg md:mb-6">{{ __('messages.for_beginners') }}</h3>
                    <ul class="text-xs space-y-1 md:text-base md:space-y-2">
                        <li>
                            <a href="{{ route('login_register') }}"
                                class="font-normal hover:underline">{{ __('messages.new_account') }}</a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-normal hover:underline">{{ __('messages.start_booking_travel') }}</a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-normal hover:underline">{{ __('messages.start_booking_hotels') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="text-[#333333]">
                    <h3 class="font-bold text-sm mb-2 md:text-lg md:mb-6">{{ __('messages.explore_us') }}</h3>
                    <ul class="text-xs space-y-1 md:text-base md:space-y-2">
                        <li>
                            <a href="#" class="font-normal hover:underline">{{ __('messages.our_careers') }}</a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-normal hover:underline">{{ __('messages.privacy_policy') }}</a>
                        </li>
                        <li>
                            <a href="#"
                                class="font-normal hover:underline">{{ __('messages.terms_condition') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('corporate_index') }}" class="font-normal hover:underline">Corporate
                                Travel</a>
                        </li>
                    </ul>
                </div>
                <div class="text-[#333333]">
                    <h3 class="font-bold text-sm mb-2 md:text-lg md:mb-6">{{ __('messages.connect_us') }}</h3>
                    <ul class="text-xs space-y-1 md:text-base md:space-y-2">
                        <li>
                            <a href="#" class="font-normal hover:underline">support&#64;acptours.id</a>
                        </li>
                        <li>
                            <a href="#" class="font-normal hover:underline">021 - 2208 - 1996</a>
                        </li>
                        <li>
                            <a href="#" class="font-normal hover:underline">Staycation, Kemang, Jakarta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Newsletter Subscription Section --}}
    @include('front.components.newsletter-form')

    <div class="container w-[90%] md:w-[80%] lg:w-[90%] xl:max-w-7xl mx-auto pt-12 px-4">
        <div class="flex flex-col-reverse gap-y-4 md:flex-row md:justify-between items-center">
            <p class="text-[#333333] text-xs mb-4 md:mb-0 md:text-base md:font-normal">
                &copy; 2019 &bull; {{ __('messages.rights_reserved') }} &bull; ACP Tours
            </p>
            <div class="flex flex-row gap-x-2">
                <a href="#"
                    class="rounded-full border border-[#333333] border-opacity-50 p-2 hover:border-opacity-100">
                    <img src="{{ asset('images/icon/linkedin.svg') }}" alt="linkedin">
                </a>
                <a href="#"
                    class="rounded-full border border-[#333333] border-opacity-50 p-2 hover:border-opacity-100">
                    <img src="{{ asset('images/icon/facebook-footer.svg') }}" alt="facebook">
                </a>
                <a href="#"
                    class="rounded-full border border-[#333333] border-opacity-50 p-2 hover:border-opacity-100">
                    <img src="{{ asset('images/icon/instagram.svg') }}" alt="instagram">
                </a>
                <a href="#"
                    class="rounded-full border border-[#333333] border-opacity-50 p-2 hover:border-opacity-100">
                    <img src="{{ asset('images/icon/twitter.svg') }}" alt="twitter">
                </a>
            </div>
        </div>
    </div>
</footer>
