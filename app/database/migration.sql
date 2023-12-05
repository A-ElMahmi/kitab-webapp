DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS users;

CREATE TABLE users(
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(30) UNIQUE NOT NULL,
    password VARCHAR(60) NOT NULL,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    address_line_1 VARCHAR(30) NOT NULL,
    address_line_2 VARCHAR(30) NOT NULL,
    address_city VARCHAR(30) NOT NULL,
    telephone VARCHAR(10) NOT NULL,
    mobile_number VARCHAR(10) NOT NULL
);

CREATE TABLE category(
    category_id SERIAL PRIMARY KEY,
    category_name VARCHAR(30) NOT NULL
);

CREATE TABLE books(
    isbn VARCHAR(10) PRIMARY KEY,
    book_title VARCHAR(50) NOT NULL,
    book_cover VARCHAR(100),
    book_author VARCHAR(50) NOT NULL,
    year_published INT NOT NULL,
    category_id INT REFERENCES category(category_id) NOT NULL,
    reserved BOOLEAN DEFAULT FALSE NOT NULL
);

CREATE TABLE reservations(
    isbn VARCHAR(10) REFERENCES books(isbn) NOT NULL,
    username VARCHAR(30) REFERENCES users(username) NOT NULL,
    reserved_date TIMESTAMP DEFAULT NOW() NOT NULL,
    PRIMARY KEY (isbn, username)
);
