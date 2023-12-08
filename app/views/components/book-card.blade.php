@yield('bookData')
@yield('username')

<div class="card shadow">
    <div class="card-image">
        @if ($bookData["book_cover"] === null)
            <img src="/book-covers/placeholder.jpg" alt="Placeholder Book Cover">
        @else
            <img src="{{$bookData["book_cover"]}}" alt="Book Cover">
        @endif
    </div>

    <div class="card-content">
        <p class="category">{{ $bookData["category_name"] }}</p>
        <h4 class="title">{{ $bookData["book_title"] }}</h4>
        <p class="author-and-year">
            <span class="author">{{ $bookData["book_author"] }}</span>
            <span class="seperator">&#8226;</span>
            <span class="year">{{ $bookData["year_published"] }}</span>
        </p>
        @if ($bookData["reserved_by"] === null)
            <form method="post" action="/reserve/{{ $bookData["isbn"] }}?redirect={{base64_encode($currentUrl)}}">
                <input type="submit" value="Reserve" class="btn primary shadow">
            </form>
        @else
            @if ($bookData["reserved_by"] === $username)
                <form method="post" action="/unreserve/{{ $bookData["isbn"] }}?redirect={{base64_encode($currentUrl)}}">
                    <input type="submit" value="Cancel" class="btn secondary shadow">
                </form>
            @else
                <form>
                    <input type="submit" value="Unavailable" class="btn shadow" disabled>
                </form>
            @endif
        @endif
    </div>

</div>
