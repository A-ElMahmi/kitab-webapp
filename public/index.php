<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;


ini_set("display_errors", 1);
error_reporting(-1);


$request = Request::createFromGlobals();
// $request = Request::create("/test", "POST", content: "username=&password=");

$matcher = Simplex\RouteGenerator::generate($request);

$framework = new Framework\Framework($matcher);
$framework->handle($request)->send();