<?php

use Simplex\Blade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MainController {
    public static function index(Request $request) : Response {
        DB::connect();
        
        return Blade::render("test");
    }
}