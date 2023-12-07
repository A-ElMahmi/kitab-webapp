<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class RequestProcessor {
    public static function process(Request $request) : Request {
        if (strpos($request->getPathInfo(), "static") === 0) return $request;
        
        $session = new Session();
        $request->setSession($session);
        
        Simplex\Blade::init();
        DB::connect();

        return $request;
    }
}