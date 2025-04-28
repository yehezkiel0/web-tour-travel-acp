@extends('front.layout.app')
@section('title', 'Login-Register - ACP Tours & Travel')
@section('content')
    <div class="container max-w-7xl mx-auto bg-white pt-14 px-8">
        <div class="container-slide w-full max-w-full h-[600px] shadow-md rounded-xl border bg-white relative">
            <div
                class="form-container container-login flex flex-col items-center gap-y-8 rounded-xl bg-white py-6 px-8 w-[50%] h-full z-[2] absolute">
                <h1 class="text-5xl font-semibold text-primary text-center py-8">
                    Login</h1>
                <form action="{{ route('login_submit') }}" class="form-login" method="POST">
                    @csrf
                    <div class=" flex flex-col gap-y-8">
                        <div class="relative text-sm">
                            <label for="email"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Email</label>
                            <img src="{{ asset('images/icon/Mail.svg') }}" class="absolute py-4 px-[32px]" alt="email">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-[400px] py-4 pl-16 text-[#616161]"
                                type="email" id="email" name="email" placeholder="email@gmail.com"
                                autocomplete="off" value="{{ old('email') }}">
                        </div>
                        <div class="relative text-sm">
                            <label for="password"
                                class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Password</label>
                            <img src="{{ asset('images/icon/Lock.svg') }}" class="absolute py-4 px-[32px]" alt="lock">
                            <input
                                class="border border-gray-300 hover:border-gray-400 rounded-full w-[400px] py-4 pl-16 text-[#616161]"
                                type="password" id="password" name="password" placeholder="enter your password"
                                autocomplete="off">
                            <i class="fa-regular fa-eye-slash absolute right-8 py-5 text-[#616161] show-password"></i>
                        </div>
                    </div>
                    <div class="flex justify-end py-5">
                        <a href="{{ route('forget_password') }}"
                            class="text-primary hover:underline transition-all ease-in-out duration-300">Forget
                            Password?</a>
                    </div>
                    <div class="flex items-center justify-center py-4 mb-2">
                        <button type="submit"
                            class="bg-primary py-3 rounded-xl text-white text-xl font-semibold px-32 tracking-[1px] hover:tracking-[3px] active:scale-95 hover:bg-primary-400 transition-all ease-in-out duration-300">Login</button>
                    </div>
                    <div class = "items-center flex flex-col w-full gap-y-7">
                        <div class = "w-full my-3">
                            <hr class = "border-[#E0E0E0]">
                            <div class="w-full flex justify-center">
                                <p class="-mt-3 text-center w-fit bg-white text-[#553922] px-2">or</p>
                            </div>
                        </div>
                        <div class = "flex gap-x-12 ">
                            <a href="#">
                                <img src="{{ asset('images/icon/Google.svg') }}"
                                    class="bg-white border  w-10 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="google">
                            </a>
                            <a href="#">
                                <img src="{{ asset('images/icon/Facebook.svg') }}"
                                    class="bg-[#1877F2] w-10 p-2 rounded-full mx-4 hover:ring-1 hover:ring-primary-900 hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="facebook">
                            </a>
                            <a href="#">
                                <img src="{{ asset('images/icon/Apple.svg') }}"
                                    class="bg-black w-10 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="apple">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div
                class="form-container container-register flex flex-col items-center gap-y-8 rounded-xl bg-white py-6 px-2 w-[50%] h-full z-[1] absolute opacity-0">
                <h1 class="text-5xl font-semibold text-primary text-center py-8">Create Account</h1>
                <form action="{{ route('register_submit') }}" class="form-register" method="POST">
                    @csrf
                    <div class=" flex flex-col gap-y-8 px-4">
                        <div class="flex flex-row gap-x-5">
                            <div class="relative text-sm">
                                <label for="name-register"
                                    class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Name</label>
                                <img src="{{ asset('images/icon/Mail.svg') }}" class="absolute py-4 px-[32px]"
                                    alt="mail">
                                <input
                                    class="border border-gray-300 hover:border-gray-400 rounded-full lg:w-[280px] py-4 pl-16 text-[#616161]"
                                    type="text" id="name-register" name="name" placeholder="Enter your name"
                                    value="{{ old('name') }}" autocomplete="off">
                            </div>
                            <div class="relative text-sm">
                                <label for="email-register"
                                    class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Email</label>
                                <img src="{{ asset('images/icon/Mail.svg') }}" class="absolute py-4 px-[32px]"
                                    alt="mail">
                                <input
                                    class="border border-gray-300 hover:border-gray-400 rounded-full lg:w-[280px] py-4 pl-16 text-[#616161]"
                                    type="email" id="email-register" name="email" placeholder="email@gmail.com"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="relative text-sm">
                                <label for="password-register"
                                    class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Password</label>
                                <img src="{{ asset('images/icon/Lock.svg') }}" class="absolute py-4 px-[32px]"
                                    alt="lock">
                                <input
                                    class="border border-gray-300 hover:border-gray-400 rounded-full lg:w-[280px] py-4 pl-16 text-[#616161]"
                                    type="password" id="password-register" name="password"
                                    placeholder="Enter your password" autocomplete="off">
                                <i class="fa-regular fa-eye-slash absolute right-5 py-5 text-[#616161] show-password"></i>
                            </div>
                            <div class="relative text-sm">
                                <label for="password-register-confirmation"
                                    class="text-[#757575] absolute left-14 -top-3 font-light bg-white px-2">Confirm
                                    Password</label>
                                <img src="{{ asset('images/icon/Lock.svg') }}" class="absolute py-4 px-[32px]"
                                    alt="lock">
                                <input
                                    class="border border-gray-300 hover:border-gray-400 rounded-full lg:w-[280px] py-4 pl-16 text-[#616161]"
                                    type="password" id="password-register-confirmation" name="password_confirmation"
                                    placeholder="Enter your password" autocomplete="off">
                                <i class="fa-regular fa-eye-slash absolute right-5 py-5 text-[#616161] show-password"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center pb-5 py-10 mb-2">
                        <button type="submit"
                            class="bg-primary py-3 rounded-xl text-white text-xl font-semibold px-32 tracking-[1px] hover:tracking-[3px] active:scale-95 hover:bg-primary-400 transition-all ease-in-out duration-300">Sign
                            Up</button>
                    </div>
                    <div class="items-center flex flex-col w-full gap-y-7">
                        <div class="w-full my-3">
                            <hr class="border-[#E0E0E0]">
                            <div class="w-full flex justify-center">
                                <p class="-mt-3 text-center w-fit bg-white text-[#553922] px-2">or</p>
                            </div>
                        </div>
                        <div class="flex gap-x-12 ">
                            <a href="#">
                                <img src="{{ asset('images/icon/Google.svg') }}"
                                    class="bg-white border  w-10 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="google">
                            </a>
                            <a href="#">
                                <img src="{{ asset('images/icon/Facebook.svg') }}"
                                    class="bg-[#1877F2] w-10 p-2 rounded-full mx-4 hover:ring-1 hover:ring-primary-900 hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="facebook">
                            </a>
                            <a href="#">
                                <img src="{{ asset('images/icon/Apple.svg') }}"
                                    class="bg-black w-10 p-2 rounded-full hover:ring-1 hover:ring-primary hover:scale-110 transition-all ease-in-out duration-300"
                                    alt="apple">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div id="overlay-con"
                class="overlay-container absolute top-0 left-[50%] w-[50%] overflow-hidden h-full z-[100] rounded-xl">
                <div class="overlay relative left-[-100%] h-full w-[200%] translate-x-0">
                    <div class="overlay-panel overlay-right absolute top-0 right-0 h-full w-[50%] px-10 flex flex-col gap-y-10 justify-center items-center text-center translate-x-0"
                        style="background-image: url('/videos/login_slide.gif')">
                        <h1 class="text-white text-4xl font-bold outline-1 leading-snug text-stroke-100">
                            Your
                            Korean <br>
                            <span>Journey Awaits</span>
                        </h1>
                        <p class="text-white text-base">Don’t have an account? Sign up <br>
                            <span>and begin your journey with us!</span>
                        </p>
                        <div class="flex items-center justify-center py-5 mb-2">
                            <button id="overlay-btn-register"
                                class="bg-white py-3 px-20 rounded-[20px] text-primary text-base font-semibold border border-primary capitalize tracking-[1px] hover:tracking-[3px] focus:outline-none active:scale-95  transition-all ease-in-out duration-300">SignUp</button>
                        </div>
                    </div>
                    <div class="overlay-panel overlay-left absolute top-0 h-full w-[50%] px-10 flex flex-col gap-y-10 justify-center items-center text-center translate-x-[-20%]"
                        style="background-image: url('/videos/register_slide.gif')">
                        <h1 class="text-white text-4xl font-bold outline-1 leading-snug text-stroke-100">Welcome, <br>
                            <span>Ready for Your </span> <br>
                            <span>Next Journey?</span>
                        </h1>
                        <p class="text-white text-base">If you already have an account, <br>
                            <span>login here</span>
                        </p>
                        <div class="flex items-center justify-center py-5 mb-2">
                            <button id="overlay-btn-login"
                                class=" bg-white py-3 px-20 rounded-[20px] text-primary text-base font-semibold border border-primary capitalize tracking-[1px] hover:tracking-[3px] focus:outline-none active:scale-95 transition-all ease-in-out duration-300">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
