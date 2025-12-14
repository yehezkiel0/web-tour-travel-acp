@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <!-- Hero Section -->
    <section class="relative py-20 bg-gray-900 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('assets/backgrounds/corporate.jpg') }}" alt=""
                class="w-full h-full object-cover opacity-30">
            <!-- Fallback color if image is missing -->
            <div class="absolute inset-0 bg-blue-900/50 mix-blend-multiply"></div>
        </div>
        <div class="relative container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Corporate & Group Travel</h1>
            <p class="text-xl max-w-2xl mx-auto">Exclusive experiences for your team, company tailored events, and large
                group bookings with special rates.</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="bg-gray-50 rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Request a Quote</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('corporate_store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Company / Group Name</label>
                            <input type="text" name="company_name" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('company_name') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                            <input type="text" name="contact_person" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('contact_person') }}">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('email') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" name="phone" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Pax</label>
                            <input type="number" name="est_pax" min="10" placeholder="Min. 10" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('est_pax') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                            <input type="date" name="trip_date" required
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                                value="{{ old('trip_date') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Special Requirements / Notes</label>
                        <textarea name="requirements" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm px-4 py-3"
                            placeholder="Tell us about your trip goals, destination preferences, or specific needs...">{{ old('requirements') }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-[1.02]">
                            Submit Inquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
