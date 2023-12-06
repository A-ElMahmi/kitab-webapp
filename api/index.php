<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;

if (@$_ENV["VERCEL_ENV"] !== "production") {
    ini_set("display_errors", 1);
    error_reporting(-1);
}


$request = Request::createFromGlobals();
// $request = Request::create("/test", "POST", content: "username=&password=");

$matcher = Simplex\RouteGenerator::generate($request);

$framework = new Simplex\Simplex($matcher);
$framework->handle($request)->send();