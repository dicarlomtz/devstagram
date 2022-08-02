@extends('layouts.app')

@section('title')
    Principal Website
@endsection

@section('content')
    <x-post-list :posts="$posts" /> 
@endsection