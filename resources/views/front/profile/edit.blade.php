@extends('front.layout.app')

@section('title', 'Edit Profile - ACP Tours')

@section('content')
    @include('front.layout.nav')

    <section class="container mx-auto px-4 py-8 max-w-7xl mt-12">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar --}}
            @include('front.profile.sidebar')

            {{-- Content --}}
            <div class="w-full md:w-3/4">
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>
                    <p class="text-gray-500">Manage your account settings and personal information</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Photo Section -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center gap-6">
                                <div class="relative group">
                                    <div
                                        class="w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md bg-white">
                                        @if ($user->photo)
                                            <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}"
                                                class="w-full h-full object-cover" id="preview-photo">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100"
                                                id="default-avatar">
                                                <i class="fas fa-user text-2xl text-gray-400"></i>
                                            </div>
                                            <img src="" alt="" class="w-full h-full object-cover hidden"
                                                id="preview-photo">
                                        @endif
                                    </div>
                                    <label for="photo"
                                        class="absolute bottom-0 right-0 w-7 h-7 bg-white rounded-full shadow-sm border border-gray-200 flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-camera text-xs text-blue-600"></i>
                                    </label>
                                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                <div>
                                    <h2 class="font-bold text-gray-800 text-lg">{{ $user->name }}</h2>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Personal Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full
                                        Name</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <!-- Password -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password <span
                                        class="text-sm font-normal text-gray-500">(Optional)</span></h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="current_password"
                                            class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                        @error('current_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New
                                            Password</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                        @error('new_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="new_password_confirmation"
                                            class="block text-sm font-medium text-gray-700 mb-2">Confirm New
                                            Password</label>
                                        <input type="password" name="new_password_confirmation"
                                            id="new_password_confirmation"
                                            class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="submit"
                                    class="bg-primary hover:bg-primary-800 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
    </script>
@endsection
