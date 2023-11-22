@extends('layout')

@section('title', 'Hello Page')

@section('content')
    
    <p>Hello {{ $name }}</p>

    <form method="post">
        <input type="submit">
    </form>

    {{-- @component('components.list', ["count" => 5]) 
    @endcomponent --}}

    {{-- <img src="https://picsum.photos/400/280" alt="Random image"> --}}

    <img src="/images/aqsa.jpg" alt="Picture of Al-Aqsa mosque">
    
    <img src="/images/moon.png">

@endsection