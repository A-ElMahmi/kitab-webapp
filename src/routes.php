<?php
require_once __DIR__."/../vendor/autoload.php";

use Framework\RouteInfo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

// return [
//     "/hello" => new RouteInfo("HelloController"),
//     "/bye" => new RouteInfo(fn() => new Response("Bye 12345"), callback: true),
//     "/api" => new RouteInfo(fn() => new Response('{"key":"value"}', headers: ["Content-Type" => "text/json"]), callback: true),
//     "/secret" => new RouteInfo(fn() => new Response('Access granted <a href="/logout">Logout</a>'), callback: true, authRequired: true),
//     "/login" => new RouteInfo("LoginController"),
//     "/logout" => new RouteInfo(function() {
//         $_SESSION["auth"] = false;
//         return new Response('Logged out sucessfully <a href="/secret">Secret</a>');
//     }, callback: true),
// ];




$routes = new RouteCollection();

$routes->add("HelloController::GET", new Route("/hello/{name}", ["name" => "default", "_controller" => "HelloController::GET"]));
$routes->add("LoginController::GET", new Route("/login"));
// $routes->add("bye", "/bye");

return $routes;