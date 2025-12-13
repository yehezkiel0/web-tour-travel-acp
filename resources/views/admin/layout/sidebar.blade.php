<aside class="w-[250px] h-full fixed top-0 left-0 z-[880] transition-transform ease-in-out duration-700" id="sidebar">
    <div class="bg-white shadow-lg h-full px-3 py-2">
        <div class="p-4 text-center overflow-y-auto text-lg font-normal">
            <a href="{{ route('admin_dashboard') }}">Admin Panel</a>
        </div>
        <ul class="space-y-4 py-4 px-2">
            <li>
                <a href="{{ route('admin_dashboard') }}"
                    class="{{ Request::is('admin/dashboard') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-light text-sm">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_destination_index') }}"
                    class="{{ Request::is('admin/destination*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-plane-departure"></i>
                    <span class="font-light text-sm">Destination</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin_transaction_index') }}"
                    class="{{ Request::is('admin/transaction*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-receipt"></i>
                    <span class="font-light text-sm">Transaction</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex justify-between items-center w-full p-2 rounded-lg text-slate-500 hover:bg-gray-100 transition"
                    data-dropdown="hotel">
                    <div class="flex gap-x-3">
                        <i class="fa-solid fa-hotel"></i>
                        <span class="font-light text-sm">Hotel Management</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-500 transition-transform duration-300"></i>
                </a>
                <ul id="dropdown-hotel">
                    <li>
                        <a href="{{ route('admin_hotel_index') }}"
                            class="{{ Request::is('admin/hotel') || Request::is('admin/hotel/create') || Request::is('admin/hotel/*/edit') || Request::is('admin/hotel/*/rooms') || Request::is('admin/hotel/*/amenities') ? 'active' : '' }} flex items-center w-full p-2 gap-x-2 rounded-lg text-slate-500 pl-10">
                            <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            <span class="font-light text-sm">Hotels</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin_hotel_bookings') }}"
                            class="{{ Request::is('admin/hotel-bookings*') ? 'active' : '' }} flex items-center w-full p-2 gap-x-2 rounded-lg text-slate-500 pl-10">
                            <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            <span class="font-light text-sm">Bookings</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin_testimonials_index') }}"
                    class="{{ Request::is('admin/testimonials*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-comment-dots"></i>
                    <span class="font-light text-sm">Testimonials</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_reviews_index') }}"
                    class="{{ Request::is('admin/reviews*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-star"></i>
                    <span class="font-light text-sm">Reviews & Ratings</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_promo_codes_index') }}"
                    class="{{ Request::is('admin/promo-codes*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-tag"></i>
                    <span class="font-light text-sm">Promo Codes</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_newsletters_index') }}"
                    class="{{ Request::is('admin/newsletters*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="font-light text-sm">Newsletter</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_blog_index') }}"
                    class="{{ Request::is('admin/blog*') ? 'active' : '' }} flex items-center gap-x-3 p-2 rounded-lg text-slate-500">
                    <i class="fa-solid fa-newspaper"></i>
                    <span class="font-light text-sm">Blog Management</span>
                </a>
            </li>

            {{-- <li>
                <a href="#" class="flex justify-between items-center w-full p-2 text-slate-500"
                    data-dropdown="items">
                    <div class="flex gap-x-3">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="font-light text-sm">Items</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-500"></i>
                </a>
                <ul id="dropdown-items">
                    <li>
                        <a href="#" class="flex items-center w-full p-2 gap-x-2 rounded-lg text-slate-500 pl-10">
                            <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            <span class="font-light text-sm">item 1</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 gap-x-2 rounded-lg text-slate-500 pl-10">
                            <i class="fa-solid fa-chevron-right text-[12px]"></i>
                            <span class="font-light text-sm">item 2</span>
                        </a>
                    </li>
                </ul>
            </li> --}}

        </ul>
    </div>
</aside>
