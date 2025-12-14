@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
            {{-- Sidebar --}}
            @include('front.profile.sidebar')

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
