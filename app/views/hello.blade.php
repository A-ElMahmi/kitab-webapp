@extends('layout')

@section('title', 'Hello Page')

@section('content')
    
    <p>Hello {{ $name }}</p>

    <form method="post">
        <input type="submit">
    </form>

    @component('components.list', ["count" => 5]) 
    @endcomponent

@endsection