@extends('front.layout.app')

@section('title', 'Edit Profile - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 pt-28 pb-16 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Edit Profile</h1>
                <p class="text-gray-500">Manage your account settings and personal information</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Photo Section -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-10">
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <div class="relative group">
                                <div
                                    class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg bg-white">
                                    @if ($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                            class="w-full h-full object-cover" id="preview-photo">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100"
                                            id="default-avatar">
                                            <i class="fa-solid fa-user text-4xl text-gray-400"></i>
                                        </div>
                                        <img src="" alt="" class="w-full h-full object-cover hidden"
                                            id="preview-photo">
                                    @endif
                                </div>
                                <label for="photo"
                                    class="absolute bottom-0 right-0 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors">
                                    <i class="fa-solid fa-camera text-blue-600"></i>
                                </label>
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </div>
                            <div class="text-center sm:text-left text-white">
                                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                                <p class="text-blue-100">{{ $user->email }}</p>
                                <p class="text-blue-200 text-sm mt-1">Member since {{ $user->created_at->format('M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="p-8">
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-user-pen text-blue-600"></i>
                                Personal Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full
                                        Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                        placeholder="Enter your full name">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="mb-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-lock text-blue-600"></i>
                                Change Password
                                <span class="text-sm font-normal text-gray-500">(optional)</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <div class="relative">
                                        <input type="password" name="current_password" id="current_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('current_password') border-red-500 @enderror"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('current_password')"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New
                                        Password</label>
                                    <div class="relative">
                                        <input type="password" name="new_password" id="new_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('new_password') border-red-500 @enderror"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('new_password')"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="new_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <div class="relative">
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('new_password_confirmation')"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="fa-solid fa-check"></i>
                                Save Changes
                            </button>
                            <a href="{{ route('home') }}"
                                class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-xmark"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Quick Links -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('profile.bookings') }}"
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all flex items-center gap-4 group">
                    <div
                        class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                        <i class="fa-solid fa-ticket text-blue-600 text-xl group-hover:text-white transition-colors"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">My Bookings</h4>
                        <p class="text-sm text-gray-500">View your booking history</p>
                    </div>
                    <i
                        class="fa-solid fa-chevron-right text-gray-400 ml-auto group-hover:text-blue-600 transition-colors"></i>
                </a>
                <a href="{{ route('home') }}"
                    class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all flex items-center gap-4 group">
                    <div
                        class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition-colors">
                        <i class="fa-solid fa-plane text-green-600 text-xl group-hover:text-white transition-colors"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Explore Tours</h4>
                        <p class="text-sm text-gray-500">Discover new destinations</p>
                    </div>
                    <i
                        class="fa-solid fa-chevron-right text-gray-400 ml-auto group-hover:text-green-600 transition-colors"></i>
                </a>
            </div>
        </div>
    </section>

    @include('front.layout.footer')

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-photo');
                    const defaultAvatar = document.getElementById('default-avatar');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (defaultAvatar) {
                        defaultAvatar.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling;
            const icon = button.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
