@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
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
                            <div class="text-xl font-bold">{{ $user->loyalty_tier }}</div>
                            <div class="text-sm"><i class="fas fa-crown text-yellow-300"></i></div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/20">
                            <div class="text-xs font-medium opacity-80 mb-1">Available Points</div>
                            <div class="text-2xl font-bold">{{ number_format($user->loyalty_points) }}</div>
                        </div>
                    </div>

                    <nav class="space-y-2">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-user w-5"></i> Profile
                        </a>
                        <a href="{{ route('profile.bookings') }}"
                            class="flex items-center gap-3 p-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-ticket-alt w-5"></i> My Bookings
                        </a>
                        <a href="{{ route('profile.points') }}"
                            class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 text-blue-600 font-medium">
                            <i class="fas fa-coins w-5"></i> Loyalty Points
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                class="w-full flex items-center gap-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors text-left">
                                <i class="fas fa-sign-out-alt w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- Content --}}
            <div class="w-full md:w-3/4">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Points History</h1>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Description</th>
                                    <th class="px-6 py-4">Type</th>
                                    <th class="px-6 py-4 text-right">Points</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($transactions as $trx)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $trx->description }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($trx->type == 'earn')
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Earned</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Redeemed</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span
                                                class="font-bold {{ $trx->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $trx->points > 0 ? '+' : '' }}{{ number_format($trx->points) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-coins text-4xl text-gray-300 mb-3"></i>
                                                <p>No point transactions yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($transactions->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
