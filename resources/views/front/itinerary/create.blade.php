@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-800">Create New Itinerary</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('itineraries.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Trip Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-3"
                                placeholder="e.g., Summer in Seoul" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description
                                (Optional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-3"
                                placeholder="What's this trip about?"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start
                                    Date</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-3">
                            </div>
                            <div>
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="w-full border-gray-300 rounded-lg focus:ring-primary focus:border-primary px-4 py-3">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('itineraries.index') }}"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">Create
                                Itinerary</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
