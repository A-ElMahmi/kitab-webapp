<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController {
    use Framework\ControllerTrait;

    public static function index(Request $request) : Response {
        $name = $request->attributes->get("name");
        return self::renderTemplate("hello", ["name" => $name]);
    }
    
    public static function success(Request $request) : Response {
        return self::renderTemplate("hello", ["name" => "success"]);
    }
}
