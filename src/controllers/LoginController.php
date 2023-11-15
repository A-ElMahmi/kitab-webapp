<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController {
    public static function GET(array $attributes) : Response {
        // $redirectURL = $request->query->get("redirect");
        $redirectURL = "/login";

        return new Response('
            <form action="/login" method="post">
            <input type="hidden" name="redirect" value="' . $redirectURL .'">
            <input type="submit">
            </form>
        ');
    }

    public static function POST(Request $request) : Response {
        $_SESSION["auth"] = true;

        $redirectURL = $request->request->get("redirect");
        if ($redirectURL) {
            return new RedirectResponse(base64_decode($redirectURL));
        }

        return new Response('Logged in successfully <a href="/secret">Secret</a>');
    }
}

