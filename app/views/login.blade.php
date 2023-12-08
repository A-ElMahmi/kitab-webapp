@extends('layout')

@section('title', 'Login')

@section('main')

<div class="form-wrapper login shadow">
    <h1>Login</h1>
    
    {!! $loginForm->render() !!}

    <div class="message">Don't have an account? <a href="/signup">Sign Up</a></div>
</div>

@endsection