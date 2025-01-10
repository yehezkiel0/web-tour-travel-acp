@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center rounded-sm shadow-md relative">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Dashboard</h1>
            </div>
            <div class="grid xl:grid-cols-3 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded flex gap-x-4 items-center">
                    <div class="bg-blue-500 py-7 px-8 rounded-md">
                        <i class="far fa-user text-white text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-slate-400 font-normal">Total News Categories</h4>
                        <p class="text-[#34395e] font-semibold text-xl">12</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded flex gap-x-4 items-center">
                    <div class="bg-red-500 py-7 px-8 rounded-md">
                        <i class="fas fa-book-open text-white text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-slate-400 font-normal">Total News</h4>
                        <p class="text-[#34395e] font-semibold text-xl">122</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded flex gap-x-4 items-center">
                    <div class="bg-yellow-500 py-7 px-8 rounded-md">
                        <i class="fas fa-bullhorn text-white text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-slate-400 font-normal">Total Users</h4>
                        <p class="text-[#34395e] font-semibold text-xl">45</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
