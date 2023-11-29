<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing;


class Framework {
    public function __construct(private Routing\Matcher\UrlMatcher $matcher) {
        Blade::init();
    }
    
    public function handle(Request $request) : Response {
        $session = new Session();
        $request->setSession($session);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $request->attributes->get("_controller");

            return call_user_func($controller, $request);
            
        } catch (Routing\Exception\ResourceNotFoundException) {
            return new Response("Page Not Found", 404);
            
        } catch (Routing\Exception\MethodNotAllowedException) {
            return new Response ("Invalid method", 405);
            
        // } catch (\Exception) {
        //     return new Response("An error occured", 500);
        }
    }
        
    
    // public function isAuthenticated() : bool {
        // Middleware
        // if ($routeInfo->authRequired && !$this->isAuthenticated()) {
        //     return new RedirectResponse("/login?redirect=" . base64_encode($_SERVER["REQUEST_URI"]));
        // }
 
    //     if (!isset($_SESSION["auth"])) {
    //         $_SESSION["auth"] = false;
    //     }
    //     return $_SESSION["auth"] === true;
    // }
}