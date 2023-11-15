<?php
namespace Framework;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing;


class Framework {
    public function __construct(private Routing\Matcher\UrlMatcher $matcher) {
        // session_start();
    }
    
    public function handle(Request $request) : Response {
        try {
            $request->attributes->add($this->matcher->match(($request->getPathInfo())));
            $controller = $request->attributes->get("_route");
            $requestMethod = $request->server->get("REQUEST_METHOD");

            return call_user_func([$controller, $requestMethod], $request);
        } catch (Routing\Exception\ResourceNotFoundException) {
            return new Response("Page Not Found", 404);
        } catch (Exception) {
            return new Response("An error occured", 500);
        }


        // echo $_SERVER["REQUEST_URI"];

        // if (!isset($routes[$path])) {
        //     return new Response("Page Not Found", 404);
        // }

        // $routeInfo = $routes[$path];

        // Middleware
        // if ($routeInfo->authRequired && !$this->isAuthenticated()) {
        //     return new RedirectResponse("/login?redirect=" . base64_encode($_SERVER["REQUEST_URI"]));
        // }

        // if($routeInfo->callback) {
        //     switch (gettype($routeInfo->controller)) {
        //         case "string":
        //             return call_user_func($routeInfo->controller, $request);

        //         case "object";
        //             return $routeInfo->controller->call($request);
        //     }

        // } else {
        //     $requestMethod = $request->server->get("REQUEST_METHOD");
        //     // $requestMethod = $_SERVER["REQUEST_METHOD"];
        //     return $routeInfo->controller::$requestMethod($request);
        // }
    }

    public function isAuthenticated() : bool {
        if (!isset($_SESSION["auth"])) {
            $_SESSION["auth"] = false;
        }
        return $_SESSION["auth"] === true;
    }
}