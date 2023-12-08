SELECT * FROM books JOIN category USING (category_id);

SELECT reserved FROM books WHERE isbn = '237-348232';

SELECT book_title, username FROM reservations
JOIN books USING (isbn);

SELECT * FROM users;
-- WHERE username = 'tommy100' AND password = '$2y$10$gG73L9DNMAHo6MFbhxlYUucJDjsFRYwcrH2ZcCL01WNoba5bsPJTa';

SELECT * FROM reservations;

SELECT * FROM books;