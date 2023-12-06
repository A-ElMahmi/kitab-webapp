@extends('layout')

@section('title', 'Home')

@section('main')
    <form method="get">
        <input type="search" name="q">
        <input type="submit">
    </form>

    <div>
        <ul>
            <li><a @if($currentPage != 1) href="{{$currentUrl . "page=" . $currentPage-1}}" @endif>Prev</a></li>
            @for ($i = 1; $i <= $totalPages; $i++)
            <li><a @if ($i == $currentPage) style="color: red" @endif href="{{$currentUrl . "page=" . $i}}">{{$i}}</a></li>
            @endfor
            <li><a @if($currentPage != $totalPages) href="{{$currentUrl . "page=" . $currentPage+1}}" @endif>Next</a></li>
        </ul>
    </div>

    @foreach ($booksData as $book)
        @component('components.book-card', ["bookData" => $book])
        @endcomponent
    @endforeach
@endsection