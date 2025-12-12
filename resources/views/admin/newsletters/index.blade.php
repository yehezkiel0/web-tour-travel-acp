@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Newsletter Subscribers</h1>
            </div>

            <div class="py-4">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-sm text-gray-600 mb-1">Total Subscribers</h3>
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($subscribers->total()) }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h3 class="text-sm text-gray-600 mb-1">Active</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ number_format(\App\Models\NewsletterSubscriber::where('is_active', true)->count()) }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-sm text-gray-600 mb-1">Unsubscribed</h3>
                                <p class="text-2xl font-bold text-gray-600">
                                    {{ number_format(\App\Models\NewsletterSubscriber::where('is_active', false)->count()) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Subscribed At</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscribers as $subscriber)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            {{ $subscriber->email }}
                                        </td>
                                        <td class="px-4 py-3">{{ $subscriber->name ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $subscriber->subscribed_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-3">
                                            @if ($subscriber->is_active)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                    Unsubscribed
                                                    @if ($subscriber->unsubscribed_at)
                                                        ({{ $subscriber->unsubscribed_at->diffForHumans() }})
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-2"></i>
                                            <p>No subscribers yet</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t">
                        {{ $subscribers->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
