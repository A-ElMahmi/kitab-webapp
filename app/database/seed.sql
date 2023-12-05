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
    ('093-403992', 'Computers in Business', 'Alicia O Neill', 1997, 2),
    ('234-728729', 'Exploring Peru', 'Stephanie Birchie', 2005, 5),
    ('237-348232', 'Business Strategy', 'Joe Peppard', 2002, 2),
    ('561-486453', 'A Guide to Nutrition', 'John Thorpe', 1997, 1),
    ('156-789466', 'Cooking for Children', 'Anabelle Sharpe', 2003, 7),
    ('023-453153', 'Computers for Idiots', 'Susan O Neill', 1998, 4),
    ('512-865405', 'My Life in Pictures', 'Kevin Graham', 2004, 3),
    ('213-849532', 'The Da Vinci Code', 'Dan Brown', 2003, 8),
    ('320-051231', 'My Ranch in Texas', 'George Bush', 2005, 3),
    ('532-564128', 'How to Cook Italian Food', 'Jamie Oliver', 2005, 7),
    ('159-453120', 'Optimising your Business', 'Cleo Blair', 2001, 2),
    ('201-894655', 'Tara Road', 'Maeve Binchy', 2002, 8),
    ('845-894525', 'My Life in Bits', 'John Smith', 2001, 6),
    ('623-479984', 'Shooting History', 'Jon Snow', 2003, 5);

SELECT * FROM books;