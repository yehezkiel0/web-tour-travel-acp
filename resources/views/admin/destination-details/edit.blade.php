@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex flex-row justify-between items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit {{ $destination->title }} Details</h1>
                <a href="{{ route('admin_destination_index') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all ease-in-out duration-300">
                        View All
                    </button>
                </a>
            </div>

            <div class="bg-white p-6 rounded-sm shadow-md">
                <form action="{{ route('admin_destination_details_update', $destination->slug) }}" method="POST"
                    id="detailsForm" class="flex flex-col gap-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Itinerary Section -->
                    <div class="border rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-4">Itinerary</h2>
                        <div id="itineraryContainer" class="space-y-4">
                            @if ($destination->destination_detail && $destination->destination_detail->itinerary)
                                @php
                                    $itineraries = json_decode($destination->destination_detail->itinerary, true);
                                @endphp
                                @if (is_array($itineraries))
                                    @foreach ($itineraries as $index => $item)
                                        <div class="itinerary-item border rounded-lg p-4 relative"
                                            data-index="{{ $index }}">
                                            <button type="button"
                                                class="remove-itinerary absolute top-2 right-2 text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="flex flex-col gap-y-2">
                                                    <label class="text-sm font-medium">Day</label>
                                                    <input type="number" name="itinerary[{{ $index }}][day]"
                                                        class="border rounded-md p-2"
                                                        value="{{ $item['day'] ?? (int) $index + 1 }}" required>
                                                </div>
                                                <div class="flex flex-col gap-y-2">
                                                    <label class="text-sm font-medium">Title</label>
                                                    <input type="text" name="itinerary[{{ $index }}][title]"
                                                        class="border rounded-md p-2" value="{{ $item['title'] ?? '' }}"
                                                        required>
                                                </div>
                                                <div class="flex flex-col gap-y-2">
                                                    <label class="text-sm font-medium">Duration</label>
                                                    <input type="text" name="itinerary[{{ $index }}][duration]"
                                                        class="border rounded-md p-2" value="{{ $item['duration'] ?? '' }}"
                                                        placeholder="e.g., 70 mins">
                                                </div>
                                                <div class="flex flex-col gap-y-2">
                                                    <label class="text-sm font-medium">Alternative</label>
                                                    <input type="text"
                                                        name="itinerary[{{ $index }}][alternative]"
                                                        class="border rounded-md p-2"
                                                        value="{{ $item['alternative'] ?? '' }}">
                                                </div>
                                                <div class="flex flex-col gap-y-2 md:col-span-2">
                                                    <label class="text-sm font-medium">Description</label>
                                                    <textarea name="itinerary[{{ $index }}][description]" rows="3" class="border rounded-md p-2" required>{{ $item['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <button type="button" id="addItinerary"
                            class="mt-4 bg-green-500 text-white text-sm px-4 py-2 rounded-md hover:bg-green-600 shadow-md transition-all ease-in-out duration-300">
                            Add Day +
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Arrival Information</label>
                            <textarea name="arrival" id="arrival-textarea" rows="3" class="border rounded-md p-3">{{ $destination->destination_detail->arrival ?? old('arrival') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Departure Information</label>
                            <textarea name="departure" id="departure-textarea" rows="3" class="border rounded-md p-3">{{ $destination->destination_detail->departure ?? old('departure') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Include</label>
                            <textarea name="include" id="include-textarea" class="border rounded-md p-3">{{ $destination->destination_detail->include ?? old('include') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Exclude</label>
                            <textarea name="exclude" id="exclude-textarea" class="border rounded-md p-3">{{ $destination->destination_detail->exclude ?? old('exclude') }}</textarea>
                        </div>
                    </div>

                    <div class="flex flex-col gap-y-2">
                        <label class="text-sm font-medium">Terms and Conditions</label>
                        <textarea name="tnc" id="tnc-textarea" rows="4" class="border rounded-md p-3">{{ $destination->destination_detail->tnc ?? old('tnc') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Nearby Hotels</label>
                            <textarea name="nearby_hotel" id="nearby-textarea" rows="3" class="border rounded-md p-3">{{ $destination->destination_detail->nearby_hotel ?? old('nearby_hotel') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-y-2">
                            <label class="text-sm font-medium">Google Maps URL</label>
                            <input type="text" name="map_url" class="border rounded-md p-3"
                                value="{{ $destination->destination_detail->map_url ?? old('map_url') }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                            class="bg-blue-400 hover:bg-gray-950 rounded-md py-2 px-4 text-white text-center text-sm shadow-md transition-all ease-in-out duration-300">Update
                            Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Itinerary Item Template -->
    <template id="itineraryTemplate">
        <div class="itinerary-item border rounded-lg p-4 relative" data-index="0">
            <button type="button" class="remove-itinerary absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-y-2">
                    <label class="text-sm font-medium">Day</label>
                    <input type="number" name="itinerary[0][day]" class="border rounded-md p-2" value="1"
                        required>
                </div>
                <div class="flex flex-col gap-y-2">
                    <label class="text-sm font-medium">Title</label>
                    <input type="text" name="itinerary[0][title]" class="border rounded-md p-2" required>
                </div>
                <div class="flex flex-col gap-y-2">
                    <label class="text-sm font-medium">Duration</label>
                    <input type="text" name="itinerary[0][duration]" class="border rounded-md p-2"
                        placeholder="e.g., 70 mins">
                </div>
                <div class="flex flex-col gap-y-2">
                    <label class="text-sm font-medium">Alternative</label>
                    <input type="text" name="itinerary[0][alternative]" class="border rounded-md p-2">
                </div>
                <div class="flex flex-col gap-y-2 md:col-span-2">
                    <label class="text-sm font-medium">Description</label>
                    <textarea name="itinerary[0][description]" rows="3" class="border rounded-md p-2" required></textarea>
                </div>
            </div>
        </div>
    </template>
@endsection
