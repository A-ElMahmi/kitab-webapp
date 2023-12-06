@extends('layout')

@section('title', 'Home')

@section('main')
    <form method="get">
        <input type="search" name="q" autofocus>
        <input type="submit">
    </form>

    <div>
        <ul>
            @foreach ($appliedCategories as $category)
                <li><a href="{{$filterQueryRemove($category["category_id"])}}">{{$category["category_name"]}}</a></li>
            @endforeach
            <li>-------</li>
            @foreach ($categories as $category)
                <li><a href="{{$filterQueryAdd($category["category_id"])}}">{{$category["category_name"]}}</a></li>
            @endforeach
        </ul>
    </div>

    <div>
        <ul>
            <li><a @if($currentPage != 1) href="{{$pageQueryAdd($currentPage-1)}}" @endif>Prev</a></li>
            @for ($i = 1; $i <= $totalPages; $i++)
            <li><a @if ($i == $currentPage) style="color: red" @endif href="{{$pageQueryAdd($i)}}">{{$i}}</a></li>
            @endfor
            <li><a @if($currentPage != $totalPages) href="{{$pageQueryAdd($currentPage+1)}}" @endif>Next</a></li>
        </ul>
    </div>

    @forelse ($booksData as $book)
        @component('components.book-card', ["bookData" => $book])
        @endcomponent
    @empty
        <div>No results</div>
    @endforelse
@endsection