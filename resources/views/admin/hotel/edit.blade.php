@extends('admin.layout.app')
@section('title', 'Edit Hotel - Admin Panel')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Hotel</h1>
            <a href="{{ route('admin_hotel_index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin_hotel_update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Hotel Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hotel Name *</label>
                        <input type="text" name="name" value="{{ old('name', $hotel->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                        <input type="text" name="country" value="{{ old('country', $hotel->country) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                        <input type="text" name="city" value="{{ old('city', $hotel->city) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                        <input type="text" name="address" value="{{ old('address', $hotel->address) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $hotel->latitude) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">For Google Maps integration</small>
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $hotel->longitude) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">For Google Maps integration</small>
                    </div>

                    <!-- Star Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Star Rating *</label>
                        <select name="star_rating" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                            <option value="">Select Rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('star_rating', $hotel->star_rating) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="is_active" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                            <option value="1" {{ old('is_active', $hotel->is_active) == 1 ? 'selected' : '' }}>Active
                            </option>
                            <option value="0" {{ old('is_active', $hotel->is_active) == 0 ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea name="description" rows="5" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">{{ old('description', $hotel->description) }}</textarea>
                    </div>

                    <!-- Current Featured Photo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Featured Photo</label>
                        @if ($hotel->featured_photo)
                            <img src="{{ asset('storage/' . $hotel->featured_photo) }}" alt="{{ $hotel->name }}"
                                class="w-64 h-40 object-cover rounded-lg mb-2">
                        @else
                            <p class="text-gray-500 mb-2">No featured photo uploaded</p>
                        @endif
                    </div>

                    <!-- Featured Photo Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Change Featured Photo</label>
                        <input type="file" name="featured_photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">Leave empty to keep current photo. Max size: 2MB. Format: JPG,
                            PNG</small>
                    </div>

                    <!-- Gallery Photos Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Add Gallery Photos</label>
                        <input type="file" name="gallery_photos[]" accept="image/*" multiple
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">You can select multiple photos. Max size per file: 2MB</small>
                    </div>

                    <!-- Existing Gallery Photos -->
                    @if ($hotel->photos->count() > 0)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Gallery Photos</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($hotel->photos as $photo)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Gallery Photo"
                                            class="w-full h-32 object-cover rounded-lg">
                                        <button type="button" onclick="deletePhoto({{ $photo->id }})"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin_hotel_index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Hotel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function deletePhoto(photoId) {
            if (confirm('Are you sure you want to delete this photo?')) {
                fetch(`/admin/hotel/photo/${photoId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to delete photo');
                        }
                    })
                    .catch(error => {
                        alert('Error deleting photo');
                    });
            }
        }
    </script>
@endsection
