@extends('layouts.app')

@section('title')
    Profile: {{ $user->username }}
@endsection

@section('content')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img class="" src="{{ $user->image ? asset('profiles') . '/' . $user->image : asset('img/user.svg') }}" alt="User profile image"/>
            </div>
            <div class="md:w8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10">
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === auth()->user()->id)
                        <a href="{{ route('profile.index') }}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </a>
                        @endif                    
                    @endauth
                </div>
                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{ $user->followers->count() }} <span class="font-normal">@choice('follower|followers', $user->followers->count())</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followings->count() }} <span class="font-normal">following</span>
                </p>
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }} <span class="font-normal">Posts</span>
                </p>
                @auth
                    @if (auth()->user()->id !== $user->id)
                        @if ($user->following(auth()->user()))
                            <form action="{{ route('users.unfollow', $user) }}" method="post">
                                @csrf
                                @method('delete')
                                <input value="unfollow" type="submit" class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                            </form>
                        @else
                            <form action="{{ route('users.follow', $user) }}" method="post">
                                @csrf
                                <input value="follow" type="submit" class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer">
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Posts</h2>
        <x-post-list :posts="$posts" /> 
    </section>

@endsection