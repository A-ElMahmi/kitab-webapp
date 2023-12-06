INSERT INTO users (username, password, firstname, lastname, address_line_1, address_line_2, address_city, telephone, mobile_number) VALUES
    ('alanjmckenna', '$2y$10$2J45GyHgvXovgFgasTIfSezRm20w6xMwBVpNoZcIJo9Vz.3.iyUOW', 'Alan', 'McKenna', '38 Cranley Road', 'Fairview', 'Dublin', '9998377', '0856625567'),
    ('joecrotty', '$2y$10$qon5Bm79W82RgMykq.wgxOGzS0.B7RTQdkCFEff8fpbHpTRGrUdq.', 'Joesph', 'Crotty', 'Apt 5 Clyde Road', 'Donnybrook', 'Dublin', '8887889', '0876654456'),
    ('tommy100', '$2y$10$BsZBOyqKuw36KvqECleOvOl0MW9t53yJ6NPFV7MbRsISnK00hDqQO', 'Tom', 'Behan', '14 Hyde Road', 'Dalkey', 'Dublin', '9983747', '0876738782');

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

INSERT INTO reservations (isbn, username, reserved_date) VALUES
    ('320-051231', 'joecrotty', '2008-10-11'),
    ('532-564128', 'tommy100', '2008-10-11');

UPDATE books SET reserved = TRUE
WHERE isbn = '320-051231' OR isbn = '532-564128';