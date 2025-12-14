@extends('admin.layout.app')
@section('title', 'Manage Rooms - ' . $hotel->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Rooms</h1>
                <p class="text-gray-600">{{ $hotel->name }}</p>
            </div>
            <a href="{{ route('admin.hotels.index') }}"
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
            <form action="{{ route('admin.hotels.rooms.store', $hotel->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Room Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room Type *</label>
                        <input type="text" name="room_name" value="{{ old('room_name') }}" required
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

                    <!-- Bed Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bed Count *</label>
                        <input type="number" name="bed_count" value="{{ old('bed_count', 1) }}" required min="1"
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



                    <!-- Amenities Checkboxes -->
                    <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="has_breakfast" class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('has_breakfast') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Breakfast Included</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="free_cancellation"
                                class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('free_cancellation') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Free Cancellation</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="pay_at_hotel" class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('pay_at_hotel') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Pay at Hotel</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="smoking_allowed" class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('smoking_allowed') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Smoking Allowed</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="has_wifi" class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('has_wifi') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Free WiFi</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="has_air_conditioning"
                                class="rounded text-blue-600 focus:ring-blue-500"
                                {{ old('has_air_conditioning') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Air Conditioning</span>
                        </label>
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
                        <input type="file" name="room_photo" accept="image/*"
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
                                    Room Details</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bed Config</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Max Guests</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price (No Breakfast)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price (With Breakfast)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amenities</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($hotel->rooms as $room)
                                <tr>
                                    <td class="px-4 py-3">
                                        @if ($room->room_photo)
                                            <img src="{{ Storage::url($room->room_photo) }}"
                                                alt="{{ $room->room_type }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-bed text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $room->room_name }}</div>
                                        @if ($room->description)
                                            <div class="text-xs text-gray-500">{{ Str::limit($room->description, 50) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->bed_count }}
                                        {{ $room->bed_type }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $room->max_guests }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ formatIDR($room->price_without_breakfast) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ formatIDR($room->price_with_breakfast) }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-col gap-1">
                                            @if ($room->has_breakfast)
                                                <span
                                                    class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">Breakfast</span>
                                            @endif
                                            @if ($room->free_cancellation)
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">Free
                                                    Cancel</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" onclick="openEditModal({{ json_encode($room) }})"
                                            class="text-blue-600 hover:text-blue-900 mr-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form
                                            action="{{ route('admin.hotels.rooms.destroy', [$hotel->slug, $room->id]) }}"
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

@push('scripts')
    <script>
        function openEditModal(room) {
            const modal = document.getElementById('editRoomModal');
            const form = document.getElementById('editRoomForm');

            // Construct the update URL dynamically
            form.action = "{{ route('admin.hotels.rooms.update', ['hotel' => $hotel->slug, 'room' => ':id']) }}".replace(
                ':id', room.id);

            // Populate fields
            form.querySelector('[name="room_name"]').value = room.room_name;

            // Handle select fields
            const bedTypeSelect = form.querySelector('[name="bed_type"]');
            bedTypeSelect.value = room.bed_type;

            // If value doesn't exist in select (dynamic values?), might need logic, but standard selects should work

            form.querySelector('[name="max_guests"]').value = room.max_guests;
            form.querySelector('[name="bed_count"]').value = room.bed_count;
            form.querySelector('[name="room_description"]').value = room.room_description || '';
            form.querySelector('[name="price_without_breakfast"]').value = room.price_without_breakfast;
            form.querySelector('[name="price_with_breakfast"]').value = room.price_with_breakfast;

            // Checkboxes
            form.querySelector('[name="has_breakfast"]').checked = !!room.has_breakfast;
            form.querySelector('[name="free_cancellation"]').checked = !!room.free_cancellation;
            form.querySelector('[name="pay_at_hotel"]').checked = !!room.pay_at_hotel;
            form.querySelector('[name="smoking_allowed"]').checked = !!room.smoking_allowed;
            form.querySelector('[name="has_wifi"]').checked = !!room.has_wifi;
            form.querySelector('[name="has_air_conditioning"]').checked = !!room.has_air_conditioning;

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editRoomModal').classList.add('hidden');
        }
    </script>

    <!-- Edit Room Modal -->
    @include('admin.hotel.partials.edit-room-modal')
@endpush
