@yield('bookData')

<div>
    <p>{{ $bookData["category_name"] }}</p>
    <h4>{{ $bookData["book_title"] }}</h4>
    <p>
        <span>{{ $bookData["book_author"] }}</span>
        <span>{{ $bookData["year_published"] }}</span>
    </p>

    <form method="post" action="/reserve/{{ $bookData["isbn"] }}">
        <input type="submit" value="Reserve">
    </form>
</div>
