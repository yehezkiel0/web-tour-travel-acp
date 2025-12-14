@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Seasonal Pricing</h1>
            </div>

            <div class="px-6 py-4">
                {{-- Create Form --}}
                <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Add New Season</h3>
                    <form action="{{ route('admin.seasonal_pricing.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div class="md:col-span-1">
                            <label class="block text-gray-700 text-xs font-bold mb-1">Name</label>
                            <input type="text" name="name" placeholder="e.g. High Season"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-xs font-bold mb-1">Start Date</label>
                            <input type="date" name="start_date"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-xs font-bold mb-1">End Date</label>
                            <input type="date" name="end_date"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-xs font-bold mb-1">Adjustment</label>
                            <div class="flex gap-2">
                                <select name="adjustment_type" class="w-1/2 px-2 py-2 border rounded-lg text-sm bg-white">
                                    <option value="markup">Markup (+)</option>
                                    <option value="discount">Discount (-)</option>
                                </select>
                                <input type="number" step="0.1" name="percentage" placeholder="%"
                                    class="w-1/2 px-2 py-2 border rounded-lg text-sm" required>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                                <i class="fas fa-plus mr-1"></i> Add
                            </button>
                        </div>
                    </form>
                </div>

                {{-- List --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">Season Name</th>
                                    <th class="px-6 py-4">Date Range</th>
                                    <th class="px-6 py-4 text-center">Adjustment</th>
                                    <th class="px-6 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($seasons as $season)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $season->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ \Carbon\Carbon::parse($season->start_date)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($season->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($season->adjustment_type == 'markup')
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">
                                                    +{{ $season->percentage }}%
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">
                                                    -{{ $season->percentage }}%
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('admin.seasonal_pricing.destroy', $season->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this season?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                            <p>No seasonal prices set.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
