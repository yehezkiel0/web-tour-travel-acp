@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')

    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="text-xl lg:text-2xl font-medium mt-1 text-gray-700">Visa Applications</h1>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex gap-4">
                    <form action="{{ route('admin_visa_index') }}" method="GET" class="flex gap-2 items-center">
                        <select name="status"
                            class="rounded-md border-gray-300 text-sm focus:ring-primary focus:border-primary">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_process" {{ request('status') == 'in_process' ? 'selected' : '' }}>In Process
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-blue-600 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-700">Filter</button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-medium">
                            <tr>
                                <th class="px-6 py-4">Applicant</th>
                                <th class="px-6 py-4">Country</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($applications as $app)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $app->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $app->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $app->country }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $app->visa_type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $app->created_at->format('d M Y') }}</td>
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
                                        <a href="{{ route('admin_visa_show', $app->id) }}"
                                            class="bg-blue-100 text-blue-600 hover:bg-blue-200 px-3 py-1 rounded text-sm font-medium transition-colors">
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        No applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
