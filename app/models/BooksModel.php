<?php

class BooksModel {
    public static function getAllBooks() : array {
        return DB::queryAll(
            "SELECT isbn, book_title, book_author, year_published, category_name, username AS reserved_by, book_cover
            FROM books 
            JOIN category USING (category_id)
            LEFT JOIN reservations USING (isbn)
            ORDER BY book_title"
        );
    }

    public static function getReservedBooks(string $username) : array {
        return DB::queryAll(
            "SELECT isbn, book_title, book_author, year_published, category_name, username AS reserved_by, book_cover
            FROM reservations 
            JOIN books USING (isbn) 
            JOIN category USING (category_id) 
            WHERE username = ?
            ORDER BY book_title",
            [$username]
        ) ?: [];
    }

    public static function getAllCategories() : array {
        return DB::queryAll("SELECT * FROM category");
    }

    public static function bookExists(string $isbn) : bool {
        return DB::query("SELECT * FROM books WHERE isbn = ?", [$isbn]) !== false;
    }
    
    public static function bookReserved(string $isbn) : bool {
        return DB::query("SELECT reserved FROM books WHERE isbn = ?", [$isbn])["reserved"];
    }
    
    public static function reserveBook(string $isbn, string $username) {
        DB::query("INSERT INTO reservations (isbn, username) VALUES (?, ?)", [$isbn, $username]);
        DB::query("UPDATE books SET reserved = TRUE WHERE isbn = ?", [$isbn]);
    }
    
    public static function unreserveBook(string $isbn) {
        DB::query("DELETE FROM reservations WHERE isbn = ?", [$isbn]);
        DB::query("UPDATE books SET reserved = FALSE WHERE isbn = ?", [$isbn]);
    }
}