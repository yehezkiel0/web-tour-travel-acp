@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-6">
            {{-- Header --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Destination Transactions</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage all destination booking transactions</p>
                </div>
            </div>

            {{-- Stats Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-receipt text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $transactions->count() }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                            <i class="fa-solid fa-money-bill-wave text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp
                            {{ number_format($transactions->where('status', 'paid')->sum('total_price'), 0, ',', '.') }}
                        </h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $transactions->where('status', 'pending')->count() }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                            <i class="fa-solid fa-ban text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Cancelled/Failed</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ $transactions->whereIn('status', ['cancelled', 'failed'])->count() }}</h3>
                    </div>
                </div>
            </div>

            {{-- New Filter & Table Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Toolbar --}}
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <form class="flex-1 max-w-sm relative">
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search by Order ID..."
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                    </form>

                    <div class="flex items-center gap-3">
                        <div class="relative group">
                            <button
                                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-600">
                                <i class="fa-solid fa-filter"></i>
                                Filter Status
                            </button>
                            <!-- Dropdown can be implemented here -->
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500">
                                <th class="px-6 py-4 font-semibold">Order Details</th>
                                <th class="px-6 py-4 font-semibold">Customer</th>
                                <th class="px-6 py-4 font-semibold">Destination</th>
                                <th class="px-6 py-4 font-semibold">Amount</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-mono font-medium text-gray-900">{{ $transaction->code }}</span>
                                            <span
                                                class="text-xs text-gray-500 mt-1">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                                {{ substr($transaction->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $transaction->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $transaction->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $transaction->destination->title }}</span>
                                            <span class="text-xs text-gray-500 mt-1">
                                                <i class="fa-regular fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($transaction->from_date)->format('d M') }} -
                                                {{ \Carbon\Carbon::parse($transaction->to_date)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-primary">
                                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 capitalize">
                                            {{ $transaction->details['payment_type'] ?? 'Bank Transfer' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'paid' => 'bg-green-50 text-green-700 border-green-200',
                                                'completed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                                'failed' => 'bg-red-50 text-red-700 border-red-200',
                                            ];
                                            $colorClass =
                                                $statusColors[$transaction->status] ??
                                                'bg-gray-50 text-gray-700 border-gray-200';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#"
                                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            {{-- Custom Status Dropdown --}}
                                            <div class="relative inline-block text-left">
                                                <button type="button"
                                                    onclick="toggleDropdown('status-dropdown-{{ $transaction->id }}')"
                                                    class="p-2 text-gray-400 hover:text-primary hover:bg-blue-50 rounded-lg transition-colors focus:outline-none"
                                                    title="Update Status">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <div id="status-dropdown-{{ $transaction->id }}"
                                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 border border-gray-100 overflow-hidden transform transition-all origin-top-right">
                                                    <div class="py-1">
                                                        @foreach (['pending', 'paid', 'completed', 'cancelled', 'failed'] as $status)
                                                            <form
                                                                action="{{ route('admin.transactions.update_status', $transaction->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status"
                                                                    value="{{ $status }}">
                                                                <button type="submit"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary flex items-center justify-between group">
                                                                    <span class="capitalize">{{ $status }}</span>
                                                                    @if ($transaction->status == $status)
                                                                        <i
                                                                            class="fa-solid fa-check text-green-500 text-xs"></i>
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Button using Modal -->
                                            <button type="button"
                                                onclick="openDeleteModal('{{ route('admin.transactions.destroy', $transaction->id) }}')"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-inbox text-2xl text-gray-300"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">No transactions found</p>
                                            <p class="text-sm text-gray-400 mt-1">Try adjusting your filters or search</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{-- Pagination (if available) --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleDropdown(id) {
                // Close all other dropdowns
                document.querySelectorAll('[id^="status-dropdown-"]').forEach(el => {
                    if (el.id !== id) {
                        el.classList.add('hidden');
                    }
                });

                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const isDropdownButton = event.target.closest('button[onclick^="toggleDropdown"]');
                const isDropdownContent = event.target.closest('[id^="status-dropdown-"]');

                if (!isDropdownButton && !isDropdownContent) {
                    document.querySelectorAll('[id^="status-dropdown-"]').forEach(el => {
                        el.classList.add('hidden');
                    });
                }
            });
        </script>
    @endpush
@endsection
