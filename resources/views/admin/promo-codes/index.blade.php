@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Promo Codes</h1>
                <a href="{{ route('admin_promo_codes_create') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all">
                        <i class="fas fa-plus mr-2"></i>Create Promo Code
                    </button>
                </a>
            </div>

            <div class="py-4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Value</th>
                                    <th class="px-4 py-3">Usage</th>
                                    <th class="px-4 py-3">Valid Period</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promoCodes as $promo)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <span class="font-mono font-bold text-blue-600">{{ $promo->code }}</span>
                                        </td>
                                        <td class="px-4 py-3">{{ $promo->name }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $promo->type == 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $promo->type == 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($promo->min_transaction)
                                                <div class="text-xs text-gray-500">Min: Rp
                                                    {{ number_format($promo->min_transaction, 0, ',', '.') }}</div>
                                            @endif
                                            @if ($promo->max_discount)
                                                <div class="text-xs text-gray-500">Max: Rp
                                                    {{ number_format($promo->max_discount, 0, ',', '.') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm">{{ $promo->usage_count }} /
                                                {{ $promo->usage_limit ?? '∞' }}</div>
                                            <div class="text-xs text-gray-500">Per user: {{ $promo->per_user_limit }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-xs">{{ $promo->start_date->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">to {{ $promo->end_date->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($promo->is_active && $promo->isValid())
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                            @elseif(!$promo->is_active)
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Expired</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin_promo_codes_edit', $promo->id) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-edit text-lg"></i>
                                                </a>
                                                <form action="{{ route('admin_promo_codes_delete', $promo->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        onclick="return confirm('Delete this promo code?')">
                                                        <i class="fas fa-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-tag text-4xl mb-2"></i>
                                            <p>No promo codes found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t">
                        {{ $promoCodes->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
