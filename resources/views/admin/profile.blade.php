@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class="lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Profile</h1>
            </div>
            <div class="bg-white">
                <form action="{{ route('admin_profile_submit') }}" method="POST"
                    class="grid lg:grid-cols-12 grid-cols-2 py-5 lg:gap-x-2 gap-y-4 lg:px-6 px-2"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col px-3 gap-y-2 col-span-3">
                        <img src="{{ asset('uploads/' . Auth::guard('admin')->user()->photo) }}" alt="">
                        <input type="file" name="photo" class="text-sm text-slate-500">
                    </div>
                    <div class="gap-4 px-3 col-span-9">
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" placeholder="John Doe"
                                class="bg-white border py-3 px-4 rounded-md"
                                value="{{ Auth::guard('admin')->user()->name }}">
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" placeholder="John@example.com"
                                class="bg-white border py-3 px-4 rounded-md"
                                value="{{ Auth::guard('admin')->user()->email }}">
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password"
                                class="bg-white border py-3 px-4 rounded-md text-slate-500">
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="password_confirmation">Confirmation Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="bg-white border py-3 px-4 rounded-md text-slate-500">
                        </div>
                        <div class="mb-4">
                            <button
                                class="bg-blue-400 hover:bg-gray-950 rounded-md py-2 px-3 text-white text-center text-sm shadow-md transition-all ease-in-out duration-300">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
