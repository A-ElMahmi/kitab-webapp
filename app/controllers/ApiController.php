<?php

use Framework\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class ApiController extends BaseController {
    public static function GET(Request $request) : Response {
        // return new Response('{"key":"value"}', headers: ["Content-Type" => "application/json"]);
        return new JsonResponse(["key" => "value"]);
    }
}
