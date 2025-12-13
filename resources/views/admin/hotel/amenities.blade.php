@extends('admin.layout.app')
@section('title', 'Manage Amenities - ' . $hotel->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Amenities</h1>
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

        <!-- Add Amenity Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Add New Amenity</h2>
            <form action="{{ route('admin_hotel_store_amenity', $hotel->slug) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Amenity Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amenity Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="e.g., Free WiFi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                    </div>

                    <!-- Icon Class -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Icon Class (Font Awesome)</label>
                        <input type="text" name="icon_class" value="{{ old('icon_class', 'fa-solid fa-check') }}"
                            placeholder="e.g., fa-solid fa-wifi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                        <small class="text-gray-500">Check <a href="https://fontawesome.com/icons" target="_blank"
                                class="text-blue-500">Font Awesome</a> for icons</small>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4F46E5] focus:border-transparent">
                            <option value="General" {{ old('category') == 'General' ? 'selected' : '' }}>General</option>
                            <option value="Room" {{ old('category') == 'Room' ? 'selected' : '' }}>Room</option>
                            <option value="Bathroom" {{ old('category') == 'Bathroom' ? 'selected' : '' }}>Bathroom</option>
                            <option value="Service" {{ old('category') == 'Service' ? 'selected' : '' }}>Service</option>
                            <option value="Food & Drink" {{ old('category') == 'Food & Drink' ? 'selected' : '' }}>Food &
                                Drink</option>
                            <option value="Entertainment" {{ old('category') == 'Entertainment' ? 'selected' : '' }}>
                                Entertainment</option>
                            <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business
                            </option>
                            <option value="Sports & Wellness"
                                {{ old('category') == 'Sports & Wellness' ? 'selected' : '' }}>Sports & Wellness</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-[#4F46E5] text-white rounded-lg hover:bg-[#4338CA] transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Amenity
                    </button>
                </div>
            </form>
        </div>

        <!-- Existing Amenities -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Existing Amenities ({{ $hotel->amenities->count() }})</h2>

            @if ($hotel->amenities->count() > 0)
                @php
                    $categorizedAmenities = $hotel->amenities->groupBy('category');
                @endphp

                @foreach ($categorizedAmenities as $category => $amenities)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-700 mb-3 pb-2 border-b">{{ $category ?? 'General' }}
                            ({{ $amenities->count() }})
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($amenities as $amenity)
                                <div
                                    class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-[#4F46E5] transition-colors">
                                    <div class="flex items-center gap-3">
                                        @if ($amenity->icon_class)
                                            <i class="{{ $amenity->icon_class }} text-[#4F46E5]"></i>
                                        @else
                                            <i class="fa-solid fa-check text-[#4F46E5]"></i>
                                        @endif
                                        <span class="text-sm text-gray-800">{{ $amenity->name }}</span>
                                    </div>
                                    <form action="{{ route('admin_hotel_delete_amenity', [$hotel->slug, $amenity->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this amenity?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-8">No amenities added yet. Add your first amenity using the form
                    above.</p>
            @endif
        </div>

        <!-- Quick Add Common Amenities -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Add Common Amenities</h2>
            <p class="text-gray-600 mb-4">Click to quickly add these common hotel amenities:</p>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @php
                    $commonAmenities = [
                        ['name' => 'Free WiFi', 'icon' => 'fa-solid fa-wifi', 'category' => 'General'],
                        ['name' => 'Air Conditioning', 'icon' => 'fa-solid fa-snowflake', 'category' => 'Room'],
                        [
                            'name' => 'Swimming Pool',
                            'icon' => 'fa-solid fa-person-swimming',
                            'category' => 'Sports & Wellness',
                        ],
                        [
                            'name' => 'Fitness Center',
                            'icon' => 'fa-solid fa-dumbbell',
                            'category' => 'Sports & Wellness',
                        ],
                        ['name' => '24/7 Reception', 'icon' => 'fa-solid fa-clock', 'category' => 'Service'],
                        ['name' => 'Restaurant', 'icon' => 'fa-solid fa-utensils', 'category' => 'Food & Drink'],
                        ['name' => 'Bar', 'icon' => 'fa-solid fa-martini-glass', 'category' => 'Food & Drink'],
                        ['name' => 'Room Service', 'icon' => 'fa-solid fa-bell-concierge', 'category' => 'Service'],
                        ['name' => 'Parking', 'icon' => 'fa-solid fa-square-parking', 'category' => 'General'],
                        ['name' => 'Spa', 'icon' => 'fa-solid fa-spa', 'category' => 'Sports & Wellness'],
                        ['name' => 'Airport Shuttle', 'icon' => 'fa-solid fa-van-shuttle', 'category' => 'Service'],
                        ['name' => 'Pet Friendly', 'icon' => 'fa-solid fa-paw', 'category' => 'General'],
                    ];
                @endphp

                @foreach ($commonAmenities as $amenity)
                    @php
                        $exists = $hotel->amenities->where('name', $amenity['name'])->count() > 0;
                    @endphp

                    @if (!$exists)
                        <form action="{{ route('admin_hotel_store_amenity', $hotel->slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $amenity['name'] }}">
                            <input type="hidden" name="icon_class" value="{{ $amenity['icon'] }}">
                            <input type="hidden" name="category" value="{{ $amenity['category'] }}">

                            <button type="submit"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:border-[#4F46E5] hover:bg-[#4F46E5] hover:text-white transition-colors text-sm">
                                <i class="{{ $amenity['icon'] }} mb-1"></i>
                                <div class="text-xs">{{ $amenity['name'] }}</div>
                            </button>
                        </form>
                    @else
                        <div
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-400 text-sm cursor-not-allowed">
                            <i class="{{ $amenity['icon'] }} mb-1"></i>
                            <div class="text-xs">{{ $amenity['name'] }}</div>
                            <div class="text-xs">(Added)</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
