<?php

use Simplex\Blade;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MainController {
    public static function index(Request $request) : Response {
        $searchQuery = $request->query->get("q") ?? "";

        if ($searchQuery !== null) {
            $allBooks = BooksModel::searchBooks($searchQuery);
        } else {
            $allBooks = BooksModel::getAllBooks();
        }
        
        $itemsToDisplay = 5;
        $totalPages = floor(count($allBooks) / $itemsToDisplay + 0.99);
        $pageNo = self::constrain(intval($request->query->get("page")), 1, $totalPages);

        $slice = ($pageNo - 1) * $itemsToDisplay;

        $books = array_slice($allBooks, $slice, $itemsToDisplay);
        
        return Blade::render("index", [
            "booksData" => $books, 
            "currentPage" => $pageNo, 
            "totalPages" => $totalPages, 
            // "searchQueryString" => $searchQuery !== "" ? "?q=$searchQuery&filter=" : "?filter=",
            // "searchAndFilterQueryString" => $searchQuery !== "" ? "?q=$searchQuery&page=" : "?page=",
            "pageQueryGenerator" => self::pageQueryGenerator($request->getQueryString() ?? ""),
            "categories" => BooksModel::getAllCategories(),
            "filterQueryGenerator" => self::filterQueryGenerator($request->getQueryString() ?? ""),
        ]);
    }

    public static function reserveBook(Request $request) : Response {
        $isbn = $request->attributes->get("isbn");

        if (BooksModel::bookExists($isbn) === false) {
            echo "Book doesn't exist";
            return new RedirectResponse("/");
        }
        
        if (BooksModel::bookReserved($isbn) === true) {
            echo "Book Already reserved";
            return new RedirectResponse("/");
        }

        BooksModel::reserveBook($isbn, "tommy100");
        return new Response("Success. Book reserved");
    }

    public static function unreserveBook(Request $request) : Response {
        $isbn = $request->attributes->get("isbn");

        if (BooksModel::bookExists($isbn) === false) {
            echo "Book doesn't exist";
            return new RedirectResponse("/");
        }
        
        if (BooksModel::bookReserved($isbn) === true) { 
            BooksModel::unreserveBook($isbn);
        }
        
        return new Response("Success. Book reservation cancelled");
    }

    private static function pageQueryGenerator(string $queryString) : Closure {
        return function(int $pageNo) use ($queryString) {
            $queryArray = HeaderUtils::parseQuery($queryString);

            $queryArray["page"] = $pageNo;
            
            return "?" . http_build_query($queryArray);
        };
    }

    public static function filterQueryGenerator(string $queryString) : Closure {
        return function(int $categoryId) use ($queryString) {
            $queryArray = HeaderUtils::parseQuery($queryString);

            unset($queryArray["page"]);
            
            $queryArray["filter"][] = $categoryId;
            $queryArray["filter"] = array_unique($queryArray["filter"]);

            return "?" . http_build_query($queryArray);
        };
    }

    private static function constrain(int $number, int $minimum, int $maximum) : int {
        return min(max($number, $minimum), $maximum);
    }
}