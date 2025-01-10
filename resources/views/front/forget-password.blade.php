@extends('front.layout.app')

@section('content')
    <section class="container mx-auto mt-[100px] max-w-[450px] px-4">
        <div class="w-full flex flex-col bg-white border border-gray-200 rounded-lg py-6 px-8">
            <h4 class="text-center text-blue-500 text-xl font-medium mb-4">
                Forget Password
            </h4>
            <div class="py-3">
                <form method="POST" action="{{ route('forget_password_submit') }}">
                    @csrf
                    <div class="flex flex-col gap-y-6">
                        <div>
                            <input type="email"
                                class="border border-gray-300 hover:border-gray-400 rounded-lg w-full py-2 px-4 text-sm"
                                name="email" placeholder="Email Address" autocomplete="off" />
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-primary text-white text-sm font-semibold py-3 px-4 rounded-lg w-full hover:bg-primary-400 focus:outline-blue-300 shadow-md transform duration-300">
                                Send Password Reset Link
                            </button>
                        </div>
                        <div class="text-start text-sm">
                            <a href="{{ route('login_register') }}" class="text-blue-500 underline">
                                Back to login page
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
