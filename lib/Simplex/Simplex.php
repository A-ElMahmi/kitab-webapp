<?php
namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing;


class Simplex {
    public function __construct(private Routing\Matcher\UrlMatcher $matcher) {
        Blade::init();
        \DB::connect();
    }
    
    public function handle(Request $request) : Response {
        $session = new Session();
        $request->setSession($session);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $controller = $request->attributes->get("_controller");

            return call_user_func($controller, $request);
            
        } catch (Routing\Exception\ResourceNotFoundException) {
            return $this->errorResponse(404, "Page Not Found");
            
        } catch (Routing\Exception\MethodNotAllowedException) {
            return $this->errorResponse(405, "Invalid method");
            
        // } catch (\Exception) {
        //     return $this->errorResponse(500, "An error occured");
        }
    }

    private function errorResponse(int $errorCode, string $errorMessage) : Response {
        if (file_exists(__DIR__."/../../app/views/$errorCode.blade.php")) {
            return Blade::render($errorCode);
        }

        return new Response($errorMessage, $errorCode);
    }
}