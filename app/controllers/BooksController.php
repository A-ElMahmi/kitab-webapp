<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class BooksController {
    public static function reserveBook(Request $request) : Response {
        $session = $request->getSession();
        if ($session->has("loggedIn") === false) {
            echo "Log in first";
            return new RedirectResponse("/login");
        }

        $isbn = $request->attributes->get("isbn");

        if (BooksModel::bookExists($isbn) === false) {
            echo "Book doesn't exist";
            return new RedirectResponse("/");
        }
        
        if (BooksModel::bookReserved($isbn) === true) {
            echo "Book Already reserved";
            return new RedirectResponse("/");
        }

        BooksModel::reserveBook($isbn, $session->get("username"));
        return new Response("Success. Book reserved");
    }

    public static function unreserveBook(Request $request) : Response {
        $session = $request->getSession();
        if ($session->has("loggedIn") === false) {
            echo "Log in first";
            return new RedirectResponse("/login");
        }

        $isbn = $request->attributes->get("isbn");

        if (BooksModel::bookExists($isbn) === false) {
            echo "Book doesn't exist";
            return new RedirectResponse("/");
        }
        
        if (BooksModel::bookReserved($isbn) === true) { 
            BooksModel::unreserveBook($isbn);
        }
        
        return new Response("Success. Book reservation cancelled");
    }
}