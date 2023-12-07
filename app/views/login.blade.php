@extends('layout')

@section('title', 'Login')

@section('main')

<h1>Login</h1>

{!! $loginForm->render() !!}

@endsection