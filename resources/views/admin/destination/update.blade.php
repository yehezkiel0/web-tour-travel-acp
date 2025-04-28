@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex flex-row justify-between items-center rounded-sm shadow-md relative ">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Edit Destination</h1>
                <a href="{{ route('admin_destination_index') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all ease-in-out duration-300">View
                        All</button>
                </a>
            </div>
            <div class="bg-white">
                <form action="{{ route('admin_destination_update', $destination->id) }}" method="POST"
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
                            <button
                                class="bg-blue-400 hover:bg-gray-950 rounded-md py-2 px-3 text-white text-center text-sm shadow-md transition-all ease-in-out duration-300">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
