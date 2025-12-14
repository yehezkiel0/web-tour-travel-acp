@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="lg:text-2xl text-xl font-medium text-gray-700">Add New Hotel</h1>
                <a href="{{ route('admin.hotels.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hotel Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Star Rating *</label>
                            <select name="star_rating" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                <option value="">Select Rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('star_rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <input type="text" name="country" value="{{ old('country', 'South Korea') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                            <input type="number" step="any" name="latitude" value="{{ old('latitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                            <input type="number" step="any" name="longitude" value="{{ old('longitude') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">{{ old('description') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Featured Photo *</label>
                            <input type="file" name="featured_photo" accept="image/*" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Photos</label>
                            <input type="file" name="gallery_photos[]" accept="image/*" multiple
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <p class="mt-1 text-sm text-gray-500">You can select multiple photos</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.hotels.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-800">
                            Create Hotel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
