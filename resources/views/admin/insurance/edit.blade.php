@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Insurance Plan</h1>
            </div>

            <div class="px-6 py-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-end mb-6">
                        <a href="{{ route('admin.insurance.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                    </div>

                    <form action="{{ route('admin.insurance.update', $insurance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Plan Name</label>
                                <input type="text" name="name" value="{{ $insurance->name }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                                <select name="type"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500">
                                    <option value="basic" {{ $insurance->type == 'basic' ? 'selected' : '' }}>Basic
                                    </option>
                                    <option value="premium" {{ $insurance->type == 'premium' ? 'selected' : '' }}>Premium
                                    </option>
                                    <option value="comprehensive"
                                        {{ $insurance->type == 'comprehensive' ? 'selected' : '' }}>
                                        Comprehensive</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Price (IDR)</label>
                                <input type="number" name="price" value="{{ $insurance->price }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    required>
                            </div>

                            <div class="mb-4 md:col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                <textarea name="description" rows="4"
                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500" required>{{ $insurance->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Update Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
