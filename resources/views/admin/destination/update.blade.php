@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex flex-row justify-between items-center rounded-sm shadow-md relative ">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Destination</h1>
                <a href="{{ route('admin.destinations.index') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all ease-in-out duration-300">View
                        All</button>
                </a>
            </div>
            <div class="bg-white">
                <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST"
                    class="flex flex-col gap-y-4 py-5 lg:gap-x-2 lg:px-6 px-2" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="gap-4 px-3">
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="title">Title *</label>
                            <input type="text" id="title" name="title" class="bg-white border py-3 px-4 rounded-md"
                                value="{{ $destination->title }}">
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4">
                            <label for="description">Description*</label>
                            <textarea name="description" id="textarea" class="h-[100px]">
                              {{ $destination->description }}
                            </textarea>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->country }}">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->city }}">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="latitude">Latitude</label>
                                <input type="number" step="0.00000001" id="latitude" name="latitude"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->latitude }}" placeholder="37.5665">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="longitude">Longitude</label>
                                <input type="number" step="0.00000001" id="longitude" name="longitude"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->longitude }}" placeholder="126.9780">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="date_started">Start Date</label>
                                <input type="date" id="date_started" name="date_started"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->date_started }}">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="date_ended">End Date</label>
                                <input type="date" id="date_ended" name="date_ended"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->date_ended }}">
                            </div>
                        </div>
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="price">Price</label>
                                <input type="text" id="price" name="price"
                                    class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                    value="{{ $destination->price }}">
                            </div>
                            <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                <label for="type">Type</label>
                                <select name="type" id="type"
                                    class="bg-white border border-gray-300 py-3 px-4 rounded-md text-slate-500 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    value="{{ $destination->type }}">
                                    <option value="Open Trip" {{ $destination->type == 'Open Trip' ? 'selected' : '' }}>
                                        Open Trip</option>
                                    <option value="Private Trip"
                                        {{ $destination->type == 'Private Trip' ? 'selected' : '' }}>Private Trip</option>
                                    <option value="Package" {{ $destination->type == 'Package' ? 'selected' : '' }}>Package
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-row gap-x-5">
                                <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                    <label for="min_people">Min Participants</label>
                                    <input type="text" id="min_people" name="min_people"
                                        class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                        value="{{ $destination->min_people }}">
                                </div>
                                <div class="flex flex-col gap-y-3 text-sm mb-4 w-full">
                                    <label for="max_people">Max Participants</label>
                                    <input type="text" id="max_people" name="max_people"
                                        class="bg-white border py-3 px-4 rounded-md text-slate-500"
                                        value="{{ $destination->max_people }}">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4 w-fit">
                            <label for="file_input">Existing Image</label>
                            <div>
                                <img src="{{ Storage::url($destination->featured_photo) }}"
                                    alt="{{ $destination->title }}" class="w-[200px] object-cover">
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-3 text-sm mb-4 w-fit">
                            <label for="file_input">Change Image</label>
                            <input class="block w-full  bg-white border py-3 px-4 rounded-md text-slate-500 cursor-pointer"
                                id="file_input" type="file" name="featured_photo">
                        </div>
                        <div class="mb-4">
                            @if ($destination->virtual_tour_images)
                                <div class="flex flex-col gap-y-3 text-sm mb-4">
                                    <label class="font-medium text-gray-700">Existing 360° Photos</label>
                                    <div class="flex flex-wrap gap-4">
                                        @foreach ($destination->virtual_tour_images as $image)
                                            <div class="relative group">
                                                <img src="{{ Storage::url($image) }}"
                                                    class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                                <a href="{{ Storage::url($image) }}" target="_blank"
                                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                                    <span
                                                        class="text-white opacity-0 group-hover:opacity-100 text-xs">View</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex items-center justify-center w-full mb-4">
                                <label for="virtual_tour_images"
                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-blue-50 transition group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 group-hover:text-blue-600"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Add more 360°
                                                Photos</span></p>
                                        <p class="text-xs text-gray-500">JPG/PNG (Multiple allowed)</p>
                                    </div>
                                    <input id="virtual_tour_images" type="file" class="hidden"
                                        name="virtual_tour_images[]" multiple accept=".jpg,.jpeg,.png" />
                                </label>
                            </div>
                        </div>
                        <button
                            class="bg-blue-400 hover:bg-gray-950 rounded-md py-2 px-3 text-white text-center text-sm shadow-md transition-all ease-in-out duration-300">Update</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
@endsection
