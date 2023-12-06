@extends('layout')

@section('title', 'Home')

@section('main')
    <form method="get">
        <input type="search" name="q" autofocus>
        <input type="submit">
    </form>

    <div>
        <ul>
            @foreach ($categories as $category)
                {{-- <li>{{$category["category_id"]}} : {{$category["category_name"]}} : {{$filterQueryGenerator($category["category_id"])}}</li> --}}
                <li><a href="{{$filterQueryGenerator($category["category_id"])}}">{{$category["category_name"]}}</a></li>
            @endforeach
        </ul>
    </div>

    <div>
        <ul>
            <li><a @if($currentPage != 1) href="{{$pageQueryGenerator($currentPage-1)}}" @endif>Prev</a></li>
            @for ($i = 1; $i <= $totalPages; $i++)
            <li><a @if ($i == $currentPage) style="color: red" @endif href="{{$pageQueryGenerator($i)}}">{{$i}}</a></li>
            @endfor
            <li><a @if($currentPage != $totalPages) href="{{$pageQueryGenerator($currentPage+1)}}" @endif>Next</a></li>
        </ul>
    </div>

    @foreach ($booksData as $book)
        @component('components.book-card', ["bookData" => $book])
        @endcomponent
    @endforeach
@endsection