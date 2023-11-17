@extends('layout')

@section('title', 'Login')
    
@section('content')

    <form action="/login" method="post">
        <input type="hidden" name="redirect" value="{{ $redirectURL }}">
        <input type="submit">
    </form>

@endsection