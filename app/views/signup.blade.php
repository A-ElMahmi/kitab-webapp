@extends('layout')

@section('title', 'Sign Up')

@section('main')

<div class="form-wrapper signup">
    <h1>Sign Up</h1>
    
    {!! $signUpForm->render() !!}
    
    <div class="message">Already signed up? <a href="/login">Login</a></div>
</div>

@endsection