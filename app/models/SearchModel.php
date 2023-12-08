<?php

class SearchModel {
    private static $searchStatement = 
        "SELECT isbn, book_title, book_author, year_published, category_name, username AS reserved_by, book_cover 
        FROM books 
        JOIN category USING (category_id)
        LEFT JOIN reservations USING (isbn)
        WHERE (LOWER(book_title) LIKE LOWER(?) OR LOWER(book_author) LIKE LOWER(?))";

    private static $searchStatementEnd = "ORDER BY book_title";

    public static function searchBooks(string $query) : array {
        $pattern = "%" . trim($query) . "%";
        return DB::queryAll(self::$searchStatement . self::$searchStatementEnd, [$pattern, $pattern]);
    }
    
    public static function searchBooksAndFilter(string $query, array $filters) : array {
        $pattern = "%" . trim($query) . "%";
        $condition = " AND category_id IN (" . str_repeat("?, ", count($filters) - 1) . "?)";
        return DB::queryAll(self::$searchStatement . $condition . self::$searchStatementEnd, [$pattern, $pattern, ...$filters]);
    }
}