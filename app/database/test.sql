SELECT * FROM books JOIN category USING (category_id);

SELECT reserved FROM books WHERE isbn = '237-348232';

SELECT book_title, username FROM reservations
JOIN books USING (isbn);