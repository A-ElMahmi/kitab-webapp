@extends('layout')

@section('title', 'My Account')

@section('main')
    {{-- <div>
        <ul>
            <li><a @if($currentPage != 1) href="{{$pageQueryAdd($currentPage-1)}}" @endif>Prev</a></li>
            @for ($i = 1; $i <= $totalPages; $i++)
            <li><a @if ($i == $currentPage) style="color: red" @endif href="{{$pageQueryAdd($i)}}">{{$i}}</a></li>
            @endfor
            <li><a @if($currentPage != $totalPages) href="{{$pageQueryAdd($currentPage+1)}}" @endif>Next</a></li>
        </ul>
    </div> --}}

    @forelse ($booksData as $book)
        @component('components.book-card', ["bookData" => $book])
        @endcomponent
    @empty
        <div>No results</div>
    @endforelse
@endsection