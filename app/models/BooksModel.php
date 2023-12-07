<?php

class BooksModel {
    public static function getAllBooks() : array {
        return DB::queryAll("SELECT * FROM books JOIN category USING (category_id)");
    }

    public static function getReservedBooks(string $username) : array {
        return DB::queryAll(
            "SELECT * FROM reservations 
            JOIN books USING (isbn) 
            JOIN category USING (category_id) 
            WHERE username = ?", 
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