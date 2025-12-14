@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Insurance Management</h1>
            </div>
            <div class="px-6 py-4">
                <div class="flex justify-end items-center mb-6">
                    <a href="{{ route('admin_insurance_create') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-sm transition-all">
                        <i class="fas fa-plus"></i> Add New Plan
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-600">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">Name</th>
                                    <th class="px-6 py-4">Type</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4">Description</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($insurances as $insurance)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $insurance->name }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $insurance->type == 'premium'
                                                ? 'bg-purple-100 text-purple-700'
                                                : ($insurance->type == 'basic'
                                                    ? 'bg-blue-100 text-blue-700'
                                                    : 'bg-green-100 text-green-700') }}">
                                                {{ ucfirst($insurance->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">IDR {{ number_format($insurance->price) }}</td>
                                        <td class="px-6 py-4 text-sm max-w-xs truncate">{{ $insurance->description }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-3">
                                                <a href="{{ route('admin_insurance_edit', $insurance->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin_insurance_destroy', $insurance->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 transition-colors">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                            <i class="fas fa-shield-alt text-4xl mb-3 opacity-50"></i>
                                            <p>No insurance plans found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($insurances->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $insurances->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
