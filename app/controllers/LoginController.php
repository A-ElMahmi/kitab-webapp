<?php

use Framework\Blade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController {
    public static function GET(Request $request) : Response {
        $redirectURL = $request->query->get("redirect") ?? "";
        return Blade::render("login", ["redirectURL" => $redirectURL]);
    }

    public static function POST(Request $request) : Response {
        // $_SESSION["auth"] = true;

        $redirectURL = $request->request->get("redirect");
        if ($redirectURL) {
            return new RedirectResponse(base64_decode($redirectURL));
        }

        return new Response('Logged in successfully <a href="/secret">Secret</a> | <a href="/hello">Home</a>');
    }
}

