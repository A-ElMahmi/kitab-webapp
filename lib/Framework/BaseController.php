<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController {
    public static function GET(Request $request) : Response {
        return new Response("Method Not Allowed", 405);
    }

    public static function POST(Request $request) : Response {
        return new Response("Method Not Allowed", 405);
    }

    public static function PUT(Request $request) : Response {
        return new Response("Method Not Allowed", 405);
    }

    public static function DELETE(Request $request) : Response {
        return new Response("Method Not Allowed", 405);
    }
}