@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex flex-row justify-between items-center rounded-sm shadow-md relative ">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Create Destination</h1>
                <a href="{{ route('admin_destination_index') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all ease-in-out duration-300">View
                        All</button>
                </a>
            </div>
            <div class="bg-white">
                <form action="{{ route('admin_destination_store') }}" method="POST"
                    class="flex flex-col gap-y-4 py-5 lg:gap-x-2 lg:px-6 px-2" enctype="multipart/form-data">
                    @csrf
                    <div class="gap-4 px-3">
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="bg-white border py-3 px-4 rounded-md"
                                value="{{ old('title') }}">
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="description">Description*</label>
                            <textarea name="description" id="description" class="h-[100px]" value="{{ old('description') }}"></textarea>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500" value="{{ old('country') }}"
                                    autocomplete="off">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500" value="{{ old('city') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="date_started">Start Date</label>
                                <input type="date" id="date_started" name="date_started"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ old('date_started') }}">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="date_ended">End Date</label>
                                <input type="date" id="date_ended" name="date_ended"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ old('date_ended') }}">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="price">Price</label>
                                <div class="flex items-center rounded-md overflow-hidden bg-white">
                                    <span class="px-6 py-3 bg-gray-100 border-[0.2px] text-gray-600 font-medium">IDR</span>
                                    <input type="text" id="price" name="price"
                                        class="w-full bg-white border rounded-r-md py-3 px-4 text-slate-500"
                                        value="{{ old('price') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="type">Type</label>
                                <select name="type" id="type"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500" value="{{ old('type') }}">
                                    <option>Open Trip</option>
                                    <option>Private Trip</option>
                                    <option>Package</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="min_people">Min Participants</label>
                                <input type="text" id="min_people" name="min_people"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ old('min_people') }}" autocomplete="off">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="max_people">Max Participants</label>
                                <input type="text" id="max_people" name="max_people"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ old('max_people') }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="flex items-center justify-center w-full mb-4">
                            <label for="image_input"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-blue-50 transition group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 group-hover:text-blue-600" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                            upload</span>
                                        or drag and drop</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 4096 KB)</p>
                                </div>
                                <input id="image_input" type="file" class="hidden" name="featured_photo"
                                    accept=".svg,.png,.jpg,.jpeg,.gif" />
                            </label>
                        </div>

                        <!-- Progress Bar -->
                        <div id="progress-container" class="hidden">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
                                    style="width: 0%"></div>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span id="progress-text">0%</span>
                                <span id="file-size"></span>
                            </div>
                        </div>

                        <!-- Preview Container -->
                        <div id="preview-container" class="hidden space-y-4">
                            <div class="relative inline-block w-52">
                                <img id="preview-image" class="w-full h-auto rounded-lg shadow-lg" src=""
                                    alt="Preview">
                                <button type="button" id="remove-image"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-sm text-gray-600" id="file-info"></div>
                        </div>
                        <div class="mt-4">
                            <button
                                class="bg-blue-400 hover:bg-gray-950 rounded-md py-2 px-3 text-white text-center text-sm shadow-md transition-all ease-in-out duration-300">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
