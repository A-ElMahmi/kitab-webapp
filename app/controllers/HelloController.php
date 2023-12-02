<?php

use Framework\Blade;
use Framework\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HelloController {
    public static function redirect(Request $request) : RedirectResponse {
        return new RedirectResponse("/hello");
    }

    public static function index(Request $request) : Response {
        $name = $request->attributes->get("name");
        return Blade::render("hello", ["name" => $name]);
    }
    
    public static function success(Request $request) : Response {
        return Blade::render("hello", ["name" => "success"]);
    }

    public static function test(Request $request, bool $internalRedirect = false) : Response {
        $f = new Form("login-form", $request->getSession());
        if ($internalRedirect === false) {
            $f->clearSession();
        }
        
        return Blade::render("test", ["f" => $f]);
    }
    
    public static function testPost(Request $request) : Response {
        $f = new Form("login-form", $request->getSession());
        
        if ($f->validate($request->request) === false) {
            return self::test($request, internalRedirect: true);
        }

        return new Response("Success");
    }
}
