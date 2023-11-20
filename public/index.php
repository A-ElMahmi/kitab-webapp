<?php

require_once __DIR__."/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\Config;


ini_set("display_errors", 1);
error_reporting(-1);

$request = Request::createFromGlobals();

$fileLocator = new Config\FileLocator(__DIR__."/../app");
$routeLoader = new Routing\Loader\YamlFileLoader($fileLocator);
$routes = $routeLoader->load("routes.yaml");

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// $compiledRoutes = (new CompiledUrlGeneratorDumper($routes))->getCompiledRoutes();
// $matcher = new CompiledUrlMatcher($compiledRoutes, $context);

$framework = new Framework\Framework($matcher);
$framework->handle($request)->send();