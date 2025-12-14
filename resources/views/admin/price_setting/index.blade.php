@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Price Settings</h1>
            </div>

            <div class="px-6 py-4">
                <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin_price_setting_update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">General Pricing</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Individual Visa Rate (IDR)</label>
                                <input type="number" name="individual_visa_rate"
                                    value="{{ $setting->individual_visa_rate }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Group Visa Rate (IDR)</label>
                                <input type="number" name="group_visa_rate" value="{{ $setting->group_visa_rate }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tax Percentage (%)</label>
                                <input type="number" step="0.1" name="tax_percentage"
                                    value="{{ $setting->tax_percentage }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Group Discounts</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Discount Threshold (Pax)</label>
                                <input type="number" name="group_discount_threshold"
                                    value="{{ $setting->group_discount_threshold }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Minimum travelers to trigger discount.</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Discount Percentage (%)</label>
                                <input type="number" step="0.1" name="group_discount_percentage"
                                    value="{{ $setting->group_discount_percentage }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
