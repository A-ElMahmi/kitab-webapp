@extends('layout')

@section('title', 'Sign Up')

@section('main')

<h1>Sign Up</h1>

{!! $signUpForm->render() !!}

@endsection