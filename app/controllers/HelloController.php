<?php

use Framework\Blade;
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

    public static function test(Request $request) : Response {
        var_dump($request->request->all());
        return Blade::render("test");
    }
}
