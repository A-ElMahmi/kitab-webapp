<?php

use Framework\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;


class ApiController extends BaseController {
    public static function GET(Request $request) : Response {
        return new Response('{"key":"value"}', headers: ["Content-Type" => "text/json"]);
    }
}


$routes = new RouteCollection();

$routes->add("HelloController", new Route("/hello/{name}", ["name" => "default"]));
$routes->add("LoginController", new Route("/login"));
$routes->add("ApiController", new Route(("/api")));


return $routes;