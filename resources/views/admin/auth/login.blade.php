@extends('admin.layout.app')

@section('content')
    <section class="container mx-auto mt-[100px] max-w-[450px] px-4">
        <div class="w-full flex flex-col bg-white border border-gray-200 rounded-lg py-6 px-8">
            <h4 class="text-center text-blue-500 text-xl font-medium mb-4">
                Admin Panel Login
            </h4>
            <div class="py-3">
                <form method="POST" action="{{ route('admin_login_submit') }}">
                    @csrf
                    <div class="flex flex-col gap-y-6">
                        <div>
                            <input type="email"
                                class="border border-gray-300 hover:border-gray-400 rounded-lg w-full py-2 px-4 text-sm"
                                name="email" placeholder="Email Address" autocomplete="off" />
                        </div>
                        <div>
                            <input type="password"
                                class="border border-gray-300 hover:border-gray-400 rounded-lg w-full py-2 px-4 text-sm"
                                name="password" placeholder="Password" />
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-blue-500 text-white text-sm font-semibold py-3 px-4 rounded-lg w-full hover:bg-blue-700 focus:outline-blue-300 shadow-md transform duration-300">
                                Login
                            </button>
                        </div>
                        <div class="text-start text-sm">
                            <a href="{{ route('admin_forget_password') }}" class="text-blue-500 hover:underline">
                                Forget Password?
                            </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
