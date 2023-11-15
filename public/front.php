<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Generator\Dumper\CompiledUrlGeneratorDumper;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;


$request = Request::createFromGlobals();
$routes = require __DIR__."/../src/routes.php";

$context = new RequestContext();
// $context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);


// $compiledRoutes = (new CompiledUrlGeneratorDumper($routes))->getCompiledRoutes();
// $matcher = new CompiledUrlMatcher($compiledRoutes, $context);

// $controllerResolver = new ControllerResolver();
// $argumentResolver = new ArgumentResolver();

$framework = new Framework\Framework($matcher);
$framework->handle($request)->send();