<?php

use Simplex\Blade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class RequestProcessor {
    public static function process(Request $request) : Request {
        if (strpos($request->getPathInfo(), "static") === 0) return $request;
        
        $session = new Session();
        $request->setSession($session);

        DB::connect();
        
        Blade::init();
        Blade::share("loggedIn", $session->has("loggedIn") ? "true" : "false");

        return $request;
    }
}