@extends('front.layout.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center mx-auto bg-slate-800 px-4 py-8">
        <div class="max-w-full rounded-xl border bg-white">
            <div class="flex flex-col items-center gap-y-8 py-6 px-8">
                <h1 class="text-3xl font-semibold text-primary text-center mb-4 pt-4">
                    Create Account</h1>
                <form action="{{ route('register_submit') }}" class="form-register" method="POST">
                    @csrf
                    <div class=" flex flex-col gap-y-8">
                        <div class="relative text-xs">
                            <label for="name-register"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Name</label>
                            <img src="{{ asset('images/icon/Mail.svg') }}" class="absolute py-4 px-[32px]">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-full py-4 pl-16 text-[#616161]"
                                type="text" id="name-register" name="name" placeholder="Enter your name"
                                value="{{ old('name') }}" autocomplete="off">
                        </div>
                        <div class="relative text-xs">
                            <label for="email-register"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Email</label>
                            <img src="{{ asset('images/icon/Mail.svg') }}" class="absolute py-4 px-[32px]">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-full py-4 pl-16 text-[#616161]"
                                type="email" id="email-register" name="email" placeholder="email@gmail.com"
                                autocomplete="off">
                        </div>
                        <div class="relative text-xs">
                            <label for="password-register"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Password</label>
                            <img src="{{ asset('images/icon/Lock.svg') }}" class="absolute py-4 px-[32px]">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-full py-4 pl-16 text-[#616161]"
                                type="password" id="password-register" name="password" placeholder="Enter your password"
                                autocomplete="off">
                            <i class="fa-regular fa-eye-slash absolute right-5 py-5 text-[#616161] show-password"></i>
                        </div>
                        <div class="relative text-xs">
                            <label for="password-register-confirmation"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Confirm
                                Password</label>
                            <img src="{{ asset('images/icon/Lock.svg') }}" class="absolute py-4 px-[32px]">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-full py-4 pl-16 text-[#616161]"
                                type="password" id="password-register-confirmation" name="password_confirmation"
                                placeholder="Enter your password" autocomplete="off">
                            <i class="fa-regular fa-eye-slash absolute right-5 py-5 text-[#616161] show-password"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-center pb-5 py-10 mb-2">
                        <button type="submit"
                            class="text-sm bg-primary py-3 rounded-xl text-white font-semibold px-28 active:scale-95 hover:bg-primary-400 transition-all ease-in-out duration-300">Sign
                            Up</button>
                    </div>
                    <div class="items-center flex flex-col w-full gap-y-7">
                        <div class="w-full my-3">
                            <hr class="border-[#E0E0E0]">
                            <div class="w-full flex justify-center">
                                <p class="-mt-2.5 text-center w-fit bg-white text-[#553922] text-xs px-2">or</p>
                            </div>
                        </div>
                        <div class="flex gap-x-12">
                            <a href="#">
                                <img src="images/icon/Google.svg"
                                    class="bg-white border  w-8 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="google">
                            </a>
                            <a href="#">
                                <img src="images/icon/Facebook.svg"
                                    class="bg-[#1877F2] w-8 p-2 rounded-full mx-4 hover:ring-1 hover:ring-primary-900 hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="facebook">
                            </a>
                            <a href="#">
                                <img src="images/icon/Apple.svg"
                                    class="bg-black w-8 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="apple">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
