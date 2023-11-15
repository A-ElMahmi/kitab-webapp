<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;


$request = Request::createFromGlobals();
$routes = require __DIR__."/../src/routes.php";

$context = new Routing\RequestContext();
// $context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// $compiledRoutes = (new CompiledUrlGeneratorDumper($routes))->getCompiledRoutes();
// $matcher = new CompiledUrlMatcher($compiledRoutes, $context);


$framework = new Framework\Framework($matcher);
$framework->handle($request)->send();