<?php
namespace Simplex;

use Framework\StaticRoutes;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\Config;


class RouteGenerator {
    private static $appDir = __DIR__."/../../app";
    private static $routes;

    public static function generate(Request $request) : Routing\Matcher\CompiledUrlMatcher {
        $fileLocator = new Config\FileLocator(self::$appDir);
        $routeLoader = new Routing\Loader\YamlFileLoader($fileLocator);
        self::$routes = $routeLoader->load("routes.yaml");

        self::$routes->addCollection(StaticRoutes::generate());

        $context = new Routing\RequestContext();
        $context->fromRequest($request);

        $compiledRoutes = self::compileRoutes();

        return new Routing\Matcher\CompiledUrlMatcher($compiledRoutes, $context);
    }

    private static function compileRoutes() : array {
        $cacheFile = __DIR__."/../../cache/routes.cache.php";

        if (file_exists($cacheFile) && filemtime(self::$appDir . "/routes.yaml") < filemtime($cacheFile)) {
            return unserialize(file_get_contents($cacheFile));
        }

        $compiledRoutes = (new Routing\Matcher\Dumper\CompiledUrlMatcherDumper(self::$routes))->getCompiledRoutes();
        file_put_contents($cacheFile, serialize($compiledRoutes));
        
        return $compiledRoutes;
    }
}