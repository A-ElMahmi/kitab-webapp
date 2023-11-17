<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;

ini_set("display_errors", 1);
error_reporting(-1);


$request = Request::createFromGlobals();
$routes = require __DIR__."/../app/routes.php";

$context = new Routing\RequestContext();
// $context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// $compiledRoutes = (new CompiledUrlGeneratorDumper($routes))->getCompiledRoutes();
// $matcher = new CompiledUrlMatcher($compiledRoutes, $context);

$framework = new Framework\Framework($matcher);
$framework->handle($request)->send();