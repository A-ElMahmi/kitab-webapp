<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Jenssegers\Blade\Blade;


class Framework {
    public function __construct(private Routing\Matcher\UrlMatcher $matcher) {
        BaseController::setTemplateEngine(new Blade(__DIR__."/../../app/views", __DIR__."/../../.cache"));
    }
    
    public function handle(Request $request) : Response {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $request->attributes->get("_route");
            $requestMethod = $request->server->get("REQUEST_METHOD");

            return call_user_func([$controller, $requestMethod], $request);

        } catch (Routing\Exception\ResourceNotFoundException) {
            return new Response("Page Not Found", 404);

        } catch (\Exception) {
            return new Response("An error occured", 500);
        }


        // Middleware
        // if ($routeInfo->authRequired && !$this->isAuthenticated()) {
        //     return new RedirectResponse("/login?redirect=" . base64_encode($_SERVER["REQUEST_URI"]));
        // }
    }

    // public function isAuthenticated() : bool {
    //     if (!isset($_SESSION["auth"])) {
    //         $_SESSION["auth"] = false;
    //     }
    //     return $_SESSION["auth"] === true;
    // }
}