@extends('layouts.app')

@section('title')
    Create a new post
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('content')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <form action="{{ route('images.store') }}" method="post" enctype="multipart/form-data" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf
            </form>
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="post" action="{{ route('posts.store') }}" novalidate>
                @csrf
                <div class="mb-5">
                    <label for="title" class='mb-2 block uppercase text-gray-500 font-bold'>
                        Title
                    </label>
                    <input 
                        id='title' 
                        name='title'
                        type="text"
                        placeholder="Your title"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{ old('title') }}"
                    />
                    @error('title')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="description" class='mb-2 block uppercase text-gray-500 font-bold'>
                        Description
                    </label>
                    <textarea 
                        id='description' 
                        name='description'
                        placeholder="Your description"
                        class="border p-3 w-full rounded-lg @error('description') border-red-500 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div name="mb-5"">
                    <input type="hidden" name="image" value="{{ old('image') }}">
                    @error('image')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>  
                <input type="submit" value="Create" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection
