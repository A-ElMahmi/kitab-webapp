<?php

use Framework\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends BaseController {
    public static function GET(Request $request) : Response {
        $name = $request->attributes->get("name");
        return self::renderTemplate("hello", ["name" => $name]);
    }

    public static function POST(Request $request) : Response {
        return self::renderTemplate("hello", ["name" => "success"]);
    }
}
