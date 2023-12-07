<?php

class SearchModel {
    private static $searchStatment = 
        "SELECT * FROM books 
        JOIN category USING (category_id) 
        WHERE (LOWER(book_title) LIKE LOWER(?) OR LOWER(book_author) LIKE LOWER(?))";

    public static function searchBooks(string $query) : array {
        $pattern = "%" . trim($query) . "%";
        return DB::queryAll(self::$searchStatment, [$pattern, $pattern]);
    }
    
    public static function searchBooksAndFilter(string $query, array $filters) : array {
        $pattern = "%" . trim($query) . "%";
        $condition = " AND category_id IN (" . str_repeat("?, ", count($filters) - 1) . "?)";
        return DB::queryAll(self::$searchStatment . $condition, [$pattern, $pattern, ...$filters]);
    }
}