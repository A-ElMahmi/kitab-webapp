@extends('layout')

@section('title', 'My Account')

@section('main')
    <h1 class="text-center">Your Reservations</h1>

    {{-- <div>
        <ul>
            <li><a @if($currentPage != 1) href="{{$pageQueryAdd($currentPage-1)}}" @endif>Prev</a></li>
            @for ($i = 1; $i <= $totalPages; $i++)
            <li><a @if ($i == $currentPage) style="color: red" @endif href="{{$pageQueryAdd($i)}}">{{$i}}</a></li>
            @endfor
            <li><a @if($currentPage != $totalPages) href="{{$pageQueryAdd($currentPage+1)}}" @endif>Next</a></li>
        </ul>
    </div> --}}

    <div class="books-container">
        @foreach ($booksData as $book)
            @component('components.book-card', ["bookData" => $book, "username" => $username])
            @endcomponent
        @endforeach
    </div>
        
    @empty($booksData)
        <div>
            <h4>No Results Found</h4>
            <img src="/graphics/no-search-results.svg" alt="No Results Graphic">
        </div>
    @endempty
@endsection