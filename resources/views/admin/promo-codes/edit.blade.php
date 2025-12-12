@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Promo Code</h1>
                <a href="{{ route('admin_promo_codes_index') }}">
                    <button class="bg-gray-500 text-white rounded-lg px-4 py-2 hover:bg-gray-600 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                </a>
            </div>

            <div class="bg-white p-6 rounded-sm shadow-md">
                <form action="{{ route('admin_promo_codes_update', $promoCode->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Code *</label>
                            <input type="text" name="code" value="{{ old('code', $promoCode->code) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., SUMMER2024">
                            @error('code')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $promoCode->name) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description', $promoCode->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                            <select name="type" id="promoType" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="percentage"
                                    {{ old('type', $promoCode->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)
                                </option>
                                <option value="fixed" {{ old('type', $promoCode->type) == 'fixed' ? 'selected' : '' }}>
                                    Fixed Amount (Rp)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value *</label>
                            <input type="number" name="value" value="{{ old('value', $promoCode->value) }}"
                                step="0.01" min="0" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Min Transaction Amount</label>
                            <input type="number" name="min_transaction"
                                value="{{ old('min_transaction', $promoCode->min_transaction) }}" step="0.01"
                                min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Discount Amount</label>
                            <input type="number" name="max_discount"
                                value="{{ old('max_discount', $promoCode->max_discount) }}" step="0.01" min="0"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Usage Limit (leave empty for
                                unlimited)</label>
                            <input type="number" name="usage_limit"
                                value="{{ old('usage_limit', $promoCode->usage_limit) }}" min="1"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Per User Limit *</label>
                            <input type="number" name="per_user_limit"
                                value="{{ old('per_user_limit', $promoCode->per_user_limit) }}" min="1" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                            <input type="datetime-local" name="start_date"
                                value="{{ old('start_date', $promoCode->start_date->format('Y-m-d\TH:i')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date *</label>
                            <input type="datetime-local" name="end_date"
                                value="{{ old('end_date', $promoCode->end_date->format('Y-m-d\TH:i')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Applicable To *</label>
                            <select name="applicable_to" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="all"
                                    {{ old('applicable_to', $promoCode->applicable_to) == 'all' ? 'selected' : '' }}>All
                                    Bookings</option>
                                <option value="destinations"
                                    {{ old('applicable_to', $promoCode->applicable_to) == 'destinations' ? 'selected' : '' }}>
                                    Destinations Only</option>
                                <option value="hotels"
                                    {{ old('applicable_to', $promoCode->applicable_to) == 'hotels' ? 'selected' : '' }}>
                                    Hotels Only</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 rounded">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Update Promo Code
                        </button>
                        <a href="{{ route('admin_promo_codes_index') }}"
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
