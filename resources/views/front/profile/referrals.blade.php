@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
            @include('front.profile.sidebar')

            {{-- Content --}}
            <div class="w-full md:w-3/4">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Referral Program</h1>

                {{-- My Code Section --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="space-y-2">
                            <h3 class="text-lg font-bold text-gray-800">Invite Friends & Earn Points</h3>
                            <p class="text-gray-500 text-sm">Share your unique referral code. When your friends register
                                using your code, both of you earn <span class="font-bold text-primary">50 Loyalty
                                    Points</span>!</p>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-50 p-2 rounded-lg border border-gray-200">
                            <span class="font-mono text-xl font-bold text-gray-800 px-3 tracking-widest"
                                id="referralCode">{{ $user->referral_code ?? 'Generate Now' }}</span>
                            <button onclick="copyReferralCode()"
                                class="bg-white border hover:bg-gray-50 text-primary font-medium px-4 py-2 rounded-md transition-colors shadow-sm">
                                <i class="far fa-copy mr-2"></i>Copy
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-primary text-xl">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Referrals</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $referrals->total() }}</h3>
                        </div>
                    </div>
                    {{-- Assuming 50 points per referral for simplicity calculation display --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 text-xl">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Points Earned</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($referrals->total() * 50) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">My Referrals</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Friend</th>
                                    <th class="px-6 py-4">Joined Date</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Points Earned</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($referrals as $referral)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                                    {{ substr($referral->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-800">{{ $referral->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $referral->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($referral->status)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-green-600">+50</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-user-friends text-4xl text-gray-300 mb-3"></i>
                                                <p>No referrals yet. Invite your friends!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($referrals->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $referrals->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')

    <script>
        function copyReferralCode() {
            var copyText = document.getElementById("referralCode");
            var textArea = document.createElement("textarea");
            textArea.value = copyText.innerText;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();

            iziToast.success({
                title: 'Success',
                message: 'Referral code copied to clipboard!',
                position: 'topRight'
            });
        }
    </script>
@endsection
