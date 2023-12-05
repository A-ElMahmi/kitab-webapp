<?php
namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\Config;


class RouteGenerator {
    private static $appDir = __DIR__."/../../app";
    private static $routes;
    private static $cacheFolder = __DIR__."/../../cache";
    private static $cacheFile = __DIR__."/../../cache/routes.cache";

    public static function generate(Request $request) : Routing\Matcher\CompiledUrlMatcher {
        if (getenv("VERCEL_ENV") === false) {
            self::buildRoutes();
        }
        
        $context = new Routing\RequestContext();
        $context->fromRequest($request);   

        return new Routing\Matcher\CompiledUrlMatcher(self::getRoutes(), $context);
    }

    public static function buildRoutes() {
        $fileLocator = new Config\FileLocator(self::$appDir);
        $routeLoader = new Routing\Loader\YamlFileLoader($fileLocator);
        self::$routes = $routeLoader->load("routes.yaml");

        self::$routes->addCollection(StaticRoutes::generate());

        self::compileRoutes();
    }

    private static function getRoutes() : array {
        return unserialize(file_get_contents(self::$cacheFile));
    }
    
    private static function compileRoutes() {
        if (file_exists(self::$cacheFolder) === false) {
            mkdir(self::$cacheFolder, recursive: true);
        }

        if (file_exists(self::$cacheFile) && filemtime(self::$appDir . "/routes.yaml") < filemtime(self::$cacheFile)) {
            return self::getRoutes();
        }
        
        $compiledRoutes = (new Routing\Matcher\Dumper\CompiledUrlMatcherDumper(self::$routes))->getCompiledRoutes();
        file_put_contents(self::$cacheFile, serialize($compiledRoutes));
    }
}