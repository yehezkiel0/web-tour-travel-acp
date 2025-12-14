@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
            @include('front.profile.sidebar')

            {{-- Content --}}
            <div class="w-full md:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">My Visa Applications</h1>
                    <a href="{{ route('visa.create') }}"
                        class="bg-primary hover:bg-primary-800 text-white font-medium py-2 px-4 rounded-lg transition-colors shadow-sm flex items-center gap-2">
                        <i class="fas fa-plus"></i> Apply New Visa
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-medium">
                                <tr>
                                    <th class="px-6 py-4">Country</th>
                                    <th class="px-6 py-4">Type</th>
                                    <th class="px-6 py-4">Applied Date</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($applications as $app)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $app->country }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $app->visa_type }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $app->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColor = 'bg-yellow-100 text-yellow-800';
                                                if ($app->status == 'approved') {
                                                    $statusColor = 'bg-green-100 text-green-800';
                                                } elseif ($app->status == 'rejected') {
                                                    $statusColor = 'bg-red-100 text-red-800';
                                                } elseif ($app->status == 'in_process') {
                                                    $statusColor = 'bg-blue-100 text-blue-800';
                                                }
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ ucfirst(str_replace('_', ' ', $app->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- <a href="{{ route('visa.show', $app->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a> --}}
                                            <span class="text-xs text-gray-400">View coming soon</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-passport text-4xl text-gray-300 mb-3"></i>
                                                <p>No visa applications found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($applications->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
