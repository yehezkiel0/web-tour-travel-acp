@extends('admin.layout.app')
@section('title', 'Manage Rooms - ' . $hotel->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Rooms</h1>
                <p class="text-gray-600">{{ $hotel->name }}</p>
            </div>
            <a href="{{ route('admin_hotel_index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Hotels
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Room Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Add New Room</h2>
            <form action="{{ route('admin_hotel_store_room', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Room Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Type *</label>
                        <input type="text" name="room_type" value="{{ old('room_type') }}" required
                            placeholder="e.g., Deluxe Double Room"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Bed Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bed Type *</label>
                        <select name="bed_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                            <option value="">Select Bed Type</option>
                            <option value="Single Bed" {{ old('bed_type') == 'Single Bed' ? 'selected' : '' }}>Single Bed
                            </option>
                            <option value="Twin Beds" {{ old('bed_type') == 'Twin Beds' ? 'selected' : '' }}>Twin Beds
                            </option>
                            <option value="Double Bed" {{ old('bed_type') == 'Double Bed' ? 'selected' : '' }}>Double Bed
                            </option>
                            <option value="Queen Bed" {{ old('bed_type') == 'Queen Bed' ? 'selected' : '' }}>Queen Bed
                            </option>
                            <option value="King Bed" {{ old('bed_type') == 'King Bed' ? 'selected' : '' }}>King Bed
                            </option>
                        </select>
                    </div>

                    <!-- Max Guests -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Guests *</label>
                        <input type="number" name="max_guests" value="{{ old('max_guests', 2) }}" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Room Size (sqm) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Size (sqm) *</label>
                        <input type="number" name="room_size" value="{{ old('room_size') }}" required min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Price Without Breakfast -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Without Breakfast (IDR) *</label>
                        <input type="number" name="price_without_breakfast" value="{{ old('price_without_breakfast') }}"
                            required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Price With Breakfast -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price With Breakfast (IDR) *</label>
                        <input type="number" name="price_with_breakfast" value="{{ old('price_with_breakfast') }}"
                            required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Available Rooms -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Available Rooms *</label>
                        <input type="number" name="available_rooms" value="{{ old('available_rooms', 10) }}" required
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="is_available" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                            <option value="1" {{ old('is_available', 1) == 1 ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('is_available') == 0 ? 'selected' : '' }}>Not Available</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">{{ old('description') }}</textarea>
                    </div>

                    <!-- Room Photo -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Photo</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">Max size: 2MB. Format: JPG, PNG</small>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Room
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Rooms -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Existing Rooms ({{ $hotel->rooms->count() }})</h2>

            @if ($hotel->rooms->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Photo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Room Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bed Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Size</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Max Guests</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price (No Breakfast)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price (With Breakfast)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Available</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($hotel->rooms as $room)
                                <tr>
                                    <td class="px-4 py-3">
                                        @if ($room->photo)
                                            <img src="{{ asset('storage/' . $room->photo) }}"
                                                alt="{{ $room->room_type }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-bed text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $room->room_type }}</div>
                                        @if ($room->description)
                                            <div class="text-xs text-gray-500">{{ Str::limit($room->description, 50) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->bed_type }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->room_size }} m²</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->max_guests }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ formatIDR($room->price_without_breakfast) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ formatIDR($room->price_with_breakfast) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->available_rooms }}</td>
                                    <td class="px-4 py-3">
                                        @if ($room->is_available)
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Available</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Not
                                                Available</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('admin_hotel_delete_room', [$hotel->id, $room->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this room?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No rooms added yet. Add your first room using the form above.</p>
            @endif
        </div>
    </div>
@endsection
