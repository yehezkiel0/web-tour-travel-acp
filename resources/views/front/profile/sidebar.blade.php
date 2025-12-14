<div class="w-full md:w-1/4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <div
                class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-2xl overflow-hidden">
                @if ($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" class="w-full h-full object-cover">
                @else
                    {{ substr($user->name, 0, 1) }}
                @endif
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mb-6 bg-gradient-to-r from-blue-600 to-blue-500 rounded-lg p-4 text-white">
            <div class="text-xs font-medium opacity-80 mb-1">Loyalty Tier</div>
            <div class="flex justify-between items-end">
                <div class="text-xl font-bold">{{ $user->loyalty_tier ?? 'Silver' }}</div>
                <div class="text-sm"><i class="fas fa-crown text-yellow-300"></i></div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/20">
                <div class="text-xs font-medium opacity-80 mb-1">Available Points</div>
                <div class="text-2xl font-bold">{{ number_format($user->loyalty_points) }}</div>
            </div>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('profile.edit') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                <i class="fas fa-user w-5"></i> Profile
            </a>
            <a href="{{ route('profile.bookings') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('profile.bookings') || request()->routeIs('profile.booking.detail') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                <i class="fas fa-ticket-alt w-5"></i> My Bookings
            </a>
            <a href="{{ route('profile.points') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('profile.points') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                <i class="fas fa-coins w-5"></i> Loyalty Points
            </a>
            <a href="{{ route('profile.referrals') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('profile.referrals') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                <i class="fas fa-users w-5"></i> Referrals
            </a>
            <a href="{{ route('visa.index') }}"
                class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('visa.*') ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-600' }}">
                <i class="fas fa-passport w-5"></i> Visa Assistance
            </a>
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center gap-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors text-left">
                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                </button>
            </form>
        </nav>
    </div>
</div>
