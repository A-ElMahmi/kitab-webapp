@extends('layout')

@section('title', 'Home')

@section('search-box')
    <form method="get" class="search-box shadow">
        <img src="/icons/search.svg" alt="Search Icon">
        <input type="text" name="q" value="{{$searchQuery}}" placeholder="Search by book title, author..." autofocus onfocus="this.select()">
        <input type="submit" value="Search" class="btn primary shadow">
    </form>
@endsection

@section('main')
    <div>
        <ul class="categories flex-list">
            @foreach ($appliedCategories as $category)
                <li class="selected"><a href="{{$filterQueryRemove($category["category_id"])}}">{{$category["category_name"]}}</a></li>
            @endforeach
            {{-- <li>-------</li> --}}
            @foreach ($categories as $category)
                <li><a href="{{$filterQueryAdd($category["category_id"])}}">{{$category["category_name"]}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="books-container">
        @foreach ($booksData as $book)
            @component('components.book-card', ["bookData" => $book, "username" => $username])
            @endcomponent
        @endforeach
    </div>
        
    @empty($booksData)
        <div class="text-center">
            <h1>No Results Found</h1>
            <img src="/graphics/no-search-results.svg" alt="No Results Graphic" class="center-graphic">
        </div>
    @endempty

    @if (empty($booksData) === false)        
        <div class="pagination">
            <ul class="flex-list">
                <li><a @if($currentPage != 1) href="{{$pageQueryAdd($currentPage-1)}}" @endif>
                    <img src="/icons/double-arrow-left.svg" alt="Previous Page Icon">
                </a></li>
                @for ($i = 1; $i <= $totalPages; $i++)
                <li @if ($i == $currentPage) class="selected" @endif><a href="{{$pageQueryAdd($i)}}">{{$i}}</a></li>
                @endfor
                <li><a @if($currentPage != $totalPages) href="{{$pageQueryAdd($currentPage+1)}}" @endif>
                    <img src="/icons/double-arrow-right.svg" alt="Next Page Icon">
                </a></li>
            </ul>
        </div>
    @endif

@endsection