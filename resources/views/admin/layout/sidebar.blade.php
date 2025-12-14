<aside class="w-[250px] h-full fixed top-0 left-0 z-[880] transition-transform ease-in-out duration-700" id="sidebar">
    <div class="bg-white shadow-lg h-full px-3 py-2">
        <div class="p-4 text-center overflow-y-auto text-lg font-normal">
            <a href="{{ route('admin_dashboard') }}">Admin Panel</a>
        </div>
        <ul class="space-y-1 py-4 px-2">

            {{-- General --}}
            <li class="px-2 pt-2 mt-2 mb-1 text-xs font-semibold text-gray-400 uppercase">General</li>
            <li>
                <a href="{{ route('admin_dashboard') }}"
                    class="{{ Request::is('admin/dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span class="font-light text-sm">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_analytics_index') }}"
                    class="{{ Request::is('admin/analytics*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i>
                    <span class="font-light text-sm">Analytics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_contact_index') }}"
                    class="{{ Request::is('admin/contacts*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-inbox w-5 text-center"></i>
                    <span class="font-light text-sm">Inbox</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_customer_index') }}"
                    class="{{ Request::is('admin/customers*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span class="font-light text-sm">Customers</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_price_setting_index') }}"
                    class="{{ Request::is('admin/price-settings*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-tags w-5 text-center"></i>
                    <span class="font-light text-sm">Price Settings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_seasonal_index') }}"
                    class="{{ Request::is('admin/seasonal-pricing*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-calendar-alt w-5 text-center"></i>
                    <span class="font-light text-sm">Seasonal Pricing</span>
                </a>
            </li>

            {{-- Travel & Destination --}}
            <li class="px-2 pt-4 mt-2 mb-1 text-xs font-semibold text-gray-400 uppercase border-t border-gray-100">
                Travel & Destination</li>
            <li>
                <a href="#"
                    class="flex justify-between items-center w-full p-2 rounded-lg text-slate-500 hover:bg-gray-50 transition"
                    data-dropdown="destination">
                    <div class="flex gap-x-3">
                        <i class="fa-solid fa-plane-departure w-5 text-center"></i>
                        <span class="font-light text-sm">Destinations</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-500 transition-transform duration-300"></i>
                </a>
                <ul id="dropdown-destination"
                    class="{{ Request::is('admin/destination*') || Request::is('admin/transaction*') ? 'block' : 'hidden' }}">
                    <li>
                        <a href="{{ route('admin_destination_index') }}"
                            class="{{ Request::is('admin/destination*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center w-full p-2 gap-x-2 rounded-lg pl-10 transition-colors">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            <span class="font-light text-sm">All Destinations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_transaction_index') }}"
                            class="{{ Request::is('admin/transaction*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center w-full p-2 gap-x-2 rounded-lg pl-10 transition-colors">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            <span class="font-light text-sm">Transactions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin_visa_index') }}"
                    class="{{ Request::is('admin/visas*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-passport w-5 text-center"></i>
                    <span class="font-light text-sm">Visa Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_insurance_index') }}"
                    class="{{ Request::is('admin/insurance*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-shield-heart w-5 text-center"></i>
                    <span class="font-light text-sm">Insurance</span>
                </a>
            </li>

            {{-- Hotel Management --}}
            <li class="px-2 pt-4 mt-2 mb-1 text-xs font-semibold text-gray-400 uppercase border-t border-gray-100">Hotel
                Management</li>
            <li>
                <a href="#"
                    class="flex justify-between items-center w-full p-2 rounded-lg text-slate-500 hover:bg-gray-50 transition"
                    data-dropdown="hotel">
                    <div class="flex gap-x-3">
                        <i class="fa-solid fa-hotel w-5 text-center"></i>
                        <span class="font-light text-sm">Hotels</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-500 transition-transform duration-300"></i>
                </a>
                <ul id="dropdown-hotel"
                    class="{{ Request::is('admin/hotel*') || Request::is('admin/hotel-bookings*') ? 'block' : 'hidden' }}">
                    <li>
                        <a href="{{ route('admin_hotel_index') }}"
                            class="{{ Request::is('admin/hotel') || Request::is('admin/hotel/create') || Request::is('admin/hotel/*/edit') || Request::is('admin/hotel/*/rooms') || Request::is('admin/hotel/*/amenities') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center w-full p-2 gap-x-2 rounded-lg pl-10 transition-colors">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            <span class="font-light text-sm">All Hotels</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_hotel_bookings') }}"
                            class="{{ Request::is('admin/hotel-bookings*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center w-full p-2 gap-x-2 rounded-lg pl-10 transition-colors">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            <span class="font-light text-sm">Bookings</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Content & Marketing --}}
            <li class="px-2 pt-4 mt-2 mb-1 text-xs font-semibold text-gray-400 uppercase border-t border-gray-100">
                Content & Marketing</li>
            <li>
                <a href="{{ route('admin_blog_index') }}"
                    class="{{ Request::is('admin/blog*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-newspaper w-5 text-center"></i>
                    <span class="font-light text-sm">Blog</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_testimonials_index') }}"
                    class="{{ Request::is('admin/testimonials*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-comment-dots w-5 text-center"></i>
                    <span class="font-light text-sm">Testimonials</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_reviews_index') }}"
                    class="{{ Request::is('admin/reviews*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-star w-5 text-center"></i>
                    <span class="font-light text-sm">Reviews</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_promo_codes_index') }}"
                    class="{{ Request::is('admin/promo-codes*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-tag w-5 text-center"></i>
                    <span class="font-light text-sm">Promo Codes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_newsletters_index') }}"
                    class="{{ Request::is('admin/newsletters*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-500 hover:bg-gray-50' }} flex items-center gap-x-3 p-2 rounded-lg transition-colors">
                    <i class="fa-solid fa-envelope w-5 text-center"></i>
                    <span class="font-light text-sm">Newsletter</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
