<!-- Edit Room Modal -->
<div id="editRoomModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Edit Room</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="editRoomForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Room Name/Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room Type *</label>
                    <input type="text" name="room_name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                </div>

                <!-- Bed Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bed Type *</label>
                    <select name="bed_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <option value="Single Bed">Single Bed</option>
                        <option value="Twin Beds">Twin Beds</option>
                        <option value="Double Bed">Double Bed</option>
                        <option value="Queen Bed">Queen Bed</option>
                        <option value="King Bed">King Bed</option>
                    </select>
                </div>

                <!-- Bed Count -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bed Count *</label>
                    <input type="number" name="bed_count" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                </div>

                <!-- Max Guests -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Guests *</label>
                    <input type="number" name="max_guests" required min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                </div>

                <!-- Price Without Breakfast -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Without Breakfast (IDR) *</label>
                    <input type="number" name="price_without_breakfast" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                </div>

                <!-- Price With Breakfast -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price With Breakfast (IDR) *</label>
                    <input type="number" name="price_with_breakfast" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="room_description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent"></textarea>
                </div>

                <!-- Checkboxes -->
                <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="has_breakfast" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Breakfast Included</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="free_cancellation"
                            class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Free Cancellation</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="pay_at_hotel" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Pay at Hotel</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="smoking_allowed" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Smoking Allowed</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="has_wifi" class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Free WiFi</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="has_air_conditioning"
                            class="rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Air Conditioning</span>
                    </label>
                </div>

                <!-- Room Photo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Room Photo</label>
                    <input type="file" name="room_photo" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    <small class="text-gray-500">Leave empty to keep current photo. Max 2MB.</small>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors">
                    Update Room
                </button>
            </div>
        </form>
    </div>
</div>
