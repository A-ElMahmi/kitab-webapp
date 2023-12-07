<?php

use Simplex\Blade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


class MainController {
    public static function index(Request $request) : Response {
        DB::connect();

        $searchQuery = $request->query->get("q");
        $filterQuery = isset($request->query->all()["filter"]) ? $request->query->all()["filter"] : null;
        
        if ($filterQuery !== null) {
            $allBooks = SearchModel::searchBooksAndFilter($searchQuery ?? "", $filterQuery);
        } else if ($searchQuery !== null) {
            $allBooks = SearchModel::searchBooks($searchQuery);
        } else {
            $allBooks = BooksModel::getAllBooks();
        }

        $itemsToDisplay = 5;
        $totalPages = floor(count($allBooks) / $itemsToDisplay + 0.99);
        $pageNo = self::constrain($request->query->getInt("page"), 1, $totalPages);

        $books = array_slice($allBooks, ($pageNo - 1) * $itemsToDisplay, $itemsToDisplay);

        
        return Blade::render("index", [
            "booksData" => $books, 
            "currentPage" => $pageNo, 
            "totalPages" => $totalPages,
            "pageQueryAdd" => self::pageQueryAdd($request->query->all()),
            "filterQueryAdd" => self::filterQueryAdd($request->query->all()),
            "filterQueryRemove" => self::filterQueryRemove($request->query->all()),
            ...self::getCategoryList($filterQuery),
        ]);
    }
    public static function account(Request $request) : Response {
        $session = $request->getSession();
        if ($session->has("loggedIn") === false) {
            echo "Log in first";
            return new RedirectResponse("/login");
        }

        DB::connect();
        $books = BooksModel::getReservedBooks($session->get("username"));

        return Blade::render("account", ["booksData" => $books]);
    }

    private static function getCategoryList(?array $filterQuery) : array {
        $categories = BooksModel::getAllCategories();
        $appliedCategories = [];

        if ($filterQuery !== null) {
            $appliedCategories = array_filter($categories, fn($e) => in_array($e["category_id"], $filterQuery));
            $categories = array_filter($categories, fn($e) => in_array($e["category_id"], $filterQuery) === false);
        }

        return [
            "categories" => $categories,
            "appliedCategories" => $appliedCategories,
        ];
    }

    private static function pageQueryAdd(array $queryArray) : Closure {
        return function(int $pageNo) use ($queryArray) {
            $queryArray["page"] = $pageNo;
            return "?" . http_build_query($queryArray);
        };
    }

    private static function filterQueryAdd(array $queryArray) : Closure {
        return function(int $categoryId) use ($queryArray) {            
            unset($queryArray["page"]);
            
            $queryArray["filter"][] = $categoryId;
            $queryArray["filter"] = array_unique($queryArray["filter"]);

            return "?" . http_build_query($queryArray);
        };
    }

    private static function filterQueryRemove(array $queryArray) : Closure {
        return function(int $categoryId) use ($queryArray) {            
            unset($queryArray["page"]);
            $queryArray["filter"] = array_filter($queryArray["filter"] ?? [], fn($e) => $e != $categoryId);
            
            return "?" . http_build_query($queryArray);
        };
    }

    private static function constrain(int $number, int $minimum, int $maximum) : int {
        return min(max($number, $minimum), $maximum);
    }
}