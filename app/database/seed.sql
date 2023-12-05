INSERT INTO category (category_name) VALUES
    ('Health'),
    ('Business'),
    ('Biography'),
    ('Technology'),
    ('Travel'),
    ('Self-Help'),
    ('Cookery'),
    ('Fiction');

INSERT INTO books (isbn, book_title, book_author, year_published, category_id) VALUES
    ('093-403992', 'Computers in Business', 'Alicia O Neil', 1997, 2),
    ('234-728729', 'Exploring Peru', 'Stephanie Birchie', 2005, 5),
    ('34-728729', 'Business Strategy', 'Joe Peppard', 2002, 2);

SELECT * FROM books;
