@extends('admin.layout.app')
@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')
    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex flex-row justify-between items-center rounded-sm shadow-md relative ">
                <h1 class=" lg:text-2xl text-xl font-medium mt-1 text-gray-700">Photos of {{ $destination->title }}</h1>
                <a href="{{ route('admin_destination_index') }}">
                    <button
                        class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-primary-400 drop-shadow-md transition-all ease-in-out duration-300">Back
                        to Previous</button>
                </a>
            </div>
            <div class="bg-white flex flex-col rounded-sm shadow-md relative">
                <h3 class="font-medium text-xl text-center py-5">Latest Photos</h3>
                <div class="grid grid-cols-1 px-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($destination->photos as $photo)
                        <img src="{{ asset('uploads/' . $photo->photo) }}" alt=""
                            class="object-cover w-full h-48 rounded-lg">
                    @endforeach
                </div>
                <form action="{{ route('destination_photos_store', $destination->slug) }}" method="POST"
                    class="flex justify-end gap-y-4 py-5 lg:gap-x-2 lg:px-6 px-2" enctype="multipart/form-data">
                    @csrf
                    <div class="gap-4 px-3">
                        <input class="hidden" id="photos_input" type="file" name="photos[]" multiple
                            onchange="this.form.submit()" />
                        <button type="button" class="bg-primary text-white px-3 py-2 rounded hover:bg-blue-600"
                            onclick="document.getElementById('photos_input').click();">
                            <i class="fas fa-plus"></i> Upload Photos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
