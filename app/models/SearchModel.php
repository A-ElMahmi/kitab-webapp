<?php

class SearchModel {
    private static $searchStatment = "
        SELECT * FROM books 
        JOIN category USING (category_id) 
        WHERE (LOWER(book_title) LIKE LOWER(?) OR LOWER(book_author) LIKE LOWER(?))
    ";

    public static function searchBooks(string $query) : array {
        return DB::queryAll(self::$searchStatment, ["%$query%", "%$query%"]);
    }

    public static function searchBooksAndFilter(string $query, array $filters) : array {
        $condition = " AND category_id IN (" . str_repeat("?, ", count($filters) - 1) . "?)";
        return DB::queryAll(self::$searchStatment . $condition, ["%$query%", "%$query%", ...$filters]);
    }
}