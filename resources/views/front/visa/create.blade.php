@extends('front.layout.app')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
            @include('front.profile.sidebar')

            {{-- Content --}}
            <div class="w-full md:w-3/4">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Apply for Visa Assistance</h1>
                    <p class="text-gray-500">Submit your documents and let us handle your visa process.</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <form action="{{ route('visa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Country Selection --}}
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Target
                                    Country</label>
                                <select name="country" id="country"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                    <option value="">Select Country</option>
                                    <option value="Japan">Japan</option>
                                    <option value="South Korea">South Korea</option>
                                    <option value="China">China</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Europe (Schengen)">Europe (Schengen)</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="USA">USA</option>
                                </select>
                                @error('country')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Visa Type --}}
                            <div>
                                <label for="visa_type" class="block text-sm font-medium text-gray-700 mb-2">Visa
                                    Type</label>
                                <select name="visa_type" id="visa_type"
                                    class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                    <option value="Tourist">Tourist</option>
                                    <option value="Business">Business</option>
                                    <option value="Student">Student</option>
                                </select>
                                @error('visa_type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <h3 class="text-lg font-semibold text-gray-800">Required Documents</h3>

                        <div class="space-y-4">
                            {{-- Passport --}}
                            <div>
                                <label for="passport" class="block text-sm font-medium text-gray-700 mb-2">Passport Scan
                                    (Bio Page)</label>
                                <input type="file" name="passport" id="passport" accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary hover:file:bg-primary-100">
                                <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG up to 2MB.</p>
                                @error('passport')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Photo --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Recent Photo
                                    (White Background)</label>
                                <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary hover:file:bg-primary-100">
                                @error('photo')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Bank Statement --}}
                            <div>
                                <label for="bank_statement" class="block text-sm font-medium text-gray-700 mb-2">Bank
                                    Statement (Last 3 Months)</label>
                                <input type="file" name="bank_statement" id="bank_statement"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary hover:file:bg-primary-100">
                                @error('bank_statement')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit"
                                class="bg-primary hover:bg-primary-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('front.layout.footer')
@endsection
